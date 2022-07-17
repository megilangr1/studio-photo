<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddOnBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_on_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_booking');
            $table->unsignedBigInteger('id_paket');
            $table->unsignedBigInteger('id_biaya_lainnya');
            $table->string('nama_biaya');
            $table->string('nominal_biaya');
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
        Schema::dropIfExists('add_on_bookings');
    }
}
