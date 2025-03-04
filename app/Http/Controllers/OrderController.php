<?php

namespace App\Http\Controllers;

use App\Company;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @group Orders
 * @package App\Http\Controllers
 */
class OrderController extends Controller
{
    /**
     * Lists all Orders
     *
     * @responseFactory App\Order collection
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Order::all());
    }

    /**
     * Creates an Order.
     *
     * Orders are, in most scenarios a sell invoice. One order might have several shipments (n:n relation).
     *
     * @bodyParam customer_cnpj string required
     * CNPJ of the customer (without formatting). Example: 04256826000177
     *
     * @bodyParam company_cnpj string required
     * CNPJ of the company (without formatting). Example: 04256826000177
     *
     * @bodyParam code string required
     * Internal code of the order (E.g: IDs from Totvs or SAP). Example: #ABC-1234-XWL
     *
     * @bodyParam value number required
     * Total amount of the order, with taxes (in BRL). Example: 150000.45
     *
     * @bodyParam weight number
     * Total weight of the order (in KG). Example: 75.30
     *
     * @returnFactory App\Order
     *
     * @authenticated
     * @responseFactory App\Order
     *
     * @param  Request  $request
     * @param  Order  $order
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request){

        $this->validate($request, [
            'company_cnpj' => 'required|exists:companies,cnpj',
            'customer_cnpj' => 'required|exists:customers,cnpj',
            'code' => 'unique:orders'
        ]);

        DB::beginTransaction();

        try {
            $order = new Order();
            $order->company_cnpj = $request->company_cnpj;
            $order->customer_cnpj = $request->customer_cnpj;
            $order->code = $request->code;
            $order->value = str_replace(',', '.', $request->value);
            $order->weight = str_replace(',', '.', $request->weight);
            $order->cubic_weight = str_replace(',', '.', $request->weight);
            $order->branch = $request->branch;
            $order->save();
        } catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }

        DB::commit();

        return response()->json($order, 201);
    }

    /**
     * Shows an Order
     *
     * @queryParam ref mixed required
     * The id or code of the order.
     *
     * @authenticated
     * @responseFactory App\Order
     *
     * @param  Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($ref)
    {
        $order = Order::where('code', $ref)
            ->orWhere('id', $ref)
            ->firstOrFail();

        return response()->json($order);
    }


    /**
     * Creates an Order.
     *
     * Orders are, in most scenarios a sell invoice. One order might have several shipments (n:n relation).
     *
     * @bodyParam customer_cnpj string required
     * CNPJ of the customer (without formatting). Example: 04256826000177
     *
     * @bodyParam company_cnpj string required
     * CNPJ of the company (without formatting). Example: 04256826000177
     *
     * @bodyParam value number required
     * Total amount of the order, with taxes (in BRL). Example: 150000.45
     *
     * @bodyParam weight number
     * Total weight of the order (in KG). Example: 75.30
     *
     * @authenticated
     * @responseFactory App\Order
     *
     * @param  Request  $request
     * @param  Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $ref)
    {

        $order = Order::where('code', $ref)
            ->orWhere('id', $ref)
            ->firstOrFail();

        $order->company_cnpj = $request->company_cnpj;
        $order->customer_cnpj = $request->customer_cnpj;
        $order->code = $request->code;
        $order->value = str_replace(',', '.', $request->value);
        $order->weight = str_replace(',', '.', $request->weight);
        $order->save();

        return response()->json($order);
    }

    /**
     * Deletes an Order
     * @queryParam id integer required
     * The id of the document.
     *
     * @authenticated
     * @responseFactory App\Order
     * @param  mixed $ref Order ID or External Code
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($ref)
    {
        $order = Order::where('code', $ref)
            ->orWhere('id', $ref)
            ->firstOrFail();

        $order->delete();

        return response()->json($order);
    }
}
