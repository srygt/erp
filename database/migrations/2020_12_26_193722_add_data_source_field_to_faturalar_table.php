<?php

use App\Models\Fatura;
use App\Models\FaturaTaslagi;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataSourceFieldToFaturalarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fatura_taslaklari', function (Blueprint $table) {
            $table->enum(
                Fatura::COLUMN_DATA_SOURCE,
                Fatura::LIST_DATA_SOURCES
            )
                ->index();
        });

        Schema::table('faturalar', function (Blueprint $table) {
            $table->enum(
                Fatura::COLUMN_DATA_SOURCE,
                Fatura::LIST_DATA_SOURCES
            )
                ->index();
        });

        Fatura::chunk(100, function ($faturalar) {
            foreach ($faturalar as &$fatura) {
                $fatura->update([
                    Fatura::COLUMN_DATA_SOURCE => Fatura::COLUMN_DATA_SOURCE_MANUAL,
                ]);
            }
        });

        FaturaTaslagi::chunk(100, function ($faturalar) {
            foreach ($faturalar as &$fatura) {
                $fatura->update([
                    Fatura::COLUMN_DATA_SOURCE => Fatura::COLUMN_DATA_SOURCE_MANUAL,
                ]);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fatura_taslaklari', function (Blueprint $table) {
            $table->dropColumn([
                Fatura::COLUMN_DATA_SOURCE,
            ]);
        });

        Schema::table('faturalar', function (Blueprint $table) {
            $table->dropColumn([
                Fatura::COLUMN_DATA_SOURCE,
            ]);
        });
    }
}
