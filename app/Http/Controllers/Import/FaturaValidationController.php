<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Http\Requests\Import\FaturaValidationRequest;
use App\Imports\ElektrikFaturasImport;
use App\Models\ImportedFaturaFile;
use App\Services\Import\Fatura\Elektrik\Models\Row;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class FaturaValidationController extends Controller
{
    /**
     * @param FaturaValidationRequest $request
     * @param ImportedFaturaFile $faturaFile
     * @return Application|Factory|View
     */
    public function show(FaturaValidationRequest $request, ImportedFaturaFile $faturaFile)
    {
        $faturaList = (Excel::toCollection(
                new ElektrikFaturasImport,
                $faturaFile->getFilePath()
            ))
            ->flatten(1)
            ->map(function($item){
                return (new Row($item->toArray()))->toArray();
            });

        return view('import.fatura.validation', [
            'importedFaturaFile'  => $faturaFile,
            'faturaList'  => $faturaList,
            'params' => [
                'gecikme_kalemi_id' => $request->input('params[gecikme_kalemi_id]'),
            ],
        ]);
    }
}
