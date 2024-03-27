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
        Schema::create('detail_penunjang', function (Blueprint $table) {
            $table->unsignedBigInteger('id_rencana');
            $table->string('jumlah_mahasiswa')->nullable();
            $table->string('posisi')->nullable();
            $table->string('jenis_jabatan_struktural')->nullable();
            $table->string('jenis_jabatan_nonstruktural')->nullable();
            $table->string('jenis_tingkatan')->nullable();
            $table->integer('jumlah_prodi')->nullable();
            $table->timestamps();

            // Define foreign key constraint with ON DELETE CASCADE
            $table->primary('id_rencana');
            $table->foreign('id_rencana')
                ->references('id_rencana')->on('rencana')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
