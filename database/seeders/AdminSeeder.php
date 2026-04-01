<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create default teams
        $tim_ids = [];
        $tims = [
            ['nama_tim' => 'Tim IT', 'ketua_tim' => 'Kepala IT'],
            ['nama_tim' => 'Tim HR', 'ketua_tim' => 'Kepala HR'],
            ['nama_tim' => 'Tim Operasional', 'ketua_tim' => 'Kepala Operasional'],
        ];

        foreach ($tims as $tim) {
            $tim_ids[] = DB::table('tim')->insertGetId([
                'nama_tim' => $tim['nama_tim'],
                'ketua_tim' => $tim['ketua_tim'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create admin user (force change password on first login)
        DB::table('users')->insert([
            'username' => 'admin',
            'nama_lengkap' => 'Administrator',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status' => 'wajib_ganti_password',
            'wajib_ganti_password' => 1,
            'tim_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create default operator account (for testing)
        DB::table('users')->insert([
            'username' => 'operator',
            'nama_lengkap' => 'Operator Default',
            'password' => Hash::make('operator123'),
            'role' => 'operator',
            'status' => 'wajib_ganti_password',
            'wajib_ganti_password' => 1,
            'tim_id' => $tim_ids[0] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

