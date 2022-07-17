<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking')->unique();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nama_pemesan');
            $table->unsignedBigInteger('id_paket');
            // $table->unsignedBigInteger('id_studio');
            $table->tinyInteger('durasi');
            $table->date('tanggal_booking');
            $table->string('jam_mulai');
            $table->string('jam_selesai');
            $table->double('jumlah_orang');
            $table->double('nominal_booking');
            $table->string('rekening_transfer')->nullable();
            $table->double('nominal_dp')->nullable();
            $table->double('status_bayar')->default(0);
            $table->double('status_booking')->default(0);
            $table->string('file_bukti_pembayaran')->nullable();
            $table->string('file_path')->nullable();
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
        Schema::dropIfExists('bookings');
    }
}
