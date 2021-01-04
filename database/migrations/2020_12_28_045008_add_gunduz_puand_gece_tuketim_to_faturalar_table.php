<?php

use App\Models\Fatura;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGunduzPuandGeceTuketimToFaturalarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faturalar', function (Blueprint $table) {
            $table->string(Fatura::COLUMN_GECE_TUKETIM)
                ->nullable()
                ->after(Fatura::COLUMN_BIRIM_FIYAT_TUKETIM);

            $table->string(Fatura::COLUMN_PUAND_TUKETIM)
                ->nullable()
                ->after(Fatura::COLUMN_BIRIM_FIYAT_TUKETIM);

            $table->string(Fatura::COLUMN_GUNDUZ_TUKETIM)
                ->nullable()
                ->after(Fatura::COLUMN_BIRIM_FIYAT_TUKETIM);

        });

        Schema::table('fatura_taslaklari', function (Blueprint $table) {
            $table->string(Fatura::COLUMN_GECE_TUKETIM)
                ->nullable()
                ->after(Fatura::COLUMN_BIRIM_FIYAT_TUKETIM);

            $table->string(Fatura::COLUMN_PUAND_TUKETIM)
                ->nullable()
                ->after(Fatura::COLUMN_BIRIM_FIYAT_TUKETIM);

            $table->string(Fatura::COLUMN_GUNDUZ_TUKETIM)
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
                Fatura::COLUMN_GUNDUZ_TUKETIM,
                Fatura::COLUMN_PUAND_TUKETIM,
                Fatura::COLUMN_GECE_TUKETIM,
            ]);
        });

        Schema::table('fatura_taslaklari', function (Blueprint $table) {
            $table->dropColumn([
                Fatura::COLUMN_GUNDUZ_TUKETIM,
                Fatura::COLUMN_PUAND_TUKETIM,
                Fatura::COLUMN_GECE_TUKETIM,
            ]);
        });
    }
}
