<?php

namespace App\Http\Controllers;

use App\Http\Requests\MukellefEkleRequest;
use App\Models\Mukellef;

class MukellefController extends Controller
{
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
            Mukellef::where('id', $request->id)
                ->update($payload);

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

        return view('mukellef.ekle', [
            'mukellef' => $mukellef,
        ]);
    }

    public function detayApi(int $id)
    {
        return Mukellef::find($id);
    }
}
