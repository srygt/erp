<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportFaturaRequest;
use App\Services\Import\Fatura\FaturaUploadService;
use Illuminate\View\View;

class FaturaUploadController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        return view('import.importFatura');
    }

    public function store(ImportFaturaRequest $request, FaturaUploadService $uploadService)
    {
        $uploadService->uploadFile($request->input('tur'), $request->ip(), $request->file('dosya'));

        return null;
    }
}
