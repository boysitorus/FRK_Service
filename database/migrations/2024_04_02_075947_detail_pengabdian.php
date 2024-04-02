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
        Schema::create('detail_pengabdian', function (Blueprint $table) {
            $table->unsignedBigInteger('id_rencana');
            $table->integer('jumlah_durasi')->nullable();
            $table->string('posisi')->nullable();
            $table->string('jenis_terbit')->nullable();
            $table->string('status_tahapan')->nullable();
            $table->string('jenis_pengerjaan')->nullable();
            $table->string('peran')->nullable();
            $table->integer('jumlah_anggota')->nullable();
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
        Schema::dropIfExists('detail_pengabdian');
    }
};
