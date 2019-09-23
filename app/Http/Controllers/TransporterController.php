<?php

namespace App\Http\Controllers;

use App\Transporter;
use Geocoder\Laravel\Facades\Geocoder;
use Illuminate\Http\Request;

class TransporterController extends Controller
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
    public function store(Request $request, Transporter $transporter)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'cnpj' => 'required|unique:transporters',
            'address' => 'required',
            'number' => 'required',
            'postal_code' => 'required',
        ]);

        $transporter->name = $request->name;
        $transporter->email = strtolower($request->email);
        $transporter->phone = $request->phone;
        $transporter->cnpj = $request->cnpj;

        //Geocoding Address
        $geocodedString = implode(', ', $request->only([
            'address',
            'number',
            'postal_code'
        ]));

        $geocoded = Geocoder::geocode($geocodedString)->first();
        $transporter->latitude = $geocoded->coordinates->latitude;
        $transporter->longitude = $geocoded->coordinates->longitude;
        $transporter->number = $geocoded->streetNumber;
        $transporter->address = $geocoded->streetName;
        $transporter->postal_code = $geocoded->postalCode;
        $transporter->city = $geocoded->locality;
        $transporter->state = $geocoded->additionalData['StateName'];

        return response($transporter->save(), 201)->send();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Transporter::findOrFail($id));
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
