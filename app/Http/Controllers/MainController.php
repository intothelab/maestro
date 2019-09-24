<?php

namespace App\Http\Controllers;

use App\EDI;
use App\Jobs\ParseEDI;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'version' => '1',
            'auth' =>  Auth::guest() ? Auth::user() : null,
            'message' => Inspiring::quote(),
        ]);
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    function nfe(Request $request)
    {
        $this->validate($request, [
            'data' => 'required'
        ]);

        $xml = simplexml_load_string($request->data);
        $array = json_decode(json_encode($xml->NFe), TRUE);

        list($key, $version) = array_values($array['infNFe']['@attributes']);
        unset($array['infNFe']['@attributes']);

        $nfe = new \App\NFE();
        $nfe->key = $key;
        $nfe->version = $version;

        $nfe->content = $array['infNFe'];
        $nfe->save();

        return response()->json($nfe, 201);
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    function edi(Request $request)
    {
        $this->validate($request, [
            'data' => 'required'
        ]);

        $edi = new EDI();
        $edi->raw = $request->data;
        $edi->save();

        ParseEDI::dispatchNow($request->data, $edi->id);

        return response()->json([
            'id' => $edi->id
        ], 201);
    }
}
