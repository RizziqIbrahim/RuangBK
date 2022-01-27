<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_soal');
            $table->string('content');
            $table->integer('jawaban1')->default(0);
            $table->integer('jawaban2')->default(0);
            $table->integer('jawaban3')->default(0);
            $table->integer('jawaban4')->default(0);
            $table->integer('jawaban5')->default(0);
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
        Schema::dropIfExists('soals');
    }
}
