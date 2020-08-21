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
    Route::get('mukellefler/api/{id}','MukellefController@detayApi')
        ->name('mukellef.detay');
    Route::get('mukellefler/{id}','MukellefController@guncelleGet')
        ->name('mukellef.guncelle.get');
    Route::get('mukellefler','MukellefController@index')
        ->name('mukellef.liste');

    // Abone İşlemleri
    Route::get('aboneler/ekle','AboneController@ekleGet')
        ->name('abone.ekle.get');
    Route::post('aboneler/ekle','AboneController@eklePost')
        ->name('abone.ekle.post');
    Route::get('aboneler/{id}','AboneController@guncelleGet')
        ->name('abone.guncelle.get');
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
    Route::get('faturalar/{id}','FaturaController@download')
        ->name('fatura.detay');

    // Ayarlar
    Route::get('ayarlar','AyarController@index')
        ->name('ayar.index');
    Route::post('ayarlar','AyarController@update')
        ->name('ayar.update');
});

