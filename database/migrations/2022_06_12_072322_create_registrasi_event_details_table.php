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
        Schema::create('registrasi_event_details', function (Blueprint $table) {
            $table->id('id_registrasi_event_details');
            $table->bigInteger('registrasi_events_id')->default(0)->index();
            $table->bigInteger('jenis_kelamins_id')->default(0)->index();
            $table->string('nama_registrasi_event_details');
            $table->double('umur_registrasi_event_details');
            $table->string('email_registrasi_event_details');
            $table->string('telepon_registrasi_event_details');
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
        Schema::dropIfExists('registrasi_event_details');
    }
};
