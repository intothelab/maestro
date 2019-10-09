<?php

namespace App\Http\Controllers;

use App\Supplier;
use App\Transporter;
use Geocoder\Laravel\Facades\Geocoder;
use Geocoder\Provider\Here\Model\HereAddress;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;

/**
 * @group Suppliers
 * @package App\Http\Controllers
 */
class SupplierController extends Controller
{

    /**
     * List Suppliers
     * @responseFactory App\Supplier collection
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Transporter::all());
    }

    /**
     * Creates a Supplier
     *
     * @authenticated
     *
     * @bodyParam name string required
     * Name of the Factory/Company (origin of the shipments). Example: Soprano
     *
     * @bodyParam email string
     * Business E-mail, not required. Example: outbound@soprano.com.br
     *
     * @bodyParam phone string required
     * Landline for specified company. Example: (51) 3214-4321
     *
     * @bodyParam cnpj string required
     * CNPJ of the company (without formatting). Example: 04256826000177
     *
     * @bodyParam address string required
     * Street address. Example: Av. Plínio Kroeff
     *
     * @bodyParam number string required
     * Number and Extra, if applied. Example: 1715, Loja B
     *
     * @bodyParam postal_code string required
     * Zip (CEP). Must be a valid number (without formatting). Example: 30441123
     *
     * @responseFactory App\Supplier
     *
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


        $supplier->location = new Point(
            $geocoded->getCoordinates()->getLatitude(),
            $geocoded->getCoordinates()->getLongitude()
        );

        $supplier->number = $geocoded->getStreetNumber();
        $supplier->address = $geocoded->getStreetName();
        $supplier->postal_code = $geocoded->getPostalCode();
        $supplier->city = $geocoded->getLocality();
        $supplier->state = $geocoded->getAdditionalData()['StateName'];
        $supplier->save();

        return response($supplier, 201)->send();
    }

    /**
     * Show one Supplier
     *
     * @queryParam id integer required
     * The id of the supplier.
     *
     * @authenticated
     * @responseFactory App\Supplier
     *
     * @param  Supplier  $supplier
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Supplier $supplier)
    {
        return response()->json($supplier);
    }

    /**
     * Updates a Supplier
     *
     * @queryParam id integer required
     * The id of the supplier.
     *
     * @bodyParam name string required
     * Name of the Factory/Company (origin of the shipments). Example: Soprano
     *
     * @bodyParam email string
     * Business E-mail, not required. Example: outbound@soprano.com.br
     *
     * @bodyParam phone string required
     * Landline for specified company. Example: (51) 3214-4321
     *
     * @bodyParam address string required
     * Street address. Example: Av. Plínio Kroeff
     *
     * @bodyParam number string required
     * Number and Extra, if applied. Example: 1715, Loja B
     *
     * @bodyParam postal_code string required
     * Zip (CEP). Must be a valid number (without formatting). Example: 30441123
     *
     *
     * @authenticated
     * @responseFactory App\Supplier
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
     * Deletes a Suplier
     *
     * @queryParam id integer required
     * The id of the supplier.
     *
     * @authenticated
     * @responseFactory App\Supplier
     *
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
