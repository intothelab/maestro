<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth', 'MainController@auth');
Route::get('/', 'MainController@index');

Route::middleware(['client', 'api'])->group(function(){
    Route::resource('/suppliers', 'SupplierController');
    Route::resource('/companies', 'CompanyController');
    Route::resource('/customers', 'CustomerController');

    Route::post('/documents/edi', 'MainController@edi');
    Route::post('/documents/nfe', 'MainController@nfe');
    Route::resource('/documents', 'DocumentController');

    Route::resource('/transporters', 'TransporterController');
});


Route::fallback(function () {
    return response()->json([
        'error' => '404 Not Found',
        'message' => 'We apparently could not find what you are looking for.'
    ], 404);
});




