<?php

namespace App\Http\Controllers;

use App\Exceptions\HizliTeknolojiIsSuccessException;
use App\Http\Requests\FaturaTaslagiEkleRequest;
use App\Models\Abone;
use App\Models\Ayar;
use App\Models\AyarEkKalem;
use App\Models\Fatura;
use App\Models\FaturaTaslagi;
use App\Services\Fatura\FaturaFactory;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Ramsey\Uuid\Uuid;

class FaturaTaslakController extends Controller
{
    public function ekleGet()
    {
        $ekKalemler = AyarEkKalem::select([
                            'id',
                            AyarEkKalem::COLUMN_TUR,
                            AyarEkKalem::COLUMN_UCRET_TUR,
                            AyarEkKalem::COLUMN_DEGER,
                            AyarEkKalem::COLUMN_BASLIK,
                        ])
                        ->get()
                        ->groupBy(AyarEkKalem::COLUMN_TUR);

        $ayarlar    = Ayar::allFormatted();
        $aboneler   = Abone::with('mukellef')->get();


        return view(
            'faturalar.ekle',
            [
                'ekKalemler'=> $ekKalemler,
                'ayarlar'   => $ayarlar,
                'aboneler'  => $aboneler,
            ]
        );
    }

    public function eklePost(FaturaTaslagiEkleRequest $request)
    {
        $abone = Abone::find($request->abone_id);

        /** @var FaturaTaslagi $faturaTaslagi */
        $faturaTaslagi = $abone
            ->faturaTaslaklari()
            ->create([
                Fatura::COLUMN_UUID                 => (string) Uuid::uuid4(),
                Fatura::COLUMN_ABONE_ID             => $abone->id,
                Fatura::COLUMN_TUR                  => $abone->{Abone::COLUMN_TUR},
                Fatura::COLUMN_BIRIM_FIYAT_TUKETIM  => $request->birim_fiyat,
                Fatura::COLUMN_SON_ODEME_TARIHI     => $request->son_odeme_tarihi,
                Fatura::COLUMN_ENDEKS_ILK           => $request->ilk_endeks,
                Fatura::COLUMN_ENDEKS_SON           => $request->son_endeks,
                Fatura::COLUMN_NOT                  => $request->not,
            ]);

        $faturaService = FaturaFactory::getService($abone->{Abone::COLUMN_TUR});

        try {
            $response = $faturaService->getPreview($faturaTaslagi, $request->ek_kalemler);
        } catch (GuzzleException $e) {
            return self::showErrorMessage($e);
        } catch (HizliTeknolojiIsSuccessException $e) {
            return self::showErrorMessage($e);
        }

        return view(
            'faturalar.taslak',
            [
                'response'      => $response,
                'taslakUuid'    => $faturaTaslagi->uuid,
                'ekKalemler'    => $request->ek_kalemler,
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
