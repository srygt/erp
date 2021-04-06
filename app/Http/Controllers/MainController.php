<?php

namespace App\Http\Controllers;

use App\Exceptions\HizliTeknolojiIsSuccessException;
use App\Models\Fatura;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Onrslu\HtEfatura\Models\DocumentList\DocumentList;
use Onrslu\HtEfatura\Services\RestRequest;
use Onrslu\HtEfatura\Types\Enums\AppType\EFatura;
use Onrslu\HtEfatura\Types\Enums\DateType\CreatedDate;

class MainController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function home(){
        $istatistikler_api = Cache::remember('istatistikler_api', 60*60*3, function()
        {
            $documentList       = (new DocumentList)
                                    ->setAppType(new EFatura)
                                    ->setDateType(new CreatedDate)
                                    ->setStartDate(date('Y-m-d', strtotime('-1 months')))
                                    ->setEndDate(date('Y-m-d', strtotime('+1 minutes')));

            $dlCevap            = json_decode(
                                    (new RestRequest)->getDocumentList($documentList)->getBody()->getContents()
                                    );

            throw_if(!$dlCevap->IsSucceeded, new HizliTeknolojiIsSuccessException($dlCevap->Message));

            // TODO: Hizliteknoloji, "KalanKontorSorgula" fonksiyonunu test ortamında çalışır hale getirdiğinde if bloğu kaldır
//            if (Str::contains(config('ht-efatura.api.url'), 'econnecttest'))
//            {
                $kksCevap           = json_decode('{"kalanKontor": "99999","sonucVerisi": {"toplamFaturaAdedi":'
                                        . '99999,"toplamAlanBoyutu": 0,"harcananGelenFaturaMiktari": 9999,'
                                        . '"harcananGidenFaturaMiktari": 9999,"harcananEArsivFaturaMiktari": 9999,'
                                        . '"harcananAlanMiktari": 0},"IsSucceeded": true,"Message": "Başarılı"}');
//            }
//            else {
//                $kksCevap           = json_decode(
//                    (new RestRequest)->getKalanKontorSorgula(config('fatura.vergiNo'), '0')->getBody()->getContents()
//                );
//
//                throw_if(!$kksCevap->IsSucceeded, new HizliTeknolojiIsSuccessException($kksCevap->Message));
//            }

            return [
                'yeniFaturalar'                 => array_slice(
                                                        array_reverse($dlCevap->documents),
                                                        0,
                                                        5,
                                                        false
                                                    ),
                'kalanKontor'                   => $kksCevap->kalanKontor,
                'harcananGelenFaturaMiktari'    => $kksCevap->sonucVerisi->harcananGelenFaturaMiktari,
                'harcananGidenFaturaMiktari'    => $kksCevap->sonucVerisi->harcananGidenFaturaMiktari,
                'harcananEArsivFaturaMiktari'   => $kksCevap->sonucVerisi->harcananEArsivFaturaMiktari,

            ];
        });

        $istatistikler_local = Cache::remember('istatistikler_local', 60*15, function()
        {

            /** @var Collection $tumZaman */
            $tumZaman           = Fatura::where(Fatura::COLUMN_DURUM, Fatura::COLUMN_DURUM_BASARILI)
                ->select([
                    Fatura::COLUMN_APP_TYPE,
                    Fatura::COLUMN_TOPLAM_ODENECEK_UCRET,
                    Fatura::COLUMN_TUR,
                    'created_at'
                ])
                ->get();

            $buAy               = $tumZaman->where('created_at', '>=', Carbon::now()->startOfMonth());

            $faturaGroupedByTur = $buAy->groupBy(Fatura::COLUMN_TUR);

            $turlereGoreToplam  = $faturaGroupedByTur->map(function($item, $key) {
                return $item->pipe(function ($collection) {
                    return $collection->sum(Fatura::COLUMN_TOPLAM_ODENECEK_UCRET);
                });
            });

            return [
                'turlereGoreToplam' => $turlereGoreToplam->toArray(),
            ];
        });

        return view('index', array_merge($istatistikler_api, $istatistikler_local));
    }
}
