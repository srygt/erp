<?php

namespace App\Http\Controllers;

use App\Models\Ayar;
use App\Http\Requests\AyarGuncelleRequest;

class GenelAyarController extends Controller
{
    public function index()
    {
        return view('ayarlar.genel', ['ayarlar' => Ayar::allFormatted()]);
    }
    public function update(AyarGuncelleRequest $request)
    {
        $payload = $request->only(Ayar::LIST_FIELDS);

        foreach ($payload as $fatura => $fields) {
            foreach ($fields as $name => $value) {
                Ayar::updateOrCreate(
                    [
                        Ayar::COLUMN_BASLIK     => $fatura . '.' . $name,
                    ],
                    [
                        Ayar::COLUMN_DEGER      => $value,
                    ]
                );
            }
        }

        return redirect()
            ->back()
            ->with('message', 'Ayarlar Başarıyla Güncellendi!');
    }
}
