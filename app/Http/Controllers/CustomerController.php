<?php

namespace App\Http\Controllers;

use App\Customer;
use Geocoder\Laravel\Facades\Geocoder;
use Geocoder\Provider\Here\Model\HereAddress;
use Illuminate\Http\Request;

/**
 * @group Customers
 * @package App\Http\Controllers
 */
class CustomerController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Customer::all());
    }

    /**
     * Creates a Customer
     *
     * @bodyParam name string required
     * Name of the Customer. Example: dCasa Ferragens LTDA
     *
     * @bodyParam email string
     * Business E-mail, not required. Example: comercial@dcasa.com.br
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
     * @authenticated
     * @param  Request  $request
     * @param  Customer  $customer
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Customer $customer)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'cnpj' => 'required|unique:customers|cnpj',
            'address' => 'required',
            'number' => 'required',
            'postal_code' => 'required',
        ]);

        $customer->name = $request->name;
        $customer->email = strtolower($request->email);
        $customer->phone = $request->phone;
        $customer->cnpj = $request->cnpj;
        $customer->code = $request->code;

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


        $customer->latitude = $geocoded->getCoordinates()->getLatitude();
        $customer->longitude = $geocoded->getCoordinates()->getLongitude();
        $customer->number = $geocoded->getStreetNumber();
        $customer->address = $geocoded->getStreetName();
        $customer->postal_code = $geocoded->getPostalCode();
        $customer->city = $geocoded->getLocality();
        $customer->state = $geocoded->getAdditionalData()['StateName'];
        $customer->save();

        return response($customer, 201)->send();
    }

    /**
     * @param  Customer  $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Customer $customer)
    {
        return response()->json($customer);
    }

    /**
     * Updates a Customer
     *
     * @bodyParam name string required
     * Name of the Customer. Example: dCasa Ferragens LTDA
     *
     * @bodyParam email string
     * Business E-mail, not required. Example: comercial@dcasa.com.br
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
     * @param  Request  $request
     * @param  Customer  $customer
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Customer $customer)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'number' => 'required',
            'postal_code' => 'required',
        ]);

        $customer->update([
            'code' => $request->code,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'number' => $request->number,
            'postal_code' => $request->postal_code
        ]);

        return response()->json($customer);
    }

    /**
     * @param  Customer  $customer
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json($customer);
    }
}
