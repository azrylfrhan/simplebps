<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. Jika kolom role sudah ada, kita ubah tipenya ke String agar tidak error ENUM
            if (Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('operator')->change();
            } else {
                // Jika belum ada, kita buat baru sebagai String
                $table->string('role')->default('operator')->after('password');
            }

            // 2. Tambah kolom status jika belum ada
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('aktif')->after('role');
            }

            // 3. Tambah kolom wajib_ganti_password jika belum ada
            if (!Schema::hasColumn('users', 'wajib_ganti_password')) {
                $table->boolean('wajib_ganti_password')->default(true)->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status', 'wajib_ganti_password']);
        });
    }
};
