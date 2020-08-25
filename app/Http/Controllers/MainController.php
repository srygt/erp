<?php

namespace App\Http\Controllers;

use App\Exceptions\HizliTeknolojiIsSuccessException;
use App\Models\Abone;
use App\Models\Fatura;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Onrslu\HtEfatura\Models\DocumentList\DocumentList;
use Onrslu\HtEfatura\Services\RestRequest;
use Onrslu\HtEfatura\Types\Enums\AppType\EArsiv;
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
        $istatistikler = Cache::remember('istatistikler', 60*60*8, function()
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

            $tumZamanGroupedByAppType   = $tumZaman->countBy(function($fatura){
                                                return $fatura->{Fatura::COLUMN_APP_TYPE};
                                            })->all();

            $toplamGidenEFatura = $tumZamanGroupedByAppType[EFatura::TYPE]  ?? 0;
            $toplamGidenEArsiv  = $tumZamanGroupedByAppType[EArsiv::TYPE]   ?? 0;

            $buAy               = $tumZaman->where('created_at', '>=', Carbon::now()->startOfMonth());

            $faturaGroupedByTur = $buAy->groupBy(Fatura::COLUMN_TUR);

            $turlereGoreToplam  = $faturaGroupedByTur->map(function($item, $key) {
                return $item->pipe(function ($collection) {
                    return $collection->sum(Fatura::COLUMN_TOPLAM_ODENECEK_UCRET);
                });
            });

            /** @var Collection $toplamAbone */
            $toplamAbone        = Abone::count();

            $documentList       = (new DocumentList)
                                    ->setAppType(new EFatura)
                                    ->setDateType(new CreatedDate)
                                    ->setStartDate(date('Y-m-d', strtotime('-6 months')))
                                    ->setEndDate(date('Y-m-d', strtotime('+1 minutes')));

            $cevap              = json_decode(
                                    (new RestRequest)->getDocumentList($documentList)->getBody()->getContents()
                                    );

            throw_if(!$cevap->IsSucceeded, new HizliTeknolojiIsSuccessException($cevap->Message));

            return [
                'toplamGelenEFatura'=> count($cevap->documents),
                'toplamGidenEFatura'=> $toplamGidenEFatura,
                'toplamGidenEArsiv' => $toplamGidenEArsiv,
                'turlereGoreToplam' => $turlereGoreToplam->toArray(),
                'toplamAbone'       => $toplamAbone,
                'yeniFaturalar'     => array_slice(
                                            array_reverse($cevap->documents),
                                            0,
                                            5,
                                            false
                                        ),
            ];
        });

        return view('index', $istatistikler);
    }
}
