<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_sosial_media', function (Blueprint $table) {
            $table->id('id_sosial_medias');
            $table->string('nama_sosial_medias');
            $table->string('icon_sosial_medias');
            $table->string('url_sosial_medias');
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
        Schema::dropIfExists('master_sosial_media');
    }
};
