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
Route::middleware(['key.access'])->group(function(){ 

    Route::post('patient/new/save/{key}','PatientController@store');
    Route::get('patient/{id}/{key}','PatientController@findPatient');
});

Route::post('facility/get/access','ServerController@setFacilityAccess');