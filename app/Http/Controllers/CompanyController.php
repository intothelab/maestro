<?php

namespace App\Http\Controllers;

use App\Company;
use Geocoder\Laravel\Facades\Geocoder;
use Geocoder\Provider\Here\Model\HereAddress;
use Illuminate\Http\Request;

/**
 * Class CompanyController
 * @package App\Http\Controllers
 */
class CompanyController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Company::all());
    }

    /**
     * @param  Request  $request
     * @param  Company  $company
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Company $company)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'cnpj' => 'required|unique:companys|cnpj',
            'address' => 'required',
            'number' => 'required',
            'postal_code' => 'required',
        ]);

        $company->name = $request->name;
        $company->email = strtolower($request->email);
        $company->phone = $request->phone;
        $company->cnpj = $request->cnpj;
        $company->code = $request->code;

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


        $company->latitude = $geocoded->getCoordinates()->getLatitude();
        $company->longitude = $geocoded->getCoordinates()->getLongitude();
        $company->number = $geocoded->getStreetNumber();
        $company->address = $geocoded->getStreetName();
        $company->postal_code = $geocoded->getPostalCode();
        $company->city = $geocoded->getLocality();
        $company->state = $geocoded->getAdditionalData()['StateName'];
        $company->save();

        return response($company, 201)->send();
    }

    /**
     * @param  Company  $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Company $company)
    {
        return response()->json($company);
    }

    /**
     * @param  Request  $request
     * @param  Company  $company
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Company $company)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'number' => 'required',
            'postal_code' => 'required',
        ]);

        $company->update([
            'code' => $request->code,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'number' => $request->number,
            'postal_code' => $request->postal_code
        ]);

        return response()->json($company);
    }

    /**
     * @param  Company  $company
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return response()->json($company);
    }
}
