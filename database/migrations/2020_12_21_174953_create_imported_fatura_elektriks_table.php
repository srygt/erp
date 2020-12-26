<?php

use App\Models\ImportedFaturaElektrik;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportedFaturaElektriksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imported_fatura_elektriks', function (Blueprint $table) {
            $table->id();
            $table->string(ImportedFaturaElektrik::COLUMN_GUNDUZ_TUKETIM);
            $table->string(ImportedFaturaElektrik::COLUMN_PUAND_TUKETIM);
            $table->string(ImportedFaturaElektrik::COLUMN_GECE_TUKETIM);
            $table->decimal(ImportedFaturaElektrik::COLUMN_KAPASITIF_BIRIM_FIYAT, 12, 9)
                ->unsigned()
                ->nullable();
            $table->decimal(ImportedFaturaElektrik::COLUMN_KAPASITIF_TUKETIM, 21, 9)
                ->unsigned()
                ->nullable();
            $table->decimal(ImportedFaturaElektrik::COLUMN_ENDUKTIF_BIRIM_FIYAT, 12, 9)
                ->unsigned()
                ->nullable();
            $table->decimal(ImportedFaturaElektrik::COLUMN_ENDUKTIF_TUKETIM, 21, 9)
                ->unsigned()
                ->nullable();
            $table->boolean(ImportedFaturaElektrik::COLUMN_IS_TRT_PAYI);
            $table->foreignId(ImportedFaturaElektrik::COLUMN_IMPORTED_FATURA_ID)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('imported_fatura_elektriks');
    }
}
