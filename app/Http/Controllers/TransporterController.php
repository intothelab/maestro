<?php

namespace App\Http\Controllers;

use App\Transporter;
use Geocoder\Laravel\Facades\Geocoder;
use Geocoder\Provider\Here\Model\HereAddress;
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
            'cnpj' => 'required|unique:transporters|cnpj',
            'address' => 'required',
            'number' => 'required',
            'postal_code' => 'required',
        ]);

        $transporter->name = $request->name;
        $transporter->email = strtolower($request->email);
        $transporter->phone = $request->phone;
        $transporter->cnpj = $request->cnpj;
        $transporter->code = $request->code;

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


        $transporter->latitude = $geocoded->getCoordinates()->getLatitude();
        $transporter->longitude = $geocoded->getCoordinates()->getLongitude();
        $transporter->number = $geocoded->getStreetNumber();
        $transporter->address = $geocoded->getStreetName();
        $transporter->postal_code = $geocoded->getPostalCode();
        $transporter->city = $geocoded->getLocality();
        $transporter->state = $geocoded->getAdditionalData()['StateName'];
        $transporter->save();

        return response($transporter, 201)->send();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transporter $transporter)
    {
        return response()->json($transporter);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transporter $transporter)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'number' => 'required',
            'postal_code' => 'required',
        ]);

        $transporter->update([
            'code' => $request->code,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'number' => $request->number,
            'postal_code' => $request->postal_code
        ]);

        return response()->json($transporter);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transporter $transporter)
    {
        $transporter->delete();
        return response()->json($transporter);
    }
}
