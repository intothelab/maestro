<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Uhin\X12Parser\Parser\X12Parser;

class EventController extends Controller
{
    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        return response()->json([
            'error' => 'method yet not defined'
        ], 400);
    }
}
