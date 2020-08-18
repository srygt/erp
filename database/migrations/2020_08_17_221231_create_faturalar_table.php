<?php

use App\Models\Fatura;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaturalarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faturalar', function (Blueprint $table) {
            $table->id();
            $table->uuid(Fatura::COLUMN_UUID)->unique();
            $table->enum(Fatura::COLUMN_DURUM, Fatura::LIST_DURUM)->index();
            $table->string(Fatura::COLUMN_INVOICE_ID, 100)->index();
            $table->string(Fatura::COLUMN_BIRIM_FIYAT);
            $table->date(Fatura::COLUMN_SON_ODEME_TARIHI)->index();
            $table->string(Fatura::COLUMN_ENDEKS_ILK);
            $table->string(Fatura::COLUMN_ENDEKS_SON);
            $table->text(Fatura::COLUMN_NOT)->nullable();
            $table->text(Fatura::COLUMN_ISTEK)->nullable();
            $table->text(Fatura::COLUMN_CEVAP)->nullable();
            $table->text(Fatura::COLUMN_HATA)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger(Fatura::COLUMN_ABONE_ID);
            $table->foreign(Fatura::COLUMN_ABONE_ID)
                ->references('id')
                ->on('abonelikler');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faturalar');
    }
}
