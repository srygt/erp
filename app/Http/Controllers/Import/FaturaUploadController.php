<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Http\Requests\Import\FaturaUploadRequest;
use App\Models\AyarEkKalem;
use App\Models\ImportedFaturaFile;
use App\Services\Import\Fatura\FaturaUploadService;
use Illuminate\View\View;

class FaturaUploadController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        return view('import.fatura.upload.index');
    }

    public function store(FaturaUploadRequest $request, FaturaUploadService $uploadService)
    {
        $uploadedFileModel = $uploadService->uploadFile(
            $request->input('tur'),
            $request->ip(),
            $request->file('dosya')
        );

        return response()->redirectToRoute('import.fatura.upload.detay', $uploadedFileModel);
    }

    public function show(ImportedFaturaFile $faturaFile)
    {
        abort_if(
            ImportedFaturaFile::FIELD_STATUS_UPLOADED !== $faturaFile->{ImportedFaturaFile::COLUMN_STATUS},
            404
        );

        $data = [];

        $data['importedFaturaFile'] = $faturaFile;
        $data['ekKalemler']         = AyarEkKalem::where(
                AyarEkKalem::COLUMN_TUR,
                $faturaFile->{ImportedFaturaFile::COLUMN_TYPE}
            )
            ->get();

        return view('import.fatura.upload.show', $data);
    }
}
