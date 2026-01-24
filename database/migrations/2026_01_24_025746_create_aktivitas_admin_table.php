<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAktivitasAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aktivitas_admin', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->date('tanggal'); // Kolom tanggal
            $table->string('aktivitas'); // Kolom aktivitas
            $table->text('keterangan')->nullable(); // Kolom keterangan (nullable)
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aktivitas_admin');
    }
}
