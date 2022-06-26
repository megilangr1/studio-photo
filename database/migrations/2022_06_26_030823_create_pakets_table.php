<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pakets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->double('harga');
            $table->unsignedTinyInteger('jumlah_foto');
            $table->unsignedTinyInteger('durasi')->default(0);
            $table->unsignedTinyInteger('jumlah_baju')->default(0);
            $table->unsignedTinyInteger('pose')->default(0);
            $table->double('harga_tambah_foto')->default(0);
            $table->string('informasi_tambahan')->nullable();
            $table->text('keterangan_lainnya')->nullable();
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
        Schema::dropIfExists('pakets');
    }
}
