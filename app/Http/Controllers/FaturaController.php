<?php

namespace App\Http\Controllers;

use App\Exceptions\HizliTeknolojiIsSuccessException;
use App\Models\Abone;
use App\Models\Fatura;
use App\Models\FaturaTaslagi;
use App\Services\Fatura\FaturaFactory;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class FaturaController extends Controller
{
    public function store(Request $request)
    {
        /** @var FaturaTaslagi $faturaTaslagi */
        $faturaTaslagi = FaturaTaslagi::where('uuid', $request->uuid)->first();

        /** @var Fatura $fatura */
        $fatura = $faturaTaslagi
            ->fatura()
            ->create([
                Fatura::COLUMN_UUID             => $faturaTaslagi->{Fatura::COLUMN_UUID},
                Fatura::COLUMN_INVOICE_ID       => Fatura::getNextInvoiceId(),
                Fatura::COLUMN_ABONE_ID         => $faturaTaslagi->{Fatura::COLUMN_ABONE_ID},
                Fatura::COLUMN_BIRIM_FIYAT      => $faturaTaslagi->{Fatura::COLUMN_BIRIM_FIYAT},
                Fatura::COLUMN_SON_ODEME_TARIHI => $faturaTaslagi->{Fatura::COLUMN_SON_ODEME_TARIHI},
                Fatura::COLUMN_ENDEKS_ILK       => $faturaTaslagi->{Fatura::COLUMN_ENDEKS_ILK},
                Fatura::COLUMN_ENDEKS_SON       => $faturaTaslagi->{Fatura::COLUMN_ENDEKS_SON},
                Fatura::COLUMN_NOT              => $faturaTaslagi->{Fatura::COLUMN_NOT},
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
