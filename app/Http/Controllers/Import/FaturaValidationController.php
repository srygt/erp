<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Http\Requests\Import\FaturaValidationRequest;
use App\Imports\ElektrikFaturasImport;
use App\Models\FileImportedFatura;
use App\Services\Import\Fatura\Elektrik\Models\Row;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class FaturaValidationController extends Controller
{
    /**
     * @param FaturaValidationRequest $request
     * @param FileImportedFatura $faturaFile
     * @return Application|Factory|View
     */
    public function show(FaturaValidationRequest $request, FileImportedFatura $faturaFile)
    {
        $faturaList = (Excel::toCollection(
                new ElektrikFaturasImport([]),
                $faturaFile->getFilePath()
            ))
            ->flatten(1)
            ->map(function($item){
                return (new Row($item->toArray()))->toArray();
            });

        return view('import.fatura.validation', [
            'importedFaturaFile'  => $faturaFile,
            'faturaList'  => $faturaList,
            'params' => $request->validated()['params']
        ]);
    }
}
