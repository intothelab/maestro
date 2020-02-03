<?php

namespace App\Http\Controllers;

use App\Document;
use App\EDI;
use App\Jobs\ParseEDI;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * @group Documents
 * @package App\Http\Controllers
 */
class DocumentController extends Controller
{
    /**
     * Lists all Documents
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Document::all());
    }

    /**
     * Creates a Document.
     *
     * Documents must be attached to an order. Therefore it's mandatory to inform the correct `order_id`.
     *
     * @bodyParam order_id integer required
     * Refered order ID, created previously. Example: 1
     *
     * @bodyParam transporter_cnpj string
     * CNPJ of the designated transporter (without formatting). Not Mandatory. Example: 04256826000177
     *
     * @bodyParam company_cnpj string required
     * CNPJ of the company (without formatting). Example: 04256826000177
     *
     * @bodyParam phone string required
     * Landline for specified company. Example: (51) 3214-4321
     *
     * @bodyParam collected_at timestamp
     * Date of the pickup. Example: 2019-09-26 09:38:52
     *
     * @bodyParam delivered_at timestamp
     * Date of the delivery. Example: 2019-09-26 09:38:52
     *
     * @authenticated
     *
     * @param  Request  $request
     * @param  Document  $document
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Document $document)
    {
        $this->validate($request, [
            'order_id' => 'exists:orders,id',
            'order_code' => 'exists:order,code',
            'number' => 'required|unique:documents,number',
            'transporter_cnpj' => 'exists:transporters,cnpj|cnpj',
            'company_cnpj' => 'required|exists:companies,cnpj|cnpj',
            'collected_at' => 'date|before:delivered_at',
            'delivered_at' => 'date|after:collected_at'
        ]);

        if($request->has('order_id')) {
            $document->order_id = $request->order_id;
        }

        if($request->has('order_code')) {
            $order = Order::where('code', $request->input('code'))->firstOrFail();
            $document->order_id = $order->id;
        }

        $document->number = $request->number;
        $document->transporter_cnpj = $request->transporter_cnpj;
        $document->company_cnpj = $request->company_cnpj;

        $document->collected_at = $request->collected_at;
        $document->delivered_at = $request->delivered_at;
        $document->save();

        return response()->json($document, 201);
    }

    /**
     * Inserts a new EDI File
     *
     * @bodyParam data string required
     * EDI file contents. Example: 000CD SUL                             CD SUL                             246001 ...
     *
     * @response {"id":"asuo3ins0m33lks"}
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    function edi(Request $request)
    {
        $this->validate($request, [
            'data' => 'required'
        ]);

        $edi = new EDI();
        $edi->raw = $request->data;
        $edi->save();

        ParseEDI::dispatchNow($request->data, $edi->id);

        return response()->json([
            'id' => $edi->id
        ], 201);
    }

    /**
     * Inserts a new NF-E
     *
     * @bodyParam data string required
     * NF-e XML. Example: <nfeProc versao="4.00" xmlns="http://www.portalfiscal.inf.br/nfe"> ...
     *
     * @authenticated
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    function nfe(Request $request)
    {
        $this->validate($request, [
            'data' => 'required'
        ]);

        $xml = simplexml_load_string($request->data);
        $array = json_decode(json_encode($xml->NFe), TRUE);

        [$key, $version] = array_values($array['infNFe']['@attributes']);
        unset($array['infNFe']['@attributes']);

        $nfe = new \App\NFE();
        $nfe->key = $key;
        $nfe->version = $version;

        $nfe->content = $array['infNFe'];
        $nfe->save();

        return response()->json($nfe, 201);
    }

    /**
     * Shows a Document
     *
     * @queryParam id integer required
     * The id of the document.
     *
     *
     * @param  Document  $document
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Document $document)
    {
        return response()->json($document);
    }


    /**
     * Updates a Document.
     *
     * Documents must be attached to an order. Therefore it's mandatory to inform the correct `order_id`.
     *
     * @queryParam id integer required
     * The id of the document.
     *
     * @bodyParam transporter_cnpj string
     * CNPJ of the designated transporter (without formatting). Not Mandatory. Example: 04256826000177
     *
     * @bodyParam company_cnpj string required
     * CNPJ of the company (without formatting). Example: 04256826000177
     *
     * @bodyParam phone string required
     * Landline for specified company. Example: (51) 3214-4321
     *
     * @bodyParam collected_at timestamp
     * Date of the pickup. Example: 2019-09-26 09:38:52
     *
     * @bodyParam delivered_at timestamp
     * Date of the delivery. Example: 2019-09-26 09:38:52
     *
     * @authenticated
     *
     *
     * @param  Request  $request
     * @param  Document  $document
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Document $document)
    {
        $this->validate($request, [
            'transporter_cnpj' => 'exists:transporters,cnpj|cnpj',
            'company_cnpj' => 'required|exists:companies,cnpj|cnpj',
            'collected_at' => 'date|before:delivered_at',
            'delivered_at' => 'date|after:collected_at'
        ]);


        $document->update([]);

        return response()->json($document);
    }
}
