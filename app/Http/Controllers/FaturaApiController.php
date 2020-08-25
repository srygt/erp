<?php

namespace App\Http\Controllers;

use App\Http\Requests\SonFaturaDetayRequest;
use App\Models\Fatura;

class FaturaApiController extends Controller
{
    public function sonFaturaDetay(SonFaturaDetayRequest $request)
    {
        $sonFatura = Fatura::where(Fatura::COLUMN_ABONE_ID, $request->abone_id)
            ->where(Fatura::COLUMN_DURUM, Fatura::COLUMN_DURUM_BASARILI)
            ->orderBy('id', 'desc')
            ->first();

        return $sonFatura;
    }
}
