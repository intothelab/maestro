<?php

namespace App\Http\Controllers;

use Geocoder\Laravel\Facades\Geocoder;
use Geocoder\Provider\Here\Model\HereAddress;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param  Request  $request
     * @return HereAddress
     */
    protected function getCoordinates(Request $request){
                //Geocoding Address
        $geocodedString = implode(', ', $request->only([
            'address',
            'number',
            'postal_code'
        ]));

        /** @var HereAddress $geocoded */
        $geocoded = Geocoder::geocode($geocodedString)
            ->get()
            ->first();

        if($geocoded === null){
            $geocoded = Geocoder::geocode($request->input('postal_code'))
                ->get()
                ->first();
        }

        if($geocoded === null){
            throw new UnprocessableEntityHttpException('Address and Post Code combination does not result in a valid geocode');
        }

        return $geocoded;
}
}
