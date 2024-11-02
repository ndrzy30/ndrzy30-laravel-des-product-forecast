<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrediksisTable extends Migration
{
    public function up()
    {
        Schema::create('prediksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('obat_id');
            $table->date('periode');
            $table->double('alpha');
            $table->double('beta');
            $table->double('hasil_prediksi');
            $table->double('nilai_mad')->nullable();
            $table->double('nilai_mse')->nullable();
            $table->double('nilai_mape')->nullable();
            $table->timestamps();
            
            $table->foreign('obat_id')->references('id')->on('obats')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prediksis');
    }
}