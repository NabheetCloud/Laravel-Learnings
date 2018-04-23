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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});  
//Route::get('table', 'TableController@index');
Route::group(['prefix' =>'/table'], function(){
    Route::get('/',['as'=>'table','uses'=>'TableController@index']);
    Route::get('/post',['as'=>'table.postSensorData','uses'=>'TableController@postSensorData']);
    Route::get('/post/{suffix}',['as'=>'table.postSensorData','uses'=>'TableController@show']);
});
