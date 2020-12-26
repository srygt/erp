<?php


namespace App\Services\Import\Fatura;


use App\Models\FileImportedFatura;
use Illuminate\Http\UploadedFile;

class FaturaUploadService
{
    /**
     * @param string $type imported file type (Abone::TUR_LIST)
     * @param string $ip
     * @param UploadedFile $file
     * @return FileImportedFatura
     */
    public function uploadFile(string $type, string $ip, UploadedFile $file) : FileImportedFatura
    {
        $importedFileModel  = $this->createModel($type, $file->extension(), $ip);

        $this->copyFile($file, $importedFileModel);

        $importedFileModel  = $this->makeStatusUploaded($importedFileModel);

        return $importedFileModel;
    }

    /**
     * @param string $type
     * @param string $extension
     * @param string $ip
     * @return FileImportedFatura
     */
    protected function createModel(string $type, string $extension, string $ip) : FileImportedFatura
    {
        $importedFaturaFile = new FileImportedFatura();

        $importedFaturaFile->{FileImportedFatura::COLUMN_TYPE}          = $type;
        $importedFaturaFile->{FileImportedFatura::COLUMN_EXTENSION}     = $extension;
        $importedFaturaFile->{FileImportedFatura::COLUMN_IP_ADDRESS}    = $ip;

        $importedFaturaFile->save();

        return $importedFaturaFile;
    }

    /**
     * @param UploadedFile $file
     * @param FileImportedFatura $importedFileModel
     * @return false|string
     */
    protected function copyFile(UploadedFile $file, FileImportedFatura $importedFileModel)
    {
        return $file->storeAs(
            config('fatura.importPath'),
            $importedFileModel->getFileName()
        );
    }

    /**
     * @param FileImportedFatura $importedFileModel
     * @return FileImportedFatura
     */
    protected function makeStatusUploaded(FileImportedFatura $importedFileModel) : FileImportedFatura
    {
        $importedFileModel->{FileImportedFatura::COLUMN_STATUS}         = FileImportedFatura::FIELD_STATUS_UPLOADED;
        $importedFileModel->save();

        return $importedFileModel;
    }
}
