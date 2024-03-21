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
        Schema::create('detail_pendidikan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_rencana');
            $table->integer('sks_matakuliah')->nullable();
            $table->integer('jumlah_pertemuan')->nullable();
            $table->integer('jumlah_evaluasi')->nullable();
            $table->integer('jumlah_kelas')->nullable();
            $table->integer('jumlah_mahasiswa')->nullable();
            $table->integer('jumlah_kelompok')->nullable();
            $table->integer('jumlah_dosen')->nullable();
            $table->integer('jumlah_sap')->nullable();
            $table->integer('jumlah_pengampu')->nullable();
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
        Schema::dropIfExists('detail_pendidikan');
    }
};
