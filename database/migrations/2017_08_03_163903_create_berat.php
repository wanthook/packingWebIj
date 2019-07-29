<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBerat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berat', function (Blueprint $table) {
            $table->string('deskripsi');
            $table->string('tipe');
            $table->decimal('berat',18,2);
            $table->integer('hapus')->default(1);
            $table->increments('id');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            
            $table->index(['deskripsi', 'tipe','hapus']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('berat');
    }
}
