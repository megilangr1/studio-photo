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
            $table->unsignedBigInteger('id_studio');
            $table->tinyInteger('durasi');
            $table->date('tanggal_booking');
            $table->string('jam_mulai');
            $table->string('jam_selesai');
            $table->double('jumlah_orang');
            $table->double('nominal_booking');
            $table->string('rekening_transfer');
            $table->double('nominal_dp');
            $table->double('status_bayar');
            $table->string('file_bukti_pembayaran');
            $table->string('file_path');
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
