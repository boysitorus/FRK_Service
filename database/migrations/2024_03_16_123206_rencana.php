<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('rencana', function (Blueprint $table) {
            $table->id('id_rencana');
            $table->string('jenis_rencana');
            $table->string('sub_rencana');
            $table->unsignedBigInteger('id_dosen');
            $table->string('nama_kegiatan');
            $table->decimal('sks_terhitung');
            $table->string('asesor1_frk')->nullable();
            $table->string('asesor2_frk')->nullable();
            $table->string('asesor1_fed')->nullable();
            $table->string('asesor2_fed')->nullable();
            $table->string('lampiran')->nullable();
            $table->timestamps();

            $table->foreign('id_dosen')->references('id_dosen')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('rencana');
    }
};
