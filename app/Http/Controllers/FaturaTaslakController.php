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
                            AyarEkKalem::COLUMN_VARSAYILAN_DURUM,
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
                Fatura::COLUMN_FATURA_TARIH         => $request->{Fatura::COLUMN_FATURA_TARIH},
                Fatura::COLUMN_SON_ODEME_TARIHI     => $request->{Fatura::COLUMN_SON_ODEME_TARIHI},
                Fatura::COLUMN_ENDEKS_ILK           => $abone->{Abone::COLUMN_TUR} === Abone::COLUMN_TUR_SU ? $request->ilk_endeks : 0,
                Fatura::COLUMN_ENDEKS_SON           => $request->{Fatura::COLUMN_ENDEKS_SON},
                Fatura::COLUMN_BIRIM_FIYAT_TUKETIM  => $request->{Fatura::COLUMN_BIRIM_FIYAT_TUKETIM},
                Fatura::COLUMN_GUNDUZ_TUKETIM       => $request->{Fatura::COLUMN_GUNDUZ_TUKETIM},
                Fatura::COLUMN_PUAND_TUKETIM        => $request->{Fatura::COLUMN_PUAND_TUKETIM},
                Fatura::COLUMN_GECE_TUKETIM         => $request->{Fatura::COLUMN_GECE_TUKETIM},
                Fatura::COLUMN_ENDUKTIF_TUKETIM     => $request->{Fatura::COLUMN_ENDUKTIF_TUKETIM},
                Fatura::COLUMN_ENDUKTIF_BIRIM_FIYAT => $request->{Fatura::COLUMN_ENDUKTIF_BIRIM_FIYAT},
                Fatura::COLUMN_KAPASITIF_TUKETIM    => $request->{Fatura::COLUMN_KAPASITIF_TUKETIM},
                Fatura::COLUMN_KAPASITIF_BIRIM_FIYAT=> $request->{Fatura::COLUMN_KAPASITIF_BIRIM_FIYAT},
                Fatura::COLUMN_NOT                  => $request->{Fatura::COLUMN_NOT},
                Fatura::COLUMN_DATA_SOURCE          => $request->{Fatura::COLUMN_DATA_SOURCE},
            ]);

        $faturaService = FaturaFactory::createService($abone->{Abone::COLUMN_TUR});

        try {
            $response = $faturaService->getPreview(
                $faturaTaslagi,
                $request->ek_kalemler[$faturaTaslagi->{Fatura::COLUMN_TUR}] ?? []
            );
        } catch (GuzzleException $e) {
            return self::showErrorMessage($e, $faturaTaslagi);
        } catch (HizliTeknolojiIsSuccessException $e) {
            return self::showErrorMessage($e, $faturaTaslagi);
        }

        $dataSource = FaturaFactory::createDataSource(
            $faturaTaslagi->{Fatura::COLUMN_DATA_SOURCE}
        );

        $hiddenFields = $dataSource->getTemplateHiddenFields([
            'request' => $request->validated()
        ]);

        return view(
            'faturalar.taslak',
            [
                'request'       => $request->validated(),
                'response'      => $response,
                'taslakUuid'    => $faturaTaslagi->uuid,
                'ekKalemTurleri'=> [
                    $faturaTaslagi->{Fatura::COLUMN_TUR} => $request->ek_kalemler[$faturaTaslagi->{Fatura::COLUMN_TUR}] ?? []
                ],
                'dataSource'    => $dataSource,
                'hiddenFields'  => $hiddenFields,
            ]
        );
    }

    static protected function showErrorMessage(Exception $e, FaturaTaslagi $faturaTaslagi)
    {
        return view(
            'faturalar.taslak',
            [
                'taslakUuid'    => null,
                'ekKalemTurleri'=> [],
                'error'         => $e->getMessage(),
                'dataSource'    => FaturaFactory::createDataSource(
                    $faturaTaslagi->{Fatura::COLUMN_DATA_SOURCE}
                ),
            ]
        );
    }
}
