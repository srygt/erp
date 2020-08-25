<?php

use App\AyarEkKalem;
use App\Models\Abone;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAyarlarEkKalemlerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ayarlar_ek_kalemler', function (Blueprint $table) {
            $table->id();
            $table->enum(AyarEkKalem::COLUMN_TUR, array_keys(Abone::TUR_LIST))->index();
            $table->string(AyarEkKalem::COLUMN_BASLIK);
            $table->decimal(AyarEkKalem::COLUMN_DEGER, 12, 9);
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
        Schema::dropIfExists('ayarlar_ek_kalemler');
    }
}
