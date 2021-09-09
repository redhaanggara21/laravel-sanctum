<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemPenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_penjualans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('NOTA_KODE');
            $table->foreign('NOTA_KODE')->on('penjualans')->references('id')->cascadeOnDelete();
            $table->unsignedBigInteger('KODE_BARANG');
            $table->foreign('KODE_BARANG')->on('barangs')->references('id')->cascadeOnDelete();
            $table->bigInteger('QTY')->default(0);
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
        Schema::dropIfExists('item__penjualans');
    }
}
