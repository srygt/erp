<?php


namespace App\Services\Import\Fatura;


use App\Models\ImportedFaturaFile;
use Illuminate\Http\UploadedFile;

class FaturaUploadService
{
    const FILE_EXTENSION    = '.csv';

    /**
     * @param string $type imported file type (Abone::TUR_LIST)
     * @param string $ip
     * @param UploadedFile $file
     * @return ImportedFaturaFile
     */
    public function uploadFile(string $type, string $ip, UploadedFile $file) : ImportedFaturaFile
    {
        $importedFileModel  = $this->createModel($type, $ip);

        $this->copyFile($file, $importedFileModel);

        $importedFileModel  = $this->makeStatusUploaded($importedFileModel);

        return $importedFileModel;
    }

    /**
     * @param string $type
     * @param string $ip
     * @return ImportedFaturaFile
     */
    protected function createModel(string $type, string $ip) : ImportedFaturaFile
    {
        $importedFaturaFile = new ImportedFaturaFile();

        $importedFaturaFile->{ImportedFaturaFile::COLUMN_TYPE}          = $type;
        $importedFaturaFile->{ImportedFaturaFile::COLUMN_IP_ADDRESS}    = $ip;

        $importedFaturaFile->save();

        return $importedFaturaFile;
    }

    /**
     * @param UploadedFile $file
     * @param ImportedFaturaFile $importedFileModel
     * @return false|string
     */
    protected function copyFile(UploadedFile $file, ImportedFaturaFile $importedFileModel)
    {
        return $file->storeAs(
            config('fatura.importPath'),
            $importedFileModel->{ImportedFaturaFile::COLUMN_ID} . self::FILE_EXTENSION
        );
    }

    /**
     * @param ImportedFaturaFile $importedFileModel
     * @return ImportedFaturaFile
     */
    protected function makeStatusUploaded(ImportedFaturaFile $importedFileModel) : ImportedFaturaFile
    {
        $importedFileModel->{ImportedFaturaFile::COLUMN_STATUS}         = ImportedFaturaFile::FIELD_STATUS_UPLOADED;
        $importedFileModel->save();

        return $importedFileModel;
    }
}
