<?php

namespace App\Http\Controllers;

use App\Customer;
use Geocoder\Laravel\Facades\Geocoder;
use Geocoder\Provider\Here\Model\HereAddress;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * @group Customers
 * @package App\Http\Controllers
 */
class CustomerController extends Controller
{

    /**
     * Lists all Customers
     *
     * @responseFactory App\Customer collection
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Customer::all());
    }

    /**
     * Creates a Customer
     *
     * @bodyParam code string required
     * External Reference of the Customer (Totvs or SAP, for example). Example: 1234
     *
     * @bodyParam name string required
     * Name of the Customer. Example: dCasa Ferragens LTDA
     *
     * @bodyParam email string
     * Business E-mail, not required. Example: comercial@dcasa.com.br
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
     * Zip (CEP). Must be a valid number (without formatting). Example: 91150170
     *
     * @responseFactory App\Customer
     *
     * @authenticated
     * @param  Request  $request
     * @param  Customer  $customer
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Customer $customer)
    {
        $this->validate($request, [
            'code' => 'required|unique:customers,code',
            'name' => 'required',
            'email' => 'required|email',
            'cnpj' => 'required|unique:customers,cnpj|cnpj|digits:14',
            'address' => 'required',
            'number' => 'required',
            'postal_code' => 'required',
        ]);

        $customer->name = $request->name;
        $customer->email = strtolower($request->email);
        $customer->phone = $request->phone;
        $customer->cnpj = $request->cnpj;
        $customer->code = $request->code;

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

        if($geocoded === null){
            throw new UnprocessableEntityHttpException('Address and Post Code combination does not result in a valid geocode');
        }

        $customer->location = new Point(
            $geocoded->getCoordinates()->getLatitude(),
            $geocoded->getCoordinates()->getLongitude()
        );

        $customer->number = $request->input('number');
        $customer->address = $geocoded->getStreetName() ?? $request->input('address');
        $customer->postal_code = $geocoded->getPostalCode();
        $customer->city = $geocoded->getLocality();
        $customer->state = $geocoded->getAdditionalData()['StateName'];
        $customer->save();

        return response($customer, 201)->send();
    }

    /**
     * Shows a Customer
     *
     * @queryParam ref mixed required The id or code of the customer.
     *
     * @responseFactory App\Customer
     *
     * @authenticated
     * @param  Customer  $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($ref)
    {
        $customer = Customer::where('code', $ref)
            ->orWhere('id', $ref)
            ->first();

        return response()->json($customer);
    }

    /**
     * Updates a Customer
     *
     * @queryParam ref string required
     * The id or code of the customer.
     *
     * @bodyParam name string required
     * Name of the Customer. Example: dCasa Ferragens LTDA
     *
     * @bodyParam email string
     * Business E-mail, not required. Example: comercial@dcasa.com.br
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
     * Zip (CEP). Must be a valid number (without formatting). Example: 91150170
     *
     * @responseFactory App\Customer
     * @authenticated
     * @param  Request  $request
     * @param  Customer  $customer
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $ref)
    {
        $customer = Customer::where('code', $ref)
            ->orWhere('id', $ref)
            ->first();

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'number' => 'required',
            'postal_code' => 'required',
        ]);

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'number' => $request->number,
            'postal_code' => $request->postal_code
        ]);

        return response()->json($customer);
    }

    /**
     * Deletes a Customer
     *
     * @queryParam ref string required
     * The id or code of the customer.
     *
     * @responseFactory App\Customer
     *
     * @authenticated
     * @param  Customer  $customer
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($ref)
    {
        $customer = Customer::where('code', $ref)
            ->orWhere('id', $ref)
            ->first();

        $customer->delete();

        return response()->json($customer);
    }
}
