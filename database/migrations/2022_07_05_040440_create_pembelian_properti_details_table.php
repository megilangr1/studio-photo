<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianPropertiDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian_properti_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pembelian_properti_id');
            $table->string('nama_properti');
            $table->unsignedBigInteger('kategori_id');
            $table->double('harga');
            $table->double('jumlah');
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('pembelian_properti_details');
    }
}
