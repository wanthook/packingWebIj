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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/', ['as' => 'home.root','uses' => 'HomeController@index']);
Route::get('home', ['as' => 'home.root','uses' => 'HomeController@index']);
Route::patch('change-password/{id}', ['as' => 'cp', 'uses' => 'UserController@changepass']);

/*
* berat
*/
Route::group(['prefix' => 'berat', 'middleware' => 'auth'], function()
{
    Route::post('berat-select-json',    ['as' => 'berat.select2','uses'   => 'BeratController@select2']);
    Route::get('halaman-master-berat',    ['as' => 'berat.list','uses'   => 'BeratController@index']);
    Route::post('data-tabel-berat', ['as' => 'berat.tabel','uses'  => 'BeratController@dataTables']);
    Route::get('ubah-master-berat/{id}',    ['as' => 'berat.ubah','uses'   => 'BeratController@edit']);
    Route::get('tambah-master-berat', ['as' => 'berat.add', 'uses' => 'BeratController@create']);
    Route::post('simpan-data-berat', ['as' => 'berat.save', 'uses' => 'BeratController@store']);
    Route::patch('ubah-data-berat/{id}', ['as' => 'berat.change', 'uses' => 'BeratController@update']);
});
    

/*
* end berat
*/

/*
* packing
*/
Route::group(['prefix' => 'packing', 'middleware' => 'auth'], function()
{
    Route::post('packing-select-json',    ['as' => 'packing.select2','uses'   => 'PackingController@select2']);
    Route::get('halaman-master-packing',    ['as' => 'packing.list','uses'   => 'PackingController@index']);
    Route::post('data-tabel-packing', ['as' => 'packing.tabel','uses'  => 'PackingController@dataTables']);
    Route::get('ubah-master-packing/{id}',    ['as' => 'packing.ubah','uses'   => 'PackingController@edit']);
    Route::get('tambah-master-packing', ['as' => 'packing.add', 'uses' => 'PackingController@add']);
    Route::post('simpan-data-packing', ['as' => 'packing.save', 'uses' => 'PackingController@save']);
    Route::patch('ubah-data-packing/{id}', ['as' => 'packing.change', 'uses' => 'PackingController@change']);
    
});
/*
* end packing
*/

/*
 * mesin
 */
Route::group(['prefix' => 'mesin', 'middleware' => 'auth'], function()
{
    
    Route::post('mesin-select-json',['as' => 'mesin.select2', 'uses' => 'MesinController@select2']);
});
/*
 * end mesin
 */

/*
* timbangan
*/
Route::group(['prefix' => 'timbangan', 'middleware' => 'auth'], function()
{
    Route::post('timbangan-select-json',    ['as' => 'timbangan.select2','uses'   => 'TimbanganController@select2']);
    Route::get('halaman-timbangan',    ['as' => 'timbangan.list','uses'   => 'TimbanganController@index']);
    Route::post('data-tabel-timbangan', ['as' => 'timbangan.tabel','uses'  => 'TimbanganController@dataTables']);
    Route::get('ubah-master-timbangan/{id}',    ['as' => 'timbangan.ubah','uses'   => 'TimbanganController@edit']);
    Route::get('tambah-master-timbangan', ['as' => 'timbangan.add', 'uses' => 'TimbanganController@add']);
    
    Route::get('halaman-download-timbangan', ['as' => 'timbangan.listDownload', 'uses' => 'TimbanganController@indexDownload']);
    Route::post('data-tabel-download-timbangan', ['as' => 'timbangan.tabelDownload','uses'  => 'TimbanganController@dataTablesDownload']);
    Route::get('download-timbangan', ['as' => 'timbangan.download', 'uses' => 'TimbanganController@saveData']);
//    Route::get('download-timbangan2/{id?}', ['as' => 'timbangan.download2', 'uses' => 'TimbanganController@saveData']);
    
    Route::get('redownload-timbangan'.'/{kode}',      ['as' => 'timbangan.redownload', function ($kode)
    {
       $path = "/mnt/server_file/document_packing/" . $kode;
       
       $headers = array(
              'Content-Type: test',
            );
       
       return Response::download($path, $kode, $headers);
//       $response = Response::make(File::get($path), 200);
//       $response->header("Content-Type", File::mimeType($path));
//       return $response->download($kode);
    }]);
//    Route::post('simpan-data-timbangan', ['as' => 'timbangan.save', 'uses' => 'TimbanganController@save']);
//    Route::patch('ubah-data-timbangan/{id}', ['as' => 'timbangan.change', 'uses' => 'TimbanganController@change']);
    
});
/*
* end timbangan
*/

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function()
{
    Route::get('user-list', ['as' => 'user.list', 'uses' => 'UserController@index']);
    Route::get('user-add', ['as' => 'user.add', 'uses' => 'UserController@add']);
    Route::post('user-save', ['as' => 'user.save', 'uses' => 'UserController@save']);
    Route::post('user-table', ['as' => 'user.tabel','uses'  => 'UserController@dataTables']);
    Route::get('user-edit'.'/{token}',    ['as' => 'user.ubah','uses'   => 'UserController@edit']);
    Route::patch('user-change'.'/{id}', ['as' => 'user.change', 'uses' => 'UserController@change']);
    Route::get('user-pht'.'/{kode}',      ['as' => 'user.pht', function ($kode)
    {
       $path = storage_path("uploads/profiles/") . $kode;
       $response = Response::make(File::get($path), 200);
       $response->header("Content-Type", File::mimeType($path));
       return $response;
    }]);
    Route::get('user-ttd'.'/{kode}',      ['as' => 'user.ttd', function ($kode)
    {
       $path = storage_path("uploads/ttd/") . $kode;
       $response = Response::make(File::get($path), 200);
       $response->header("Content-Type", File::mimeType($path));
       return $response;
    }]);
});


//Route::get('/home', 'HomeController@index')->name('home');
//
//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');
