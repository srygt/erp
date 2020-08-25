<?php

namespace App\Http\Controllers;

use App\Models\AyarEkKalem;
use App\Http\Requests\AyarEkKalemRequest;

class AyarEkKalemController extends Controller
{
    public function index()
    {
        $ekKalemler = AyarEkKalem::get();

        return view('ayarlar.ek-kalem.liste', ['ekKalemler' => $ekKalemler]);
    }

    public function update(AyarEkKalemRequest $request, int $id)
    {
        $ekKalem = AyarEkKalem::where('id', $id)->firstOrFail();

        $ekKalem->update($request->all());

        return redirect()
            ->back()
            ->with('message', 'Güncelleme işlemi başarı ile tamamlandı.');
    }

    public function storeGet()
    {
        return view('ayarlar.ek-kalem.ekle');
    }

    public function storePost(AyarEkKalemRequest $request)
    {
        AyarEkKalem::create($request->all());

        return redirect()
            ->back()
            ->with('message', 'Ekleme işlemi başarı ile tamamlandı.');
    }

    public function show(int $id)
    {
        $ekKalem = AyarEkKalem::where('id', $id)->firstOrFail();

        return view('ayarlar.ek-kalem.ekle', ['ekKalem' => $ekKalem]);
    }

    public function destroy(int $id)
    {
        $ekKalem = AyarEkKalem::where('id', $id)->firstOrFail();
        $ekKalem->delete();

        return response()->json(['message' => 'Silme işlemi başarı ile tamamlandı!']);
    }
}
