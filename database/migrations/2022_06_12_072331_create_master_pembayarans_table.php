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
        Schema::create('master_pembayarans', function (Blueprint $table) {
            $table->id('id_pembayarans');
            $table->bigInteger('tipe_pembayarans_id')->default(0)->index();
            $table->string('logo_pembayarans');
            $table->string('nama_pembayarans');
            $table->string('nama_rekening_pembayarans');
            $table->string('no_rekening_pembayarans');
            $table->boolean('status_hapus_pembayarans')->default(0);
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
        Schema::dropIfExists('master_pembayarans');
    }
};
