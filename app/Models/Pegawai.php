<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{

    protected $table = 'pegawai';


    protected $fillable = [
        'nama_lengkap',
        'jabatan',
        'tim_id'
    ];

    public function tim() {
        return $this->belongsTo(Tim::class);
    }
}
