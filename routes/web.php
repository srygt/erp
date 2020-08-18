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

Route::get('/', function () {
    return redirect()->route('Login');
});
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
    Route::get('aboneler/aboneekle','MainController@aboneekle')
        ->name('aboneler.aboneekle');
    Route::get('aboneler/abonelistesi','AboneController@abonelistesi')
        ->name('aboneler.abonelistesi');
    Route::get('aboneler/{aboneler}/duzenle','AboneController@aboneduzenle')
        ->name('aboneduzenle');
    Route::put('abone/{aboneler}','AboneController@guncelle')
        ->name('aboneguncelle');
    Route::get('sayaclar/ekle','SayacController@ekle')
        ->name('sayac.ekle.get');

    /* Veritabanı İşlemleri */
    Route::post('sayaclar/ekle','SayacController@ekle')
        ->middleware('datetypeconverter')
        ->name('sayac.ekle.post');

    /*Fatura İslemleri*/
    Route::get('faturalar/suFaturasiolustur','EarsivFaturaOlustur@suFaturasiOlustur');
    Route::get('faturalar/suFaturasiGonder','FaturaGonder@suFaturasiGonder');

    /*Abone İslemleri*/
    Route::post('aboneler/aboneekle','AboneController@aboneekle')
        ->name('aboneeklePost');

    // Mükellef İşlemleri
    Route::get('mukellefler/ekle','MukellefController@ekleGet')
        ->name('mukellef.ekle.get');
    Route::post('mukellefler/ekle','MukellefController@eklePost')
        ->name('mukellef.ekle.post');
    Route::get('mukellefler/api/{id}','MukellefController@detayApi')
        ->name('mukellef.detay');
    Route::get('mukellefler/{id}','MukellefController@guncelleGet')
        ->name('mukellef.guncelle.get');

    // Abone İşlemleri
    Route::get('aboneler/ekle','AboneController@ekleGet')
        ->name('abone.ekle.get');
    Route::post('aboneler/ekle','AboneController@eklePost')
        ->name('abone.ekle.post');
    Route::get('aboneler/{id}','AboneController@guncelleGet')
        ->name('abone.guncelle.get');

    // Fatura İşlemleri
    Route::get('faturalar/ekle','FaturaTaslakController@suFaturasi')
        ->name('faturataslak.ekle.get');
    Route::post('faturalar/suFaturasi','FaturaTaslakController@suFaturasiEkle')
        ->middleware('datetypeconverter')
        ->name('faturataslak.ekle.post');
    Route::post('faturalar','FaturaController@store')
        ->name('fatura.ekle.post');
});

