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
        Schema::create('jurnals', function (Blueprint $table) {
        $table->string('id_jurnal', 50)->primary();

        $table->string('penulis', 20);
        $table->string('id_kategori', 20);

        $table->string('judul', 255)->nullable();
        $table->text('abstrak')->nullable();
        $table->string('file_pdf', 255)->nullable();

        $table->date('tgl_upload');

        $table->enum('status', [
            'review',
            'publish',
            'ditolak'
        ]);

        $table->timestamps();
        $table->softDeletes();

    });

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnals');
    }
};
