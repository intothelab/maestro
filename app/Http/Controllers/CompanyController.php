<?php

namespace App\Http\Controllers;

use App\Company;
use Geocoder\Laravel\Facades\Geocoder;
use Geocoder\Provider\Here\Model\HereAddress;
use Illuminate\Http\Request;

/**
 * @group Companies
 * @package App\Http\Controllers
 */
class CompanyController extends Controller
{

    /**
     * List all Companies
     *
     * @responseFactory App\Company collection
     *
     * @authenticated
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Company::all());
    }

    /**
     * Creates a Company
     *
     * @bodyParam name string required
     * Name of the Factory/Company (origin of the shipments). Example: Soprano
     *
     * @bodyParam email string
     * Business E-mail, not required. Example: outbound@soprano.com.br
     *
     * @bodyParam phone string required
     * Landline for specified company. Example: (51) 3214-4321
     *
     * @bodyParam cnpj string required
     * CNPJ of the company (without formatting). Example: 04256826000177
     *
     * @bodyParam address string required
     * Street address. Example: Av. Plínio Kroeff
     *
     * @bodyParam number string required
     * Number and Extra, if applied. Example: 1715, Loja B
     *
     * @bodyParam postal_code string required
     * Zip (CEP). Must be a valid number (without formatting). Example: 30441123
     *
     * @responseFactory App\Company
     * @authenticated
     * @param  Request  $request
     * @param  Company  $company
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Company $company)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email',
            'phone' => 'required',
            'cnpj' => 'required|unique:companies|cnpj',
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
     * Shows a specified Company
     *
     * @queryParam id integer required
     * The id of the company. Example: 1
     *
     * @authenticated
     * @responseFactory App\Company
     *
     * @param  Company  $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Company $company)
    {
        return response()->json($company);
    }

    /**
     * Updates a Company
     *
     * @queryParam id integer required
     * The id of the company. Example: 1
     *
     * @bodyParam name string required
     * Name of the Factory/Company (origin of the shipments). Example: Soprano
     *
     * @bodyParam email string
     * Business E-mail, not required. Example: outbound@soprano.com.br
     *
     * @bodyParam phone string required
     * Landline for specified company. Example: (51) 3214-4321
     *
     * @bodyParam address string required
     * Street address. Example: Av. Plínio Kroeff
     *
     * @bodyParam number string required
     * Number and Extra, if applied. Example: 1715, Loja B
     *
     * @bodyParam postal_code string required
     * Zip (CEP). Must be a valid number (without formatting). Example: 30441123
     *
     * @authenticated
     * @responseFactory App\Company
     *
     * @param  Request  $request
     * @param  Company  $company
     *
     * @authenticated
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
     * Deletes a Company
     *
     * @queryParam id integer required
     * The id of the company.
     *
     * @responseFactory App\Company
     * @authenticated
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
