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

Route::middleware('auth:api')->group(function () {
    Route::apiResource('depots', 'DepotController');
    Route::apiResource('revisorypoints', 'RevisoryPointController');
    Route::apiResource('interiortypes', 'InteriorTypeController');
    Route::apiResource('wagontypes', 'WagonTypeController');
    Route::apiResource('wagons', 'WagonController');
});
