<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaultSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_setups', function (Blueprint $table) {
            $table->id();
            $table->string('no_rekening_bca')->nullable();
            $table->string('nama_rekening_bca')->nullable();
            $table->string('no_rekening_bri')->nullable();
            $table->string('nama_rekening_bri')->nullable();
            $table->string('faq_1')->nullable();
            $table->text('faqa_1')->nullable();
            $table->string('faq_2')->nullable();
            $table->text('faqa_2')->nullable();
            $table->string('faq_3')->nullable();
            $table->text('faqa_3')->nullable();
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
        Schema::dropIfExists('default_setups');
    }
}
