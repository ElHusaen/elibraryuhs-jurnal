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
        Schema::create('mahasiswas  ', function (Blueprint $table) {
            $table->string('penulis', 72)->primary();
            $table->string('nama_lengkap', 72);
            $table->string('email', 72)->unique();
            $table->string('password', 72);
            $table->string('prodi', 72);
            $table->string('fakultas', 72);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
