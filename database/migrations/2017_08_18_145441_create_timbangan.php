<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimbangan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timbangan', function (Blueprint $table) {
            $table->integer('no');
            $table->string('material');
            $table->string('warna_cones');
            $table->string('batch');
            $table->string('mill');
            $table->decimal('tare_cones',18,2)->nullable();
            $table->decimal('tare_lain',18,2)->nullable();
            $table->string('tipe_berat');
            $table->decimal('berat',18,2);
            $table->decimal('standar',18,2);
            $table->decimal('actual',18,2);
            $table->integer('total_cones')->nullable();
            $table->decimal('berat_papan',18,2)->nullable();
            $table->integer('packing_id')->unsigned();
            $table->integer('palet_id')->unsigned()->nullable();
            $table->integer('hapus')->default(1);
            $table->increments('id');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            
            $table->index('no');
            $table->index('material');
            $table->index('warna_cones');
            $table->index('batch');
            $table->index('mill');
            $table->index('tipe_berat');
            $table->index('hapus');
            
            $table->foreign('packing_id')
                ->references('id')->on('packing')
                ->onDelete('cascade');
            $table->foreign('palet_id')
                ->references('id')->on('palet')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('timbangan');
    }
}
