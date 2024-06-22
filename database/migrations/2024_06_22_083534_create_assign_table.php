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
        Schema::create('assign', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing ID
            $table->unsignedBigInteger('id_pegawai'); // Assuming id_pegawai is a foreign key to another table
            $table->enum('tipe_asesor', [1, 2, 3]); // Enum type for 1 or 2
            $table->string('id_tanggal_frk');
            $table->string('id_tanggal_fed');
            $table->string('program_studi'); // Assuming program_studi is a string
            $table->string('fakultas'); // Assuming fakultas is a string
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign');
    }
};
