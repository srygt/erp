<?php

use App\Models\ImportedFaturaEkKalem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportedFaturaEkKalemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imported_fatura_ek_kalems', function (Blueprint $table) {
            $table->id();
            $table->foreignId(ImportedFaturaEkKalem::COLUMN_EK_KALEM_ID)
                ->constrained('ayarlar_ek_kalemler');
            $table->foreignId(ImportedFaturaEkKalem::COLUMN_IMPORTED_FATURA_ID)
                ->constrained();
            $table->decimal(
                    ImportedFaturaEkKalem::COLUMN_DEGER,
                    24,
                    9
                )
                ->nullable();
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
        Schema::dropIfExists('imported_fatura_ek_kalems');
    }
}
