<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Gunakan Anonymous Class (pola default Laravel terbaru) agar tidak bentrok nama class
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pengajuan_lembur', function (Blueprint $table) {
            $table->boolean('is_read_operator')->default(false)->after('status');
            $table->boolean('is_read_admin')->default(false)->after('is_read_operator');
            $table->boolean('is_read_kabag')->default(false)->after('is_read_admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_lembur', function (Blueprint $table) {
            $table->dropColumn(['is_read_operator', 'is_read_admin', 'is_read_kabag']);
        });
    }
};
