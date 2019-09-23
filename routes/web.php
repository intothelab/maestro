<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Geocoder\Laravel\Facades\Geocoder;

Route::get('/test', function () {
    $address = Geocoder::geocode('Rua Oscar Trompowsky, 844, 30441-123');
    dd($address->get()->first());

});