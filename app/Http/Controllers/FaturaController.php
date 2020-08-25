<?php

namespace App\Http\Controllers;

use App\Exceptions\HizliTeknolojiIsSuccessException;
use App\Http\Requests\GelenFaturaRequest;
use App\Models\Abone;
use App\Models\Fatura;
use App\Models\FaturaTaslagi;
use App\Services\Fatura\FaturaFactory;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Onrslu\HtEfatura\Models\DocumentList\DocumentList;
use Onrslu\HtEfatura\Services\RestRequest;
use Onrslu\HtEfatura\Types\Enums\AppType\EArsiv;
use Onrslu\HtEfatura\Types\Enums\AppType\EFatura;
use Onrslu\HtEfatura\Types\Enums\DateType\CreatedDate;
use Throwable;

class FaturaController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $faturalar = Fatura::where(Fatura::COLUMN_DURUM, Fatura::COLUMN_DURUM_BASARILI)
            ->orderBy(Fatura::COLUMN_ID, 'DESC')
            ->with('abone.mukellef')
            ->get();

        return view('faturalar.liste',['faturalar' => $faturalar]);
    }

    /**
     * @param GelenFaturaRequest $request
     * @return Application|Factory|View
     * @throws Throwable
     */
    public function gelenFaturalar(GelenFaturaRequest $request)
    {
        $since = $request->input('since', GelenFaturaRequest::SINCE_DEFAULT);

        $documentList       = (new DocumentList)
            ->setAppType(new EFatura)
            ->setDateType(new CreatedDate)
            ->setStartDate(date('Y-m-d', strtotime('-' . $since . ' days')))
            ->setEndDate(date('Y-m-d', strtotime('+1 minutes')));

        $response           = json_decode(
            (new RestRequest)->getDocumentList($documentList)->getBody()->getContents()
        );

        throw_if(!$response->IsSucceeded, new HizliTeknolojiIsSuccessException($response->Message));

        return view(
            'faturalar.gelenFaturaListe',
            [
                'faturalar' => array_reverse($response->documents),
            ]
        );
    }

    /**
     * @param $appType
     * @param $uuid
     * @return Response|mixed
     * @throws GuzzleException
     * @throws BindingResolutionException
     * @throws Throwable
     */
    public function download($appType, $uuid)
    {
        Validator::make([
                'appType'   => $appType,
                'uuid'      => $uuid
            ],
            [
                'appType'   => Rule::in([EFatura::TYPE, EArsiv::TYPE]),
                'uuid'      => 'required|uuid',
            ])
            ->validate();

        $response = (new RestRequest)->getDocumentFile($uuid)->getBody()->getContents();
        $response = json_decode($response);

        throw_if(!$response->IsSucceeded, new HizliTeknolojiIsSuccessException($response->Message));

        return response()->make(
            base64_decode($response->DocumentFile),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline;',
            ]
        );
    }

    public function store(Request $request)
    {
        /** @var FaturaTaslagi $faturaTaslagi */
        $faturaTaslagi = FaturaTaslagi::where('uuid', $request->uuid)->first();

        /** @var Fatura $fatura */
        $fatura = $faturaTaslagi
            ->fatura()
            ->create([
                Fatura::COLUMN_UUID                 => $faturaTaslagi->{Fatura::COLUMN_UUID},
                Fatura::COLUMN_TUR                  => $faturaTaslagi->{Fatura::COLUMN_TUR},
                Fatura::COLUMN_INVOICE_ID           => Fatura::getNextInvoiceId(),
                Fatura::COLUMN_ABONE_ID             => $faturaTaslagi->{Fatura::COLUMN_ABONE_ID},
                Fatura::COLUMN_BIRIM_FIYAT_TUKETIM  => $faturaTaslagi->{Fatura::COLUMN_BIRIM_FIYAT_TUKETIM},
                Fatura::COLUMN_SON_ODEME_TARIHI     => $faturaTaslagi->{Fatura::COLUMN_SON_ODEME_TARIHI},
                Fatura::COLUMN_ENDEKS_ILK           => $faturaTaslagi->{Fatura::COLUMN_ENDEKS_ILK},
                Fatura::COLUMN_ENDEKS_SON           => $faturaTaslagi->{Fatura::COLUMN_ENDEKS_SON},
                Fatura::COLUMN_NOT                  => $faturaTaslagi->{Fatura::COLUMN_NOT},
            ]);

        $faturaService = FaturaFactory::getService($faturaTaslagi->abone->{Abone::COLUMN_TUR});

        try {
            $response = $faturaService->getBill($fatura);
        } catch (GuzzleException $e) {
            return self::showErrorMessage($e);
        } catch (HizliTeknolojiIsSuccessException $e) {
            return self::showErrorMessage($e);
        }

        return view('faturalar.fatura', ['response' => $response]);
    }

    protected static function showErrorMessage(Exception $e)
    {
        return view(
            'faturalar.fatura',
            [
                'error'         => $e->getMessage(),
            ]
        );
    }
}
