<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::all());
    }

    public function store(Request $request, Order $order){

        $this->validate($request, [
            'company_cnpj' => 'required|exists:companies,cnpj|cnpj',
            'customer_cnpj' => 'required|exists:customer_cnpj|cnpj',
            'code' => 'unique:orders',
            'value' => 'double',
            'weight' => 'number'
        ]);

        $order->company_cnpj = $request->company_cnpj;
        $order->customer_cnpj = $request->customer_cnpj;
        $order->code = $request->code;
        $order->value = $request->value;
        $order->weight = $request->weight;
        $order->save();

        return response()->json($order, 201);
    }

    public function show(Order $order)
    {
        return response()->json($order);
    }


    public function update(Request $request, Order $order)
    {
        $order->update($request->all());
        return response()->json($order);
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json($order);
    }
}
