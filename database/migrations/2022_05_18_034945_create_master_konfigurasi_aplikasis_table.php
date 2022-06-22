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
        Schema::create('master_konfigurasi_aplikasis', function (Blueprint $table) {
            $table->id('id_konfigurasi_aplikasis');
            $table->string('nama_konfigurasi_aplikasis');
            $table->longtext('keywords_konfigurasi_aplikasis');
            $table->longtext('deskripsi_konfigurasi_aplikasis');
            $table->string('icon_konfigurasi_aplikasis');
            $table->string('logo_konfigurasi_aplikasis');
            $table->string('logo_text_konfigurasi_aplikasis');
            $table->string('whatsapp_konfigurasi_aplikasis');
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
        Schema::dropIfExists('master_konfigurasi_aplikasis');
    }
};
