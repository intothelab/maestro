<?php

namespace App\Http\Controllers;

use App\Supplier;
use App\Transporter;
use Geocoder\Laravel\Facades\Geocoder;
use Geocoder\Provider\Here\Model\HereAddress;
use Illuminate\Http\Request;

/**
 * @group Suppliers
 * @package App\Http\Controllers
 */
class SupplierController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Transporter::all());
    }

    /**
     * @param  Request  $request
     * @param  Supplier  $supplier
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
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
     * @param  Supplier  $supplier
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Supplier $supplier)
    {
        return response()->json($supplier);
    }

    /**
     * @param  Request  $request
     * @param  Supplier  $supplier
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
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
     * @param  Supplier  $supplier
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return response()->json($supplier);
    }
}
