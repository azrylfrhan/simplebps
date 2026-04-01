<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username', 'nama_lengkap', 'password', 'role', 'tim_id', 'status', 'wajib_ganti_password'
    ];

    // Helper untuk mengecek hak akses di Blade/Controller
    public function isAdmin() { return $this->role === 'admin'; }
    public function isKabag() { return $this->role === 'kabag'; }
    public function isOperator() { return $this->role === 'operator'; }

    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }
}
