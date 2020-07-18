<?php

namespace App\Http\Controllers;

use App\Http\Requests\aboneeklerequest;
use App\Models\Abone;
use App\Models\Mukellef;
use Carbon\Carbon;

class abonecontroller extends Controller
{
    public function aboneekle(aboneeklerequest $request){
        $abone = new Mukellef();

        $abone->VKNTCKN = $request->vkn_tckn;
        $abone->UNVAN = $request->unvan;
        $abone->AD = $request->ad;
        $abone->SOYAD = $request->soyad;
        $abone->VERGIDAIRESISEHIR = $request->vdil;
        $abone->VERGIDAIRESI = $request->vd;
        $abone->TICARETODASI = $request->ticod;
        $abone->MERSISNO = $request->mersisno;
        $abone->TICARETSICILNO = $request->ticsicilno;
        $abone->EPOSTA = $request->eposta;
        $abone->WEBSITE = $request->site;
        $abone->ULKE = $request->ulke;
        $abone->IL = $request->il;
        $abone->ILCE = $request->ilce;
        $abone->POSTAKODU = $request->postakodu;
        $abone->MAHALLECAD = $request->mahalle_cadde;
        $abone->BINAADI = $request->bina_adi;
        $abone->BINANO = $request->bina_no;
        $abone->DAIRENO = $request->daire_no;
        $abone->TELNO = $request->telno;
        $abone->FAKS = $request->faks;
        $abone->save();
        $abonebilgi= new Abone();
        $abonebilgi->VKNTCKN =$request->vkn_tckn;
        $abonebilgi->ABONETIPI=$request->abonetipi;
        $date = new Carbon();
        $date->setTimezone('Europe/Istanbul');
        $abonebilgi->ATARIH=$date->now();
        $abonebilgi->ADURUMU =true;
        $abonebilgi->save();
        return redirect()->back()->with('message','Başarıyla Eklendi');

    }

    public function abonelistesi(){
        $mukelleflistesi=$this->abonelistele();
        return view('abone.aboneler',['mukelleflistesi'=>$mukelleflistesi]);
    }
    public function abonelistele(){
        $mukellef = new Mukellef();
        $mukelleflistesi=$mukellef->all();
        return $mukelleflistesi;
    }
    public function aboneduzenle($id){
        $mukellef=new Mukellef();
        $mukellefbilgi= $mukellef->find($id);
        $abonetipi= new Abone();
        $abonetipimuk= $abonetipi->where("VKNTCKN",$mukellefbilgi->VKNTCKN)->first();
        return view('abone.aboneguncelle',compact('mukellefbilgi','abonetipimuk'));
    }

    public function guncelle(){

    }
}
