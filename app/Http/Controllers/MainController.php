<?php

namespace App\Http\Controllers;

use App\EDI;
use App\Jobs\ParseEDI;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 *
 * @group General
 * @package App\Http\Controllers
 *
 * # Level 1 Header
 */
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
     * Issue an Access Token
     *
     *
     * @bodyParam grant_tupe string required
     * The oAuth2 Grant Type. Should be always `client_credentials`. Example: client_credentials
     *
     * @bodyParam client_id number required
     * Provided Client ID. Example: 1
     *
     * @bodyParam client_secret string required
     * Provided Secret. Example: S29T3R3AiH8vcINAFrRtW3wpUEwjLoa87zVV8ZNp
     *
     * @response {"token_type":"Bearer","expires_in":631152000,"access_token":"eyJ0eXAiO..."}
     *
     *
     * @group Authentication
     * @param  Request  $request
     * @return mixed
     *
     */
    public function auth(Request $request){
        return \App::call('\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
    }

    /**
     * Inserts a new NF-E
     *
     * @bodyParam data string required
     * NF-e XML. Example: <?xml version="1.0" encoding="UTF-8"?><nfeProc versao="4.00" xmlns="http://www.portalfiscal.inf.br/nfe"> ...
     *
     * @authenticated
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
     * Inserts a new EDI File
     *
     * @bodyParam data string required
     * EDI file contents. Example: 000CD SUL                             CD SUL                             2406191201OCO502406001 ...
     *
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
