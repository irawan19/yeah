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
        Schema::create('master_events', function (Blueprint $table) {
            $table->id('id_events');
            $table->bigInteger('users_id')->default(0)->index();
            $table->datetime('tanggal_events');
            $table->datetime('mulai_registrasi_events');
            $table->datetime('selesai_registrasi_events');
            $table->string('gambar_events');
            $table->string('nama_events');
            $table->longtext('deskripsi_events');
            $table->longtext('disclaimer_events');
            $table->longtext('lokasi_events');
            $table->double('status_hapus_events')->default(0);
            $table->string('kode_scanner_events');
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
        Schema::dropIfExists('master_events');
    }
};
