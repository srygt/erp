<?php

namespace App\Http\Controllers;

use App\Http\Requests\sufaturasiekleRequest;
use App\Models\Abone;
use App\Models\Mukellef;
use App\Models\SuFatura;
use Illuminate\Support\Facades\DB;

class SuFaturaController extends Controller
{


    public function suFaturasi()
    {

        $suAboneler =$this->suAboneListele();


        return view('faturalar.suFaturasi',compact("suAboneler"));
    }

    public function suAboneListele()
    {

       $suabone = new  Abone();
       $aboneler= $suabone->with('Mukellef:MUKID,UNVAN,VKNTCKN')->where('ABONETIPI',7)->orWhere('ABONETIPI',1)->orWhere('ABONETIPI',4)->orWhere('ABONETIPI',5);
       $abonlerunvan=$aboneler->get();
       return $abonlerunvan;




    }

    public function suFaturasiEkle(sufaturasiekleRequest $request)
    {

        $suFaturasi = new SuFatura();

        $suFaturasi->ABONEID = $request->aboneID;
        $suFaturasi->ILKENDEKS = $request->ilkEndeks;
        $suFaturasi->SONENDEKS = $request->sonEndeks;
        $suFaturasi->SONODEMETARIHI = $request->sonOdemeTarihi;
        $suFaturasi->FATURATARIHI = $request->sonOdemeTarihi;
        $suFaturasi->TUKETIM = $request->tuketim;
        $suFaturasi->FIYATI = $request->fiyati;
        $suFaturasi->ACIKLAMA = $request->faturaAciklamasi;
        $suFaturasi->save();
        return redirect()->back()->with('message','Başarıyla Eklendi');
    }


}
