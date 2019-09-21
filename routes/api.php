<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->group(function(){
    Route::resource('/supplier', 'SupplierController');
    Route::resource('/company', 'CompanyController');
    Route::resource('/customer', 'CustomerController');
    Route::resource('/event', 'EventController');
    Route::resource('/document', 'DocumentController');
    Route::resource('/transporter', 'TransporterController');
});


