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


//Route::middleware('auth:api')->group(function () {
    Route::prefix('curtains')->group(function () {
        Route::get      ('',            'CurtainController@index');
        Route::get      ('/{curtain}',  'CurtainController@show');
        Route::post     ('',            'CurtainController@store');
        Route::put      ('/{curtain}',  'CurtainController@update');
        Route::patch    ('/{curtain}',  'CurtainController@patch');
        Route::delete   ('/{curtain}',  'CurtainController@delete');
    });

    Route::prefix('curtains/{curtain}/schedules')->group(function () {
        Route::get      ('',            'ScheduleController@index');
        Route::post     ('',            'ScheduleController@update');
        Route::get      ('/{schedule}', 'ScheduleController@show');
        Route::put      ('/{schedule}', 'ScheduleController@update');
        Route::patch    ('/{schedule}', 'ScheduleController@patch');
        Route::delete   ('/{schedule}', 'ScheduleController@delete');
    });

    Route::prefix('/schedules/{schedule}/days')->group(function () {
        Route::get(''           , 'WeekdayController@index');
        Route::get('/{weekday}',  'WeekdayController@show');
        Route::put('/{weekday}',  'WeekdayController@update');
    });
//});

Route::fallback(function(){
    return response()->json(['error' => 'url not found'], 400);
})->name('api.fallback.404');
