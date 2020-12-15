<?php

use App\Models\ImportedFaturaFile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportedFaturaFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imported_fatura_files', function (Blueprint $table) {
            $table->id();
            $table->enum(ImportedFaturaFile::COLUMN_STATUS, ImportedFaturaFile::LIST_STATUS)
                ->default(ImportedFaturaFile::FIELD_STATUS_UPLOADING);
            $table->enum(ImportedFaturaFile::COLUMN_TYPE, ImportedFaturaFile::LIST_TYPES);
            $table->string(ImportedFaturaFile::COLUMN_IP_ADDRESS);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imported_fatura_files');
    }
}
