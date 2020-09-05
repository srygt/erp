<?php

use App\Models\Fatura;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnduktifAndKapasitifFieldsToFaturalarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faturalar', function (Blueprint $table)
        {
            $table->decimal(Fatura::COLUMN_KAPASITIF_BIRIM_FIYAT, 12, 9)
                ->unsigned()
                ->nullable()
                ->after(Fatura::COLUMN_BIRIM_FIYAT_TUKETIM);

            $table->decimal(Fatura::COLUMN_KAPASITIF_TUKETIM, 21, 9)
                ->unsigned()
                ->nullable()
                ->after(Fatura::COLUMN_BIRIM_FIYAT_TUKETIM);

            $table->decimal(Fatura::COLUMN_ENDUKTIF_BIRIM_FIYAT, 12, 9)
                ->unsigned()
                ->nullable()
                ->after(Fatura::COLUMN_BIRIM_FIYAT_TUKETIM);

            $table->decimal(Fatura::COLUMN_ENDUKTIF_TUKETIM, 21, 9)
                ->unsigned()
                ->nullable()
                ->after(Fatura::COLUMN_BIRIM_FIYAT_TUKETIM);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faturalar', function (Blueprint $table) {
            $table->dropColumn([
                Fatura::COLUMN_ENDUKTIF_TUKETIM,
                Fatura::COLUMN_ENDUKTIF_BIRIM_FIYAT,
                Fatura::COLUMN_KAPASITIF_TUKETIM,
                Fatura::COLUMN_KAPASITIF_BIRIM_FIYAT,
            ]);
        });
    }
}
