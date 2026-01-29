<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAktivitasHrTable extends Migration
{
    public function up()
    {
        Schema::create('aktivitas_hr', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal');
            $table->string('aktivitas');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('aktivitas_hr');
    }
}
