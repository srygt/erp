<?php

namespace App\Http\Controllers;

use App\Http\Requests\MukellefEkleRequest;
use App\Http\Requests\MukellefPasiflestirRequest;
use App\Models\Abone;
use App\Models\Mukellef;
use App\Services\MukellefService;

class MukellefController extends Controller
{
    public function index()
    {
        $mukellefler = Mukellef::where(Mukellef::COLUMN_AKTIF_MI, true)->get();

        return view('mukellef.liste', ['mukellefler' => $mukellefler]);
    }

    public function ekleGet()
    {
        $mukellef = new Mukellef();

        return view('mukellef.ekle', [
            'mukellef' => $mukellef,
        ]);
    }

    public function eklePost(MukellefEkleRequest $request)
    {
        $payload = $request->only([
            Mukellef::COLUMN_VERGI_NO,
            Mukellef::COLUMN_TC_KIMLIK_NO,
            Mukellef::COLUMN_AD,
            Mukellef::COLUMN_SOYAD,
            Mukellef::COLUMN_UNVAN,
            Mukellef::COLUMN_VERGI_DAIRESI_SEHIR,
            Mukellef::COLUMN_VERGI_DAIRESI,
            Mukellef::COLUMN_EMAIL,
            Mukellef::COLUMN_WEBSITE,
            Mukellef::COLUMN_ULKE,
            Mukellef::COLUMN_IL,
            Mukellef::COLUMN_ILCE,
            Mukellef::COLUMN_ADRES,
            Mukellef::COLUMN_TELEFON,
            Mukellef::COLUMN_URN,
        ]);

        if ($request->id) {
            $mukellef = Mukellef::findOrFail($request->id);

            if (MukellefService::isLocked($mukellef)) {
                return MukellefService::showLockedMessage();
            }

            $mukellef->update(
                array_merge(    // kullanıcının hem vergi no hem de tc kimlik no ya sahip olmasını istemeyiz
                    [
                        Mukellef::COLUMN_VERGI_NO       => null,
                        Mukellef::COLUMN_TC_KIMLIK_NO   => null,
                    ],
                    $payload
                )
            );

            return redirect()->back()->with('message', 'Başarıyla Güncellendi');
        }
        else {
            Mukellef::create($payload);

            return redirect()->back()->with('message', 'Başarıyla Eklendi');
        }
    }

    public function guncelleGet(int $id)
    {
        $mukellef = Mukellef::find($id);

        if (MukellefService::isLocked($mukellef)) {
            return MukellefService::showLockedMessage();
        }

        return view('mukellef.ekle', [
            'mukellef' => $mukellef,
        ]);
    }

    public function detayApi(int $id)
    {
        return Mukellef::find($id);
    }

    public function pasiflestir(MukellefPasiflestirRequest $request)
    {
        $mukellef = Mukellef::findOrFail($request->id);

        if (MukellefService::isLocked($mukellef)) {
            return MukellefService::showLockedMessage();
        }

        $mukellef->update([
            Mukellef::COLUMN_AKTIF_MI => false,
        ]);

        $mukellef->abonelikler()->update([
            Abone::COLUMN_AKTIF_MI => false,
        ]);

        return redirect()->back()->with('message', 'Mükellef Başarıyla Pasifleştirildi');
    }
}
