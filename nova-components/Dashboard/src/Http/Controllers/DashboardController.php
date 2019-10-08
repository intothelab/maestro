<?php

namespace Maestro\Dashboard\Http\Controllers;

use App\Company;
use App\Transporter;
use App\Document;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * @group Transporter
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
            $transporter->delivered_count = count($transporter->documents)==0?1:count($transporter->documents);
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

            $transporter->delivered_average = number_format((($transporter->delivered_expected_count*100)/$transporter->delivered_count), 2, '.', '');
            if($previous_month_count != 0){
                $transporter->previous_month_average = number_format((($previous_month_expected_count*100)/$previous_month_count), 2, '.', '');
            }else{
                $transporter->previous_month_average = 0;
            }

            $transporter->trend = number_format((($transporter->previous_month_average/$transporter->delivered_average)*100), 2, '.', '');

            unset($transporter->documents);
        }

        return response()->json($transporters);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function companies()
    {
        $companies_ids = Document::select('company_cnpj')
            ->where('delivered_at', '>=', Carbon::now()->startOfYear()->toDateString())
            ->where('delivered_at', '<=', Carbon::now()->toDateString())
            ->whereNotNull('expected_at')
            ->groupBy('company_cnpj')
            ->pluck('company_cnpj');

        $companies = Company::select(['name','cnpj'])
            ->whereIn('cnpj', $companies_ids)
            ->with(array('documents' => function($query) {
                $query->where('delivered_at', '>=', Carbon::now()->startOfYear()->toDateString());
                $query->where('delivered_at', '<=', Carbon::now()->toDateString());
                $query->whereNotNull('expected_at');
            }))
            ->get();

        foreach ($companies as $company) {
            $company->delivered_count = count($company->documents)==0?1:count($company->documents);
            collect($company->documents)
                ->map(function ($item) {
                    $item->later = !Carbon::createFromFormat('Y-m-d H:i:s', $item->delivered_at)->lessThanOrEqualTo(Carbon::createFromFormat('Y-m-d H:i:s', $item->expected_at));
                    return $item;
                })->all();

            $dt_previous_month = Carbon::now()->startOfMonth()->subMonth();

            $previous_month_count = collect($company->documents)
                ->where('delivered_at', '>=', $dt_previous_month->toDateString())
                ->where('delivered_at', '<=', $dt_previous_month->endOfMonth()->toDateString())
                ->count();

            $previous_month_expected_count = collect($company->documents)
                ->where('delivered_at', '>=', $dt_previous_month->toDateString())
                ->where('delivered_at', '<=', $dt_previous_month->endOfMonth()->toDateString())
                ->where('later', false)
                ->count();

            $company->delivered_expected_count = collect($company->documents)->where('later', false)->count();
            $company->delivered_late_count = collect($company->documents)->where('later', true)->count();

            $company->delivered_average = number_format((($company->delivered_expected_count*100)/$company->delivered_count), 2, '.', '');
            if($previous_month_count != 0){
                $company->previous_month_average = number_format((($previous_month_expected_count*100)/$previous_month_count), 2, '.', '');
            }else{
                $company->previous_month_average = 0;
            }

            $company->trend = number_format((($company->previous_month_average/$company->delivered_average)*100), 2, '.', '');

            unset($company->documents);
        }

        return response()->json($companies);
    }

}
