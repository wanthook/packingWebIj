<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePalet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('palet', function (Blueprint $table) {
            $table->string('material');
            $table->string('warna_cones');
            $table->string('batch');
            $table->string('mill');
            $table->decimal('tTare_cones',18,2)->nullable();
            $table->decimal('tTare_lain',18,2)->nullable();
            $table->string('tipe_berat');
            $table->decimal('tBerat',18,2);
            $table->decimal('tStandar',18,2);
            $table->decimal('tActual',18,2);
            $table->integer('tTotal_cones')->nullable();
            $table->decimal('tBerat_papan',18,2)->nullable();
            $table->integer('start_no');
            $table->integer('end_no');
            $table->integer('hapus')->default(1);
            $table->increments('id');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            
            $table->index('start_no');
            $table->index('end_no');
            $table->index('material');
            $table->index('warna_cones');
            $table->index('batch');
            $table->index('mill');
            $table->index('tipe_berat');
            $table->index('hapus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('palet');
    }
}
