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
Route::get('/curtains', 'CurtainController@getAllAction');
Route::post('/curtains/', 'CurtainController@postAction');
Route::get('/curtains/{curtain}', 'CurtainController@getAction');
Route::put('/curtains/{curtain}', 'CurtainController@putAction');
Route::patch('/curtains/{curtain}', 'CurtainController@patchAction');
Route::delete('/curtains/{curtain}', 'CurtainController@deleteAction');

//Schedules routes
Route::get('/curtains/{curtain}/schedules', 'ScheduleController@getAllAction');
Route::post('/curtains/{curtain}/schedules/', 'ScheduleController@postAction');
Route::get('/curtains/{curtain}/schedules/{schedule}', 'ScheduleController@getAction');
Route::put('/curtains/{curtain}/schedules/{schedule}', 'ScheduleController@putAction');
Route::patch('/curtains/{curtain}/schedules/{schedule}', 'ScheduleController@patchAction');
Route::delete('/curtains/{curtain}/schedules/{schedule}', 'ScheduleController@deleteAction');

//Days routes
Route::get('/schedules/{schedule}/days', 'WeekdayController@getAllAction');
Route::get('/schedules/{schedule}/days/{weekday}', 'WeekdayController@getAction');
Route::put('/schedules/{schedule}/days/{weekday}', 'WeekdayController@putAction');

Route::fallback(function(){
    return response()->json(['error' => 'url not found'], 404);
})->name('api.fallback.404');