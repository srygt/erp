<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Imports\ElektrikFaturasImport;
use App\Models\ImportedFaturaFile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class FaturaImportController extends Controller
{
    public function index(Request $request)
    {

    }

    /**
     * @param ImportedFaturaFile $faturaFile
     * @throws ValidationException
     */
    public function store(ImportedFaturaFile $faturaFile)
    {
        try {

            $faturaList = (Excel::import(
                new ElektrikFaturasImport,
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
    }
}