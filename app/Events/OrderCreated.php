<?php

namespace App\Events;

use App\Order;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrderCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        /** @var Client $client */
        $client = resolve('AdrClient');

        $adrCompanyQuery = $client->post('/enterprise/search', [
            'json' => [
                'enterprise_cnpj' => $order->company_cnpj
            ],
            'http_errors' => false
        ]);

        if($adrCompanyQuery->getStatusCode() === 404){
            $adrCompanyQuery = $client->post('/enterprise/create', [
                'form_params' => [
                    'Enterprise[enterprise_name]' => $order->company->name,
                    'Enterprise[enterprise_cnpj]' => $order->company->cnpj,
                    'Enterprise[enterprise_address]' => $order->company->address,
                ]
            ]);
        }

        $adrCompanyID = json_decode($adrCompanyQuery->getBody()->getContents())->enterprise_id;
        $adrCustomerID = $order->customer->adr_id;

        try {
            $adrRemittance = $client->post('/remittance/create', [
                'form_params' => [
                    'Remittance[customer_id]' => $adrCustomerID,
                    'Remittance[company_id]' => $adrCompanyID,
                    'Remittance[remittance_code]' => $order->code,
                    'Remittance[remittance_date]' => Carbon::parse($order->created_at)->format('Y-m-d'),
                    'Remittance[remittance_standalone]' => 0,
                    'Remittance[remittance_status]' => 'open',
                    'Remittance[remittance_weight]' => $order->weight,
                    'Remittance[remittance_value]' => $order->value,
                    'Remittance[remittance_desc]' => json_encode([
                        'maestro_order_id' => $order->id,
                        'maestro_imported_at' => Carbon::now()
                    ])
                ]
            ]);
        } catch (RequestException $exception){
            Log::error('Failed to save order into ADR.', [
                'id' => $order->id
            ]);
        }

        $order->adr_id = json_decode($adrRemittance->getBody()->getContents())->remittance_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
