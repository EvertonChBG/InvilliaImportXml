<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user',function (Request $request) {
    return $request->user();
});

Route::get('/users',function () {
    return response()->json(\App\Models\User::all());
});

//'middleware' => ['auth:sanctum']
Route::group([],function () {

    Route::apiResource('peoples',\App\Http\Controllers\Api\PeopleController::class);
    Route::apiResource('shiporders',\App\Http\Controllers\Api\ShiporderController::class);
    Route::apiResource('imports',\App\Http\Controllers\Api\ImportController::class);
});
