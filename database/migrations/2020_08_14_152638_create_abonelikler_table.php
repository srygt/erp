<?php

use App\Models\Abone;
use App\Models\Mukellef;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboneliklerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonelikler', function (Blueprint $table) {
            $table->id();
            $table->enum(
                Abone::COLUMN_TUR,
                [
                    Abone::COLUMN_TUR_SU,
                    Abone::COLUMN_TUR_ELEKTRIK,
                    Abone::COLUMN_TUR_DOGALGAZ,
                ]);
            $table->string(Abone::COLUMN_BASLIK);
            $table->string(Abone::COLUMN_ABONE_NO);
            $table->string(Abone::COLUMN_SAYAC_NO);

            // aşağıdaki alanlarda yapılacak değişikliklerin
            // 2020_08_14_150814_create_mukellefler_table'da da yapılması lazım
            $table->string(Mukellef::COLUMN_EMAIL)->nullable();
            $table->string(Mukellef::COLUMN_WEBSITE)->nullable();
            $table->string(Mukellef::COLUMN_ULKE);
            $table->string(Mukellef::COLUMN_IL);
            $table->string(Mukellef::COLUMN_ILCE);
            $table->string(Mukellef::COLUMN_ADRES)->nullable();
            $table->string(Mukellef::COLUMN_TELEFON)->nullable();
            $table->string(Mukellef::COLUMN_URN)->nullable();

            $table->unsignedBigInteger('mukellef_id');
            $table->foreign('mukellef_id')
                ->references('id')
                ->on('mukellefler');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abonelikler');
    }
}
