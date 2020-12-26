<?php

use App\Models\Abone;
use App\Models\FileImportedFatura;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileImportedFaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_imported_faturas', function (Blueprint $table) {
            $table->id();
            $table->enum(FileImportedFatura::COLUMN_STATUS, FileImportedFatura::LIST_STATUS)
                ->default(FileImportedFatura::FIELD_STATUS_UPLOADING)
                ->index();
            $table->enum(FileImportedFatura::COLUMN_TYPE, array_keys(Abone::TUR_LIST))
                ->index();
            $table->string(FileImportedFatura::COLUMN_EXTENSION, '100')
                ->index();
            $table->string(FileImportedFatura::COLUMN_IP_ADDRESS, '100')
                ->index();
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
