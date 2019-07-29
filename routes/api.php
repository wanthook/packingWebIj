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

Route::post('register','Api\Auth\RegisterController@store');
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//
//
Route::middleware('auth:api')->get('user-info',function(Request $request)
{
    
    return $request->user();
});

Route::group(['prefix' => 'berat' ,'middleware' => 'auth:api'],function()
{
    Route::get('list-berat',['as' => 'api.berat.list', 'uses' => 'Api\BeratController@index']);
});

Route::group(['prefix' => 'timbangan', 'middleware' => 'auth:api'],function()
{
    Route::get('list-timbangan',['as' => 'api.timbangan.list', 'uses' => 'Api\TimbanganController@index']);
    Route::get('proseslist-timbangan',['as' => 'api.timbangan.proseslist', 'uses' => 'Api\TimbanganController@proses']);
    Route::get('register-timbangan',['as' => 'api.timbangan.register', 'uses' => 'Api\TimbanganController@registerNumber']);
    Route::get('noreg-timbangan',['as' => 'api.timbangan.noreg', 'uses' => 'Api\TimbanganController@noReg']);
    Route::post('simpan-timbangan',['as' => 'api.timbangan.store', 'uses' => 'Api\TimbanganController@store']);
    Route::post('simpan-palet',['as' => 'api.timbangan.palet', 'uses' => 'Api\TimbanganController@storePalet']);
    
});

Route::group(['prefix' => 'mesin' ,'middleware' => 'auth:api'],function()
{
    Route::get('ambil-mesin',['as' => 'api.mesin.ambil', 'uses' => 'Api\MesinController@index']);
    
});

Route::group(['prefix' => 'packing' ,'middleware' => 'auth:api'],function()
{
    Route::get('list-packing',['as' => 'api.packing.list', 'uses' => 'Api\PackingController@index']);
});

Route::group(['prefix' => 'palet' ,'middleware' => 'auth:api'],function()
{
    Route::get('list-palet',['as' => 'api.palet.list', 'uses' => 'Api\PaletController@index']);
});
//Route::group(['namespace' => ])
