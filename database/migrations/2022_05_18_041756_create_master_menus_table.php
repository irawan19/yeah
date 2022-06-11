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
        Schema::create('master_menus', function (Blueprint $table) {
            $table->id('id_menus');
            $table->bigInteger('sub_menus_id')->index()->default(0);
            $table->string('nama_menus');
            $table->string('link_menus');
            $table->string('icon_menus');
            $table->double('order_menus');
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
        Schema::dropIfExists('master_menus');
    }
};
