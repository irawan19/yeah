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
        Schema::create('master_tickets', function (Blueprint $table) {
            $table->id('id_tickets');
            $table->bigInteger('users_id')->default(0)->index();
            $table->bigInteger('events_id')->default(0)->index();
            $table->string('nama_tickets');
            $table->longtext('deskripsi_tickets');
            $table->longtext('informasi_registrasi_tickets');
            $table->longtext('disclaimer_tickets');
            $table->double('kuota_tickets');
            $table->double('sisa_kuota_tickets');
            $table->double('harga_tickets');
            $table->boolean('status_hapus_tickets')->default(0);
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
        Schema::dropIfExists('master_tickets');
    }
};
