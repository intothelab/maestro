<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Events\CustomerCreated;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Other
 * @package App\Http\Controllers
 *
 */
class MainController extends Controller
{
    /**
     * Shows an Inspiring Note
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'version' => '1',
            'message' => Inspiring::quote(),
        ]);
    }

    /**
     * Issue an Access Token
     *
     *
     * @bodyParam grant_type string required
     * The oAuth2 Grant Type. Should be always `client_credentials`. Example: client_credentials
     *
     * @bodyParam client_id integer required
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
}
