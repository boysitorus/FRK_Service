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
        Schema::create('detail_penelitian', function (Blueprint $table) {
            $table->unsignedBigInteger('id_rencana');
            $table->integer('jenis_pengerjaan')->nullable();
            $table->integer('posisi')->nullable();
            $table->integer('jumlah_anggota')->nullable();
            $table->integer('status_tahapan')->nullable();
            $table->integer('lingkup_wilayah')->nullable();
            $table->integer('peran')->nullable();
            $table->integer('lingkup_penerbit')->nullable();
            $table->integer('jumlah_dosen')->nullable();
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
        Schema::dropIfExists('detail_penelitian');
    }
};
