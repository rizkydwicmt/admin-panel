<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TransaksiVbac extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_vbac', function (Blueprint $table) {
            $table->id();
            $table->string('hwid');
            $table->string('username');
            $table->string('atas_nama');
            $table->string('via');
            $table->integer('extend')->comment = 'Bulan';
            $table->integer('harga');
            $table->boolean('status')->comment = '0 Dibatalkan, 1 Terbayar';
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
        Schema::dropIfExists('transaksi_vbac');
    }
}
