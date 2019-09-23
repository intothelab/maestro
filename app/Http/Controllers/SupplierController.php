<?php

namespace App\Http\Controllers;

use App\Supplier;
use App\Transporter;
use Geocoder\Laravel\Facades\Geocoder;
use Geocoder\Provider\Here\Model\HereAddress;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Transporter::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Supplier $supplier)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'cnpj' => 'required|unique:transporters|cnpj',
            'address' => 'required',
            'number' => 'required',
            'postal_code' => 'required',
        ]);

        $supplier->name = $request->name;
        $supplier->email = strtolower($request->email);
        $supplier->phone = $request->phone;
        $supplier->cnpj = $request->cnpj;
        $supplier->code = $request->code;

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


        $supplier->latitude = $geocoded->getCoordinates()->getLatitude();
        $supplier->longitude = $geocoded->getCoordinates()->getLongitude();
        $supplier->number = $geocoded->getStreetNumber();
        $supplier->address = $geocoded->getStreetName();
        $supplier->postal_code = $geocoded->getPostalCode();
        $supplier->city = $geocoded->getLocality();
        $supplier->state = $geocoded->getAdditionalData()['StateName'];
        $supplier->save();

        return response($supplier, 201)->send();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        return response()->json($supplier);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'number' => 'required',
            'postal_code' => 'required',
        ]);

        $supplier->update([
            'code' => $request->code,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'number' => $request->number,
            'postal_code' => $request->postal_code
        ]);

        return response()->json($supplier);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return response()->json($supplier);
    }
}
