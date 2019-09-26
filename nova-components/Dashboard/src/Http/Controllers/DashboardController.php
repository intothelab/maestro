<?php

namespace Maestro\Dashboard\Http\Controllers;

use App\Customer;
use App\Transporter;
use Illuminate\Http\Request;

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
        return response()->json(Transporter::all());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function customers()
    {
        return response()->json(Customer::all());
    }

}
