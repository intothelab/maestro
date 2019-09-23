<?php

namespace App\Http\Controllers;

use App\Customer;
use Geocoder\Laravel\Facades\Geocoder;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Customer::all());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Customer $customer)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'cnpj' => 'required|unique:customers',
            'address' => 'required',
            'number' => 'required',
            'postal_code' => 'required',
        ]);

        $customer->name = $request->name;
        $customer->email = strtolower($request->email);
        $customer->phone = $request->phone;
        $customer->cnpj = $request->cnpj;

        //Geocoding Address
        $geocodedString = implode(', ', $request->only([
            'address',
            'number',
            'postal_code'
        ]));

        $geocoded = Geocoder::geocode($geocodedString)->first();
        $customer->latitude = $geocoded->coordinates->latitude;
        $customer->longitude = $geocoded->coordinates->longitude;
        $customer->number = $geocoded->streetNumber;
        $customer->address = $geocoded->streetName;
        $customer->postal_code = $geocoded->postalCode;
        $customer->city = $geocoded->locality;
        $customer->state = $geocoded->additionalData['StateName'];

        return response($customer->save(), 201)->send();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
