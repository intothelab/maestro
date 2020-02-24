<?php

namespace App\Events;

use App\Customer;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CustomerCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Customer $customer)
    {
        /** @var Client $client */
        $client = resolve('AdrClient');

        $searchCustomer = $client->post('/customer/search', [
            'json' => [
                'customer_cpf_cnpj' => $customer->cnpj
            ],
            'http_errors' => false
        ]);



        if($searchCustomer->getStatusCode() === 404){
            Log::info('Customer not found in ADR. Saving it.');

            try {
                $adrCityRequest = $client->post('/city/search', [
                    'json' => [
                        'city_name' => $customer->city
                    ],
                    'http_errors' => false
                ]);

                if($adrCityRequest->getStatusCode() === 404){
                    throw new \Exception('City not fount: '.$customer->city);
                }


            } catch (RequestException $exception){
                Log::error('An error happened while trying to find the city on ADR', [
                    'city_name' => $customer->city
                ]);

                throw $exception;
            }

            $adrCity = json_decode($adrCityRequest->getBody()->getContents());

            try {

                $adrCustomer = $client->post('/customer/create', [
                    'form_params' => [
                        'Customer[customer_name]' => $customer->name,
                        'Customer[customer_code]' => $customer->code,
                        'Customer[customer_cpf_cnpj]' => $customer->cnpj,
                        'Customer[customer_phone]' => $customer->phone,
                        'Customer[customer_email]' => $customer->email,
                        'Customer[customer_address]' => $customer->address,
                        'Customer[state_id]' => $adrCity->state_id,
                        'Customer[city_id]' => $adrCity->city_id,
                        'Customer[customer_cep]' => $customer->postal_code,
                        'Customer[customer_lat]' => $customer->location->getLat(),
                        'Customer[customer_lon]' => $customer->location->getLng(),
                    ]
                ]);

            } catch(RequestException $exception) {
                Log::error('Error saving the customer into ADR.', [
                    'id' => $customer->id
                ]);

                throw $exception;
            }

            $customer->adr_id = json_decode($adrCustomer->getBody()->getContents())->customer_id ;
        } else {
            Log::info('Customer found in ADR. Associating with our registry.');
            $customer->adr_id = json_decode($searchCustomer->getBody()->getContents())->customer_id;
        }

        $customer->save();
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
