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
        Schema::create('laporan-harian', function (Blueprint $table) {
            $table->id();
            $table->string('status',20);
            $table->string('isi',75);
            $table->date('tanggal')->format('d/m/Y');
            $table->string('dokumen',50);
            $table->string('id domen',50);
            $table->string('npm',50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan-harian');
    }
};
