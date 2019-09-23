<?php

namespace App\Http\Controllers;

use App\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $shipments = Shipment::all();
        return response()->json($shipments);
    }

    /**
     * @param  Request  $request
     * @param  Shipment  $shipment
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
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
     * @param  Shipment  $shipment
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Shipment $shipment)
    {
        return response()->json($shipment);
    }

    /**
     * @param  Request  $request
     * @param  Shipment  $shipment
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
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
     * @param  Shipment  $shipment
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Shipment $shipment)
    {
        $shipment->delete();

        return response()->json($shipment);
    }
}
