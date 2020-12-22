<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Imports\ElektrikFaturasImport;
use App\Models\ImportedFaturaFile;
use App\Services\Import\Fatura\Models\FaturaElektrikRow;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class FaturaValidationController extends Controller
{
    /**
     * @param Request $request
     * @param ImportedFaturaFile $faturaFile
     * @return Application|Factory|View
     */
    public function show(Request $request, ImportedFaturaFile $faturaFile)
    {
        $faturaList = (Excel::toCollection(
                new ElektrikFaturasImport,
                $faturaFile->getFilePath()
            ))
            ->flatten(1)
            ->map(function($item){
                return (new FaturaElektrikRow($item->toArray()))->toArray();
            });

        return view('import.faturaValidation', [
            'importedFaturaFile'  => $faturaFile,
            'faturaList'  => $faturaList,
            'params' => [
                'gecikme_kalemi_id' => $request->input('params[gecikme_kalemi_id]'),
            ],
        ]);
    }
}
