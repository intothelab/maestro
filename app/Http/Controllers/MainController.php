<?php

namespace App\Http\Controllers;

use App\Jobs\ParseEDI;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {
        return response()->json([
            'version' => '1',
            'auth' =>  Auth::guest() ? Auth::user() : null,
            'message' => Inspiring::quote(),
        ]);
    }

    function edi(Request $request)
    {
        $this->validate($request, [
            'data' => 'required'
        ]);

        $parsing = ParseEDI::dispatchNow($request->data);

        return response()->json([
            'message' => 'EDI parsed sucessfully'
        ], 201);
    }
}
