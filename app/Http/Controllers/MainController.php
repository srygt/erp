<?php

namespace App\Http\Controllers;

use App\Models\Abone;
use App\Models\Fatura;
use App\Models\Mukellef;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

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
            /** @var Collection $toplamUcret */
            $tumZaman           = Fatura::where(Fatura::COLUMN_DURUM, Fatura::COLUMN_DURUM_BASARILI)
                ->select([
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

            /** @var Collection $toplamMukellef */
            $toplamMukellef     = Mukellef::count();

            /** @var Collection $toplamAbone */
            $toplamAbone        = Abone::count();

            return [
                'toplamUcret'       => $tumZaman->sum(Fatura::COLUMN_TOPLAM_ODENECEK_UCRET),
                'buAydakiUcret'     => $buAy->sum(Fatura::COLUMN_TOPLAM_ODENECEK_UCRET),
                'turlereGoreToplam' => $turlereGoreToplam->toArray(),
                'toplamMukellef'    => $toplamMukellef,
                'toplamAbone'       => $toplamAbone,
            ];
        });

        return view('index', $istatistikler);
    }
}
