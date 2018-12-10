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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

//Security routes
Route::post('/registration', 'SecurityController@createUser');
Route::post('/disconnection', 'SecurityController@logout')->middleware('auth:api');

//Curtain routes
Route::get('/curtains', 'CurtainController@getAllAction')->middleware('auth:api');
Route::post('/curtains/', 'CurtainController@postAction')->middleware('auth:api');
Route::get('/curtains/{curtain}', 'CurtainController@getAction')->middleware('auth:api');
Route::put('/curtains/{curtain}', 'CurtainController@putAction')->middleware('auth:api');
Route::patch('/curtains/{curtain}', 'CurtainController@patchAction')->middleware('auth:api');
Route::delete('/curtains/{curtain}', 'CurtainController@deleteAction')->middleware('auth:api');

//Schedules routes
Route::get('/curtains/{curtain}/schedules', 'ScheduleController@getAllAction');
Route::post('/curtains/{curtain}/schedules/', 'ScheduleController@postAction')->middleware('auth:api')->middleware('auth:api');
Route::get('/curtains/{curtain}/schedules/{schedule}', 'ScheduleController@getAction')->middleware('auth:api');
Route::put('/curtains/{curtain}/schedules/{schedule}', 'ScheduleController@putAction')->middleware('auth:api');
Route::patch('/curtains/{curtain}/schedules/{schedule}', 'ScheduleController@patchAction')->middleware('auth:api');
Route::delete('/curtains/{curtain}/schedules/{schedule}', 'ScheduleController@deleteAction')->middleware('auth:api');

//Days routes
Route::get('/schedules/{schedule}/days', 'WeekdayController@getAllAction')->middleware('auth:api');
Route::get('/schedules/{schedule}/days/{weekday}', 'WeekdayController@getAction')->middleware('auth:api');
Route::put('/schedules/{schedule}/days/{weekday}', 'WeekdayController@putAction')->middleware('auth:api');

Route::fallback(function(){
    return response()->json(['error' => 'url not found'], 400);
})->name('api.fallback.404');
