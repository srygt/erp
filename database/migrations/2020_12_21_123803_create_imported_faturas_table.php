<?php

use App\Models\Abone;
use App\Models\ImportedFatura;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportedFaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imported_faturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId(ImportedFatura::COLUMN_ABONE_ID)->constrained('abonelikler');
            $table->enum(ImportedFatura::COLUMN_TUR, array_keys(Abone::TUR_LIST))->index();
            $table->dateTime(ImportedFatura::COLUMN_FATURA_TARIH)->nullable()->index();
            $table->date(ImportedFatura::COLUMN_SON_ODEME_TARIHI)->nullable()->index();
            $table->string(ImportedFatura::COLUMN_ENDEKS_ILK);
            $table->string(ImportedFatura::COLUMN_ENDEKS_SON);
            $table->decimal(ImportedFatura::COLUMN_BIRIM_FIYAT_TUKETIM, 12, 9)->unsigned();
            $table->text(ImportedFatura::COLUMN_NOT)->nullable();
            $table->unsignedBigInteger(ImportedFatura::COLUMN_OKUYAN_ID)->nullable()->index();
            $table->string(ImportedFatura::COLUMN_IP_NO, 100)->index();
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
        Schema::dropIfExists('imported_faturas');
    }
}
