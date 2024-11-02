<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualansTable extends Migration
{
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('obat_id');
            $table->date('tanggal');
            $table->integer('jumlah');
            $table->timestamps();
            
            $table->foreign('obat_id')->references('id')->on('obats')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
}