<?php

namespace App\Http\Controllers;

use App\Transporter;
use Geocoder\Laravel\Facades\Geocoder;
use Geocoder\Provider\Here\Model\HereAddress;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * @group Transporters
 * @package App\Http\Controllers
 */
class TransporterController extends Controller
{
    /**
     * Lists all Transporters
     *
     * @authenticated
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Transporter::all());
    }

    /**
     * Creates a Transporter
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
     * CNPJ of the transporter (without formatting). Example: 04256826000177
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
     * @responseFactory App\Transporter
     * @param  Request  $request
     * @param  Transporter  $transporter
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
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

        if($geocoded === null){
            throw new UnprocessableEntityHttpException('Address and Post Code combination does not result in a valid geocode');
        }

        $transporter->location = new Point(
            $geocoded->getCoordinates()->getLatitude(),
            $geocoded->getCoordinates()->getLongitude()
        );

        $transporter->number = $geocoded->getStreetNumber();
        $transporter->address = $geocoded->getStreetName();
        $transporter->postal_code = $geocoded->getPostalCode();
        $transporter->city = $geocoded->getLocality();
        $transporter->state = $geocoded->getAdditionalData()['StateName'];
        $transporter->save();

        return response($transporter, 201)->send();
    }

    /**
     * Shows a Transporter
     *
     * @queryParam id integer required
     * The id of the transporter.
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
     * CNPJ of the transporter (without formatting). Example: 04256826000177
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
     * @authenticated
     * @responseFactory App\Transporter
     * @param  Transporter  $transporter
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Transporter $transporter)
    {
        return response()->json($transporter);
    }

    /**
     * Updates a Transporter
     *
     * @queryParam id integer required
     * The id of the transporter.
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
     * CNPJ of the transporter (without formatting). Example: 04256826000177
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
     * @authenticated
     * @responseFactory App\Transporter
     * @param  Request  $request
     * @param  Transporter  $transporter
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
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
     * Deletes a Transporter
     *
     * @queryParam id integer required
     * The id of the transporter.
     *
     * @responseFactory App\Transporter
     * @authenticated
     *
     * @param  Transporter  $transporter
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Transporter $transporter)
    {
        $transporter->delete();
        return response()->json($transporter);
    }
}
