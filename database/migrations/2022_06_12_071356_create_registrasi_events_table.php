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
        Schema::create('registrasi_events', function (Blueprint $table) {
            $table->id('id_registrasi_events');
            $table->bigInteger('tickets_id')->default(0)->index();
            $table->bigInteger('pembayarans_id')->default(0)->index();
            $table->bigInteger('status_pembayarans_id')->default(0)->index();
            $table->string('no_registrasi_events');
            $table->double('total_registrasi_events');
            $table->double('total_harga_registrasi_events');
            $table->string('bukti_pembayaran_registrasi_events')->nullable();
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
        Schema::dropIfExists('registrasi_events');
    }
};
