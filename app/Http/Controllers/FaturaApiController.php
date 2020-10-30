<?php

namespace App\Http\Controllers;

use App\Exceptions\HizliTeknolojiIsSuccessException;
use App\Http\Requests\OkumaDurumuRequest;
use App\Http\Requests\SonFaturaDetayRequest;
use App\Models\Fatura;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;
use Onrslu\HtEfatura\Services\RestRequest;
use Onrslu\HtEfatura\Types\Enums\AppType\EFatura;

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

    /**
     * @param OkumaDurumuRequest $request
     * @return Response
     * @throws HizliTeknolojiIsSuccessException
     * @throws GuzzleException
     */
    public function okumaDurumu(OkumaDurumuRequest $request)
    {
        $response   = (new RestRequest())
                        ->setDocumentFlag(
                            new EFatura,
                            $request->uuid,
                            'OKUNDU',
                            (int) $request->isMarkReaded
                        )
                        ->getBody()
                        ->getContents();

        $response   = json_decode($response);

        if (!($response->IsSucceeded ?? false)) {
            throw new HizliTeknolojiIsSuccessException($response->Message);
        }

        return response()->noContent();
    }
}
