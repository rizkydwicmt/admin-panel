<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BotVbac extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot_vbac', function (Blueprint $table) {
            $table->id();
            $table->string('hwid')->unique();
            $table->string('code')->unique();
            $table->string('owner');
            $table->integer('expired_day');
            $table->string('keterangan');
            $table->boolean('status')->comment = '0 Nonaktif, 1 Aktif';
            $table->string('created_by');
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
        Schema::dropIfExists('bot_vbac');
    }
}
