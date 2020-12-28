<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Http\Requests\Import\FaturaDeleteRequest;
use App\Http\Requests\Import\FaturaImportRequest;
use App\Http\Requests\Import\FaturaListRequest;
use App\Imports\ElektrikFaturasImport;
use App\Models\ImportedFatura;
use App\Models\FileImportedFatura;
use App\Services\Import\Fatura\Factories\FaturaImportFactory;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Throwable;

class FaturaImportController extends Controller
{
    public function index(FaturaListRequest $request)
    {
        $model = ImportedFatura::with('abone.mukellef');

        if ($request->input('tur')) {
            $model = $model->where(ImportedFatura::COLUMN_TUR, $request->input('tur'));
        }

        return view(
            'import.fatura.liste',
            [
                'faturalar' => $model->get(),
            ]
        );
    }

    /**
     * @param ImportedFatura $importedFatura
     *
     * @return Application|Factory|View
     * @throws Exception
     */
    public function show(ImportedFatura $importedFatura)
    {
        $importedFaturaAdapter = FaturaImportFactory::createFaturaAdapter($importedFatura);

        $params = $importedFaturaAdapter->toFormArray(
            $importedFaturaAdapter->getInvoicableArray()
        );

        return view(
            'import.fatura.redirectToPay',
            [
                'params' => $params,
            ]
        );
    }

    /**
     * @param FaturaImportRequest $request
     * @param FileImportedFatura $faturaFile
     * @throws ValidationException
     * @throws Throwable
     */
    public function store(FaturaImportRequest $request, FileImportedFatura $faturaFile)
    {
        DB::beginTransaction();

        try {
            $faturaList = (Excel::import(
                new ElektrikFaturasImport($request->validated()['params']),
                $faturaFile->getFilePath()
            ));

            $faturaFile->{FileImportedFatura::COLUMN_STATUS} = FileImportedFatura::FIELD_STATUS_IMPORTED;
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

        return redirect()
            ->route('import.fatura.liste')
            ->with([
                'message' => 'Fatura içe aktarma işlemi başarılı!',
            ]);
    }

    public function delete(FaturaDeleteRequest $request)
    {
        $importedFatura = ImportedFatura::findOrFail($request->id);

        $importedFatura->delete();

        return redirect()->back()->with('message', 'Fatura Taslağı Başarıyla Silindi');
    }
}
