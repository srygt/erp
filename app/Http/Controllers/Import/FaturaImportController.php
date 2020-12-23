<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Http\Requests\Import\FaturaImportRequest;
use App\Imports\ElektrikFaturasImport;
use App\Models\ImportedFaturaFile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class FaturaImportController extends Controller
{
    public function index(Request $request)
    {

    }

    /**
     * @param FaturaImportRequest $request
     * @param ImportedFaturaFile $faturaFile
     * @throws ValidationException
     * @throws \Throwable
     */
    public function store(FaturaImportRequest $request, ImportedFaturaFile $faturaFile)
    {
        DB::beginTransaction();

        try {
            $faturaList = (Excel::import(
                new ElektrikFaturasImport($request->validated()['params']),
                $faturaFile->getFilePath()
            ));

            $faturaFile->{ImportedFaturaFile::COLUMN_STATUS} = ImportedFaturaFile::FIELD_STATUS_IMPORTED;
            $faturaFile->save();
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
        catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }

        DB::commit();
    }
}
