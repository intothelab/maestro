<?php

namespace Maestro\Dashboard\Http\Controllers;

use App\Customer;
use App\Transporter;
use App\Document;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * @group Customers
 * @package \App\Http\Controller
 */
class DashboardController extends \App\Http\Controllers\Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function transporters()
    {
        $transporter_ids = Document::select('transporter_cnpj')
            ->where('delivered_at', '>=', Carbon::now()->startOfYear()->toDateString())
            ->where('delivered_at', '<=', Carbon::now()->toDateString())
            ->whereNotNull('expected_at')
            ->groupBy('transporter_cnpj')
            ->pluck('transporter_cnpj');

        $transporters = Transporter::select(['name','cnpj'])
            ->whereIn('cnpj', $transporter_ids)
            ->with(array('documents' => function($query) {
                $query->where('delivered_at', '>=', Carbon::now()->startOfYear()->toDateString());
                $query->where('delivered_at', '<=', Carbon::now()->toDateString());
                $query->whereNotNull('expected_at');
            }))
            ->get();

        foreach ($transporters as $transporter) {
            $transporter->delivered_count = count($transporter->documents);
            collect($transporter->documents)
                ->map(function ($item) {
                    $item->later = !Carbon::createFromFormat('Y-m-d H:i:s', $item->delivered_at)->lessThanOrEqualTo(Carbon::createFromFormat('Y-m-d H:i:s', $item->expected_at));
                    return $item;
                })->all();

            $dt_previous_month = Carbon::now()->startOfMonth()->subMonth();

            $previous_month_count = collect($transporter->documents)
                ->where('delivered_at', '>=', $dt_previous_month->toDateString())
                ->where('delivered_at', '<=', $dt_previous_month->endOfMonth()->toDateString())
                ->count();

            $previous_month_expected_count = collect($transporter->documents)
                ->where('delivered_at', '>=', $dt_previous_month->toDateString())
                ->where('delivered_at', '<=', $dt_previous_month->endOfMonth()->toDateString())
                ->where('later', false)
                ->count();

            $transporter->delivered_expected_count = collect($transporter->documents)->where('later', false)->count();
            $transporter->delivered_late_count = collect($transporter->documents)->where('later', true)->count();
            $transporter->delivered_average = ($transporter->delivered_expected_count*100)/$transporter->delivered_count;
            if($previous_month_count != 0){
                $transporter->previous_month_average = ($previous_month_expected_count*100)/$previous_month_count;
            }else{
                $transporter->previous_month_average = 0;
            }
            $transporter->trend = ($transporter->previous_month_average/$transporter->delivered_average)*100;
            unset($transporter->documents);
        }

        return response()->json($transporters);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function customers()
    {
        return response()->json(Customer::all());
    }

}
