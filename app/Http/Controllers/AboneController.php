<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboneEkleRequest;
use App\Models\Abone;
use App\Models\Mukellef;
use App\Services\AboneService;

class AboneController extends Controller
{
    public function ekleGet()
    {
        return view('abone/ekle', [
            'abone' => new Abone,
            'mukellefler' => Mukellef::select([
                Mukellef::COLUMN_ID,
                Mukellef::COLUMN_UNVAN,
            ])
                ->get(),
        ]);
    }

    public function eklePost(AboneEkleRequest $request)
    {
        $payload = $request->only([
            Abone::COLUMN_TUR,
            Abone::COLUMN_MUKELLEF_ID,
            Abone::COLUMN_BASLIK,
            Abone::COLUMN_ABONE_NO,
            Abone::COLUMN_SAYAC_NO,
            Abone::COLUMN_SONDAJ_MI,
            Abone::COLUMN_TRT_PAYI,
            Abone::COLUMN_ENDUKTIF_BEDEL,
            Abone::COLUMN_KAPASITIF_BEDEL,
            Mukellef::COLUMN_EMAIL,
            Mukellef::COLUMN_TELEFON,
            Mukellef::COLUMN_WEBSITE,
            Mukellef::COLUMN_ULKE,
            Mukellef::COLUMN_IL,
            Mukellef::COLUMN_ILCE,
            Mukellef::COLUMN_ADRES,
            Mukellef::COLUMN_URN,
        ]);

        if ($request->id) {
            $abone = Abone::where('id', $request->id)->first();

            if (AboneService::isLocked($abone)) {
                return AboneService::showLockedMessage();
            }

            $abone->update($payload);

            return redirect()->back()->with('message', 'Başarıyla Güncellendi');
        }
        else {
            Abone::create($payload);

            return redirect()->back()->with('message', 'Başarıyla Eklendi');
        }
    }

    public function guncelleGet(int $id)
    {
        $abone = Abone::find($id);

        if (AboneService::isLocked($abone)) {
            return AboneService::showLockedMessage();
        }

        return view('abone.ekle', [
            'abone' => $abone,
            'mukellefler' => Mukellef::select([
                Mukellef::COLUMN_ID,
                Mukellef::COLUMN_UNVAN,
            ])
                ->get(),
        ]);
    }

    public function index(){
        $aboneler   = Abone::where(Abone::COLUMN_AKTIF_MI, true)->with('mukellef')->get();

        return view('abone.liste', ['aboneler' => $aboneler]);
    }
}
