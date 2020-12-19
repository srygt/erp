<?php
use Illuminate\Support\Facades\Route;

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

Route::get('/', 'AuthController@redirectToLogin');

Route::prefix('panel')->middleware('logincontrol')->group(function (){
    Route::get('giris', 'AuthController@index')
        ->name('Login');
    Route::post('giris', 'AuthController@LoginPost')
        ->name('Login.post');
});


Route::prefix('panel')->middleware('AuthControl')->group(function (){
    Route::get('anasayfa','MainController@Home')
        ->name('home');
    Route::get('panel/cikis','AuthController@logout')
        ->name('cikis');

    // Mükellef İşlemleri
    Route::get('mukellefler/ekle','MukellefController@ekleGet')
        ->name('mukellef.ekle.get');
    Route::post('mukellefler/ekle','MukellefController@eklePost')
        ->name('mukellef.ekle.post');
    Route::post('mukellefler/pasiflestir','MukellefController@pasiflestir')
        ->name('mukellef.pasiflestir');
    Route::get('mukellefler/{id}','MukellefController@guncelleGet')
        ->name('mukellef.guncelle.get')
        ->where(['id' => '[0-9]+']);
    Route::get('mukellefler','MukellefController@index')
        ->name('mukellef.liste');

    // Abone İşlemleri
    Route::get('aboneler/ekle','AboneController@ekleGet')
        ->name('abone.ekle.get');
    Route::post('aboneler/ekle','AboneController@eklePost')
        ->name('abone.ekle.post');
    Route::get('aboneler/{id}','AboneController@guncelleGet')
        ->name('abone.guncelle.get')
        ->where(['id' => '[0-9]+']);
    Route::get('aboneler','AboneController@index')
        ->name('aboneler.liste');

    // Fatura İşlemleri
    Route::get('faturalar/ekle','FaturaTaslakController@ekleGet')
        ->name('faturataslak.ekle.get');
    Route::post('faturalar/ekle','FaturaTaslakController@eklePost')
        ->name('faturataslak.ekle.post');
    Route::post('faturalar','FaturaController@store')
        ->name('fatura.ekle.post');
    Route::get('faturalar','FaturaController@index')
        ->name('fatura.liste');
    Route::get('faturalar/pdf/{appType}/{uuid}','FaturaController@download')
        ->name('fatura.detay');
    Route::get('faturalar/gelen','FaturaController@gelenFaturalar')
        ->name('fatura.gelen.liste');
    Route::get('faturalar/giden-rapor','FaturaController@gidenFaturaRaporlari')
        ->name('fatura.giden.rapor');

    // Genel Ayarlar
    Route::get('ayarlar/genel','GenelAyarController@index')
        ->name('ayar.genel.index');
    Route::post('ayarlar/genel','GenelAyarController@update')
        ->name('ayar.genel.update');

    // Ek Kalem Ayarları
    Route::get('ayarlar/ek-kalemler','AyarEkKalemController@index')
        ->name('ayar.ek-kalem.index');
    Route::get('ayarlar/ek-kalemler/{id}','AyarEkKalemController@show')
        ->name('ayar.ek-kalem.show')
        ->where(['id' => '[0-9]+']);
    Route::get('ayarlar/ek-kalemler/ekle','AyarEkKalemController@storeGet')
        ->name('ayar.ek-kalem.store.get');
    Route::post('ayarlar/ek-kalemler/{id}','AyarEkKalemController@update')
        ->name('ayar.ek-kalem.update')
        ->where(['id' => '[0-9]+']);
    Route::post('ayarlar/ek-kalemler','AyarEkKalemController@storePost')
        ->name('ayar.ek-kalem.store.post');
    Route::delete('ayarlar/ek-kalemler/{id}','AyarEkKalemController@destroy')
        ->name('ayar.ek-kalem.destroy')
        ->where(['id' => '[0-9]+']);

    // Import
    Route::get('import/fatura/upload','Import\FaturaUploadController@index')
        ->name('import.fatura.upload.get');
    Route::post('import/fatura/upload','Import\FaturaUploadController@store')
        ->name('import.fatura.upload.post');
    Route::get('import/fatura/upload/{fatura_file}','Import\FaturaUploadController@show')
        ->name('import.fatura.upload.detay')
        ->where(['id' => '[0-9]+']);

    Route::post('import/fatura/validation/{fatura_file}','Import\FaturaValidationController@store')
        ->name('import.fatura.validation.detay')
        ->where(['id' => '[0-9]+']);

    // Api
    Route::get('mukellefler/api/{id}','MukellefController@detayApi')
        ->name('mukellef.detay')
        ->where(['id' => '[0-9]+']);
    Route::get('faturalar/api/son-fatura','FaturaApiController@sonFaturaDetay')
        ->name('fatura.api.son-fatura');
    Route::post('faturalar/api/okuma-durumu','FaturaApiController@okumaDurumu')
        ->name('fatura.api.okuma-durumu');
});

