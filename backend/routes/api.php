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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


//Curtain routes
Route::get('/curtains', 'CurtainController@getAllAction');
Route::get('/curtains/{id}', 'CurtainController@getAction');
Route::post('/curtains/{id}', 'CurtainController@postAction');
Route::patch('/curtains/{id}', 'CurtainController@patchAction');
Route::delete('/curtains/{id}', 'CurtainController@deleteAction');

//Schedules routes
Route::get('/curtains/{slug}/schedules', 'ScheduleController@getAllAction');
Route::get('/curtains/{slug}/schedules/{id}', 'ScheduleController@getAction');
Route::post('/curtains/{slug}/schedules/{id}', 'ScheduleController@postAction');
Route::patch('/curtains/{slug}/schedules/{id}', 'ScheduleController@patchAction');
Route::delete('/curtains/{slug}/schedules/{id}', 'ScheduleController@deleteAction');
