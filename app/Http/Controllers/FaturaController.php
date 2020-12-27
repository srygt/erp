<?php

namespace App\Http\Controllers;

use App\Exceptions\HizliTeknolojiIsSuccessException;
use App\Http\Requests\FaturaEkleRequest;
use App\Http\Requests\GelenFaturaRequest;
use App\Http\Requests\GidenFaturaRaporlariRequest;
use App\Http\Requests\GidenFaturaRequest;
use App\Models\Abone;
use App\Models\Fatura;
use App\Models\FaturaTaslagi;
use App\Services\Fatura\FaturaFactory;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Onrslu\HtEfatura\Factories\AppTypeFactory;
use Onrslu\HtEfatura\Models\DocumentList\DocumentList;
use Onrslu\HtEfatura\Services\RestRequest;
use Onrslu\HtEfatura\Types\Enums\AppType\BaseAppType;
use Onrslu\HtEfatura\Types\Enums\AppType\EArsiv;
use Onrslu\HtEfatura\Types\Enums\AppType\EFatura;
use Onrslu\HtEfatura\Types\Enums\AppType\EFaturaGiden;
use Onrslu\HtEfatura\Types\Enums\DateType\CreatedDate;
use Throwable;

class FaturaController extends Controller
{
    /**
     * @param GidenFaturaRequest $request
     * @return Application|Factory|View
     */
    public function index(GidenFaturaRequest $request)
    {
        $since = $request->input('since', GidenFaturaRequest::SINCE_DEFAULT);

        if ($since > 0) {
            $model = Fatura::where(Fatura::CREATED_AT, '>=', Carbon::parse('-' . $since . ' days'));
        }
        else {
            $model = Fatura::query();
        }

        $appType = $request->input('app_type', GidenFaturaRequest::APP_TYPE_DEFAULT);

        if ($appType > 0) {
            $model = $model->where(Fatura::COLUMN_APP_TYPE, $appType);
        }

        $faturalar = $model
            ->where(Fatura::COLUMN_DURUM, Fatura::COLUMN_DURUM_BASARILI)
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
     * @param GidenFaturaRaporlariRequest $request
     * @return Application|Factory|View
     * @throws Throwable
     */
    public function gidenFaturaRaporlari(GidenFaturaRaporlariRequest $request)
    {
        $since = $request->input('since', GidenFaturaRaporlariRequest::SINCE_DEFAULT);
        $appType = $request->input('app_type', GidenFaturaRaporlariRequest::APP_TYPE_DEFAULT);

        $appTypeClassName = AppTypeFactory::create($appType);

        /** @var BaseAppType $appTypeClass */
        $appTypeClass = new $appTypeClassName;

        $documentList       = (new DocumentList)
            ->setAppType($appTypeClass)
            ->setDateType(new CreatedDate)
            ->setStartDate(date('Y-m-d', strtotime('-' . $since . ' days')))
            ->setEndDate(date('Y-m-d', strtotime('+1 minutes')));

        $response           = json_decode(
            (new RestRequest)->getDocumentList($documentList)->getBody()->getContents()
        );

        throw_if(!$response->IsSucceeded, new HizliTeknolojiIsSuccessException($response->Message));

        return view(
            'faturalar.gidenFaturaRaporlari',
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
                'appType'   => Rule::in([EFatura::TYPE, EFaturaGiden::TYPE, EArsiv::TYPE]),
                'uuid'      => 'required|uuid',
            ])
            ->validate();

        $response = (new RestRequest)->getDocumentFile($appType, $uuid)->getBody()->getContents();
        $response = json_decode($response);

        if (!$response->IsSucceeded) {
            return redirect()
                ->route('home')
                ->withErrors($response->Message);
        }

        return response()->make(
            base64_decode($response->DocumentFile),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline;',
            ]
        );
    }

    public function store(FaturaEkleRequest $request)
    {
        /** @var FaturaTaslagi $faturaTaslagi */
        $faturaTaslagi = FaturaTaslagi::where('uuid', $request->uuid)->firstOrFail();

        /** @var Fatura $fatura */
        $fatura = $faturaTaslagi
            ->fatura()
            ->create([
                Fatura::COLUMN_UUID                 => $faturaTaslagi->{Fatura::COLUMN_UUID},
                Fatura::COLUMN_TUR                  => $faturaTaslagi->{Fatura::COLUMN_TUR},
                Fatura::COLUMN_ABONE_ID             => $faturaTaslagi->{Fatura::COLUMN_ABONE_ID},
                Fatura::COLUMN_FATURA_TARIH         => $faturaTaslagi->{Fatura::COLUMN_FATURA_TARIH},
                Fatura::COLUMN_SON_ODEME_TARIHI     => $faturaTaslagi->{Fatura::COLUMN_SON_ODEME_TARIHI},
                Fatura::COLUMN_ENDEKS_ILK           => $faturaTaslagi->{Fatura::COLUMN_ENDEKS_ILK},
                Fatura::COLUMN_ENDEKS_SON           => $faturaTaslagi->{Fatura::COLUMN_ENDEKS_SON},
                Fatura::COLUMN_BIRIM_FIYAT_TUKETIM  => $faturaTaslagi->{Fatura::COLUMN_BIRIM_FIYAT_TUKETIM},
                Fatura::COLUMN_ENDUKTIF_TUKETIM     => $faturaTaslagi->{Fatura::COLUMN_ENDUKTIF_TUKETIM},
                Fatura::COLUMN_ENDUKTIF_BIRIM_FIYAT => $faturaTaslagi->{Fatura::COLUMN_ENDUKTIF_BIRIM_FIYAT},
                Fatura::COLUMN_KAPASITIF_TUKETIM    => $faturaTaslagi->{Fatura::COLUMN_KAPASITIF_TUKETIM},
                Fatura::COLUMN_KAPASITIF_BIRIM_FIYAT=> $faturaTaslagi->{Fatura::COLUMN_KAPASITIF_BIRIM_FIYAT},
                Fatura::COLUMN_NOT                  => $faturaTaslagi->{Fatura::COLUMN_NOT},
                Fatura::COLUMN_DATA_SOURCE          => $faturaTaslagi->{Fatura::COLUMN_DATA_SOURCE},
            ]);

        $faturaService = FaturaFactory::createService($faturaTaslagi->abone->{Abone::COLUMN_TUR});

        try {
            $response = $faturaService->getBill(
                $fatura,
                $request->ek_kalemler[$faturaTaslagi->{Fatura::COLUMN_TUR}] ?? []
            );
        } catch (GuzzleException $e) {
            return self::showErrorMessage($e, $fatura);
        } catch (HizliTeknolojiIsSuccessException $e) {
            return self::showErrorMessage($e, $fatura);
        }

        $dataSource = FaturaFactory::createDataSource(
            $faturaTaslagi->{Fatura::COLUMN_DATA_SOURCE}
        );

        $dataSource->runPostFaturaOperations($request->validated(), $fatura);

        return view(
            'faturalar.fatura',
            [
                'response'      => $response,
                'dataSource'    => $dataSource
            ]
        );
    }

    protected static function showErrorMessage(Exception $e, Fatura $fatura)
    {
        return view(
            'faturalar.fatura',
            [
                'error'         => $e->getMessage(),
                'dataSource'    => FaturaFactory::createDataSource(
                    $fatura->{Fatura::COLUMN_DATA_SOURCE}
                )
            ]
        );
    }
}
