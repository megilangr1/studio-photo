<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiFotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properti_fotos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('studio_id');
            $table->string('nama_properti');
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar')->nullable();
            $table->unsignedBigInteger('kategori_id');
            $table->string('kondisi');
            $table->string('keterangan');
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
        Schema::dropIfExists('properti_fotos');
    }
}
