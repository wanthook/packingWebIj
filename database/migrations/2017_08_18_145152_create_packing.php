<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packing', function (Blueprint $table) {
            $table->string('material');
            $table->string('warna_cones');
            $table->string('batch');
            $table->decimal('tare_cones',18,2);
            $table->decimal('tare_lain',18,2)->nullable();
            $table->integer('berat_id')->unsigned()->nullable();
            $table->integer('hapus')->default(1);
            $table->increments('id');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            
            $table->index(['material', 'warna_cones', 'batch', 'hapus']);
            $table->foreign('berat_id')
                ->references('id')->on('berat')
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
        Schema::drop('packing');
    }
}
