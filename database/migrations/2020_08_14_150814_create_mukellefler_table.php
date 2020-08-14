<?php

use App\Models\Mukellef;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMukelleflerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mukellefler', function (Blueprint $table) {
            $table->id();
            $table->char(Mukellef::COLUMN_VERGI_NO,10)->nullable();
            $table->char(Mukellef::COLUMN_TC_KIMLIK_NO,11)->nullable();
            $table->string(Mukellef::COLUMN_UNVAN)->nullable();
            $table->string(Mukellef::COLUMN_AD_SOYAD)->nullable();
            $table->string(Mukellef::COLUMN_VERGI_DAIRESI_SEHIR);
            $table->string(Mukellef::COLUMN_VERGI_DAIRESI_ISMI);
            $table->string(Mukellef::COLUMN_EMAIL);
            $table->string(Mukellef::COLUMN_WEBSITE)->nullable();
            $table->string(Mukellef::COLUMN_ULKE);
            $table->string(Mukellef::COLUMN_IL);
            $table->string(Mukellef::COLUMN_ILCE);
            $table->integer(Mukellef::COLUMN_ADRES);
            $table->integer(Mukellef::COLUMN_TELEFON)->nullable();
            $table->string(Mukellef::COLUMN_URN);
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
        Schema::dropIfExists('mukellefler');
    }
}
