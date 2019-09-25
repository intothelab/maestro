<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @group Events
 * @package App\Http\Controllers
 */
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
