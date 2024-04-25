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
        Schema::create('generate_tanggal', function (Blueprint $table) {
            $table->id(); // Kolom id secara default akan menjadi primary key auto_increment
            $table->string('tipe');
            $table->date('tgl_awal_pengisian');
            $table->date('tgl_akhir_pengisian');
            $table->date('periode_awal_approve_assesor_1');
            $table->date('periode_akhir_approve_assesor_1');
            $table->date('periode_awal_approve_assesor_2');
            $table->date('periode_akhir_approve_assesor_2');
            $table->string('tahun_ajaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generate_tanggal');
    }
};
