<?php

namespace App\Http\Controllers;

use App\Document;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Document::all());
    }

    public function store(Request $request, Document $document)
    {
        $this->validate($request, [
            'number' => 'required|unique:documents,number',
            'transporter_cnpj' => 'exists:transporters,cnpj|cnpj',
            'company_cnpj' => 'required|exists:companies,cnpj|cnpj',
            'order_id' => 'required|exists:orders,id',
            'collected_at' => 'date|before:delivered_at',
            'delivered_at' => 'date|after:collected_at'
        ]);

        $document->number = $request->number;
        $document->transporter_cnpj = $request->transporter_cnpj;
        $document->company_cnpj = $request->company_cnpj;
        $document->order_id = $request->order_id;
        $document->collected_at = $request->collected_at;
        $document->delivered_at = $request->delivered_at;
        $document->save();

        return response()->json($document, 201);
    }

    public function show(Document $document)
    {
        return response()->json($document);
    }


    public function update(Request $request, Document $document)
    {
        $this->validate($request, [
            'transporter_cnpj' => 'exists:transporters,cnpj|cnpj',
            'company_cnpj' => 'required|exists:companies,cnpj|cnpj',
            'order_id' => 'required|exists:orders,id',
            'collected_at' => 'date|before:delivered_at',
            'delivered_at' => 'date|after:collected_at'
        ]);

        $document->update($request->all());

        return response()->json($document);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        return response()->json($document);
    }
}
