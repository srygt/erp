<?php

use App\Models\Ayar;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAyarlarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ayarlar', function (Blueprint $table) {
            $table->string(Ayar::COLUMN_BASLIK, 100)->unique();
            $table->string(Ayar::COLUMN_DEGER, 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ayarlar');
    }
}
