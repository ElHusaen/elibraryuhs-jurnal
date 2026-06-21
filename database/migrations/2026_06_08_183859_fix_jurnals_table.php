<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::table('jurnals', function (Blueprint $table) {

            $table->string('judul', 255)->change();

            $table->string('file_pdf', 255)->change();

        });
    }

    public function down()
    {
        Schema::table('jurnals', function (Blueprint $table) {

            $table->string('judul', 255)->change();

            $table->string('file_pdf', 255)->change();

        });
    }
};