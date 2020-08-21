<?php

namespace App\Http\Controllers;

use App\Exceptions\HizliTeknolojiIsSuccessException;
use App\Http\Requests\FaturaTaslagiEkleRequest;
use App\Models\Abone;
use App\Models\Ayar;
use App\Models\Fatura;
use App\Services\Fatura\FaturaFactory;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Ramsey\Uuid\Uuid;

class FaturaTaslakController extends Controller
{
    public function ekleGet()
    {
        $ayarlar    = Ayar::allFormatted();
        $aboneler   = Abone::with('mukellef')->get();


        return view(
            'faturalar.ekle',
            [
                'ayarlar'   => $ayarlar,
                'aboneler'  => $aboneler,
            ]
        );
    }

    public function eklePost(FaturaTaslagiEkleRequest $request)
    {
        $abone = Abone::find($request->abone_id);

        $faturaTaslagi = $abone
            ->faturaTaslaklari()
            ->create([
                Fatura::COLUMN_UUID                 => (string) Uuid::uuid4(),
                Fatura::COLUMN_ABONE_ID             => $request->abone_id,
                Fatura::COLUMN_BIRIM_FIYAT_TUKETIM  => $request->birim_fiyat,
                Fatura::COLUMN_BIRIM_FIYAT_DAGITIM  => $request->dagitim_birim_fiyat,
                Fatura::COLUMN_BIRIM_FIYAT_SISTEM   => $request->sistem_birim_fiyat,
                Fatura::COLUMN_SON_ODEME_TARIHI     => $request->son_odeme_tarihi,
                Fatura::COLUMN_ENDEKS_ILK           => $request->ilk_endeks,
                Fatura::COLUMN_ENDEKS_SON           => $request->son_endeks,
                Fatura::COLUMN_NOT                  => $request->not,
            ]);

        $faturaService = FaturaFactory::getService($abone->{Abone::COLUMN_TUR});

        try {
            $response = $faturaService->getPreview($faturaTaslagi);
        } catch (GuzzleException $e) {
            return self::showErrorMessage($e);
        } catch (HizliTeknolojiIsSuccessException $e) {
            return self::showErrorMessage($e);
        }

        return view(
            'faturalar.taslak',
            [
                'response' => $response,
                'taslakUuid' => $faturaTaslagi->uuid,
            ]
        );
    }

    static protected function showErrorMessage(Exception $e)
    {
        return view(
            'faturalar.taslak',
            [
                'error'         => $e->getMessage(),
            ]
        );
    }
}
