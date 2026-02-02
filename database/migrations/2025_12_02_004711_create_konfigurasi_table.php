<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konfigurasi', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert data default
        DB::table('konfigurasi')->insert([
            ['key' => 'nama_kpa', 'value' => 'Aidil Adha, SE.,ME'],
            ['key' => 'jabatan_kpa', 'value' => 'Kuasa Pengguna Anggaran']
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('konfigurasi');
    }
};
