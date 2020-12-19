<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Imports\FaturasImport;
use App\Models\ImportedFaturaFile;
use App\Services\Import\Fatura\FaturaUploadService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class FaturaValidationController extends Controller
{
    /**
     * @param ImportedFaturaFile $faturaFile
     */
    public function store(ImportedFaturaFile $faturaFile)
    {
        try {

            $faturaList = (Excel::toCollection(
                new FaturasImport,
                $faturaFile->getFilePath()
            ))->flatten(1);
        }
        // @see https://github.com/Maatwebsite/Laravel-Excel/issues/2792
        catch (ValidationException $e) {
            collect(
                scandir(config('excel.temporary_files.local_path'))
            )
            // fetch only imported files
            ->filter(function($fileName){
                return Str::startsWith($fileName, 'laravel-excel');
            })
            // delete imported temp files
            ->each(function($fileName){
                unlink(config('excel.temporary_files.local_path') . DIRECTORY_SEPARATOR . $fileName);
            });

            throw $e;
        }

        return view('import.faturaConfirmation', [
            'importedFaturaFile'  => $faturaFile,
            'faturaList'  => $faturaList,
        ]);
    }
}
