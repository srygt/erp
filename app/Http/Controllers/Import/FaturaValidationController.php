<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Http\Requests\Import\FaturaValidationRequest;
use App\Models\FileImportedFatura;
use App\Services\Import\Fatura\Factories\FaturaImportFactory;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class FaturaValidationController extends Controller
{
    /**
     * @param FaturaValidationRequest $request
     * @param FileImportedFatura $faturaFile
     *
     * @return Application|Factory|View
     *
     * @throws Exception
     */
    public function show(FaturaValidationRequest $request, FileImportedFatura $faturaFile)
    {
        $faturaList = (Excel::toCollection(
            FaturaImportFactory::createImportClass(
                $faturaFile->{FileImportedFatura::COLUMN_TYPE},
                $request->validated()
            ),
            $faturaFile->getFilePath()
        ))
            ->flatten(1)
            ->map(function($item) use ($faturaFile) {
                return FaturaImportFactory::createImportRow(
                    $faturaFile->{FileImportedFatura::COLUMN_TYPE},
                    $item->toArray()
                )->toArray();
            });

        return view('import.fatura.validation', [
            'importedFaturaFile'  => $faturaFile,
            'faturaList'  => $faturaList,
            'params' => $request->validated()['params']
        ]);
    }
}
