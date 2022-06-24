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
        Schema::create('master_promos', function (Blueprint $table) {
            $table->id('id_promos');
            $table->bigInteger('events_id')->default(0)->index();
            $table->bigInteger('users_id')->default(0)->index();
            $table->datetime('mulai_promos');
            $table->datetime('selesai_promos');
            $table->string('nama_promos');
            $table->string('gambar_promos');
            $table->longtext('deskripsi_promos');
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
        Schema::dropIfExists('master_promos');
    }
};
