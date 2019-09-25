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
