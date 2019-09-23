<?php

namespace App\Http\Controllers;

use App\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shipments = Shipment::all();
        return response()->json($shipments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Shipment $shipment)
    {
        $this->validate($request, [
            'transporter_cnpj' => 'required|cnpj|exists:transporters,cnpj',
            'code' => 'unique:shipments',
            'weight' => 'required|number',
            'value' => 'required|double',
        ]);

        $shipment->transporter_cnpj = $request->transporter_cnpj;
        $shipment->code = $request->code;
        $shipment->invoice = $request->invoice;
        $shipment->weight = $request->weight;
        $shipment->value = $request->value;
        $shipment->description = $request->description;

        return response()->json($shipment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Shipment $shipment)
    {
        return response()->json($shipment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipment $shipment)
    {
        $this->validate($request, [
            'transporter_cnpj' => 'required|cnpj|exists:transporters,cnpj',
            'code' => 'unique:shipments',
            'weight' => 'required|number',
            'value' => 'required|double',
        ]);

        $shipment->transporter_cnpj = $request->transporter_cnpj;
        $shipment->code = $request->code;
        $shipment->invoice = $request->invoice;
        $shipment->weight = $request->weight;
        $shipment->value = $request->value;
        $shipment->description = $request->description;
        $shipment->save();

        return response()->json($shipment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipment $shipment)
    {
        $shipment->delete();

        return response()->json($shipment);
    }
}
