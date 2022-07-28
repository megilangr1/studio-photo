<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKasBesarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kas_besars', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_data');
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->tinyInteger('jenis_data');
            $table->string('asal_uang');
            $table->double('nominal');
            $table->text('keterangan')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('kas_besars');
    }
}
