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
    Route::get('faturalar/suFaturasi','SuFaturaController@suFaturasi')
        ->name('faturalar.suFaturasi');
    Route::get('aboneler/aboneekle','MainController@aboneekle')
        ->name('aboneler.aboneekle');
    Route::get('aboneler/abonelistesi','abonecontroller@abonelistesi')
        ->name('aboneler.abonelistesi');
    Route::get('aboneler/{aboneler}/duzenle','abonecontroller@aboneduzenle')
        ->name('aboneduzenle');
    Route::put('abone/{aboneler}','abonecontroller@guncelle')
        ->name('aboneguncelle');
    Route::get('sayaclar/ekle','SayacController@ekle')
        ->name('sayac.ekle.get');

    /* Veritabanı İşlemleri */
    Route::post('faturalar/suFaturasi','SuFaturaController@suFaturasiEkle')
        ->middleware('datetypeconverter')
        ->name('sufaturasiekle');
    Route::post('sayaclar/ekle','SayacController@ekle')
        ->middleware('datetypeconverter')
        ->name('sayac.ekle.post');

    /*Fatura İslemleri*/
    Route::get('faturalar/suFaturasiolustur','EarsivFaturaOlustur@suFaturasiOlustur');
    Route::get('faturalar/suFaturasiGonder','FaturaGonder@suFaturasiGonder');

    /*Abone İslemleri*/
    Route::post('aboneler/aboneekle','abonecontroller@aboneekle')
        ->name('aboneeklePost');
});

