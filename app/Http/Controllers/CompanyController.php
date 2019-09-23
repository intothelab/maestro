<?php

namespace App\Http\Controllers;

use App\Company;
use Geocoder\Laravel\Facades\Geocoder;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Company::all());
    }

    public function store(Request $request, Company $company)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'cnpj' => 'required|unique:companies',
            'address' => 'required',
            'number' => 'required',
            'postal_code' => 'required',
        ]);

        $company->name = $request->name;
        $company->email = strtolower($request->email);
        $company->phone = $request->phone;
        $company->cnpj = $request->cnpj;

        //Geocoding Address
        $geocodedString = implode(', ', $request->only([
            'address',
            'number',
            'postal_code'
        ]));

        $geocoded = Geocoder::geocode($geocodedString)->first();
        $company->latitude = $geocoded->coordinates->latitude;
        $company->longitude = $geocoded->coordinates->longitude;
        $company->number = $geocoded->streetNumber;
        $company->address = $geocoded->streetName;
        $company->postal_code = $geocoded->postalCode;
        $company->city = $geocoded->locality;
        $company->state = $geocoded->additionalData['StateName'];

        return response($company->save(), 201)->send();
    }
}
