<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanLembur extends Model
{
    protected $table = 'pengajuan_lembur';

    protected $fillable = [
        'pegawai_id',
        'tanggal',
        'lama_jam_taksiran',
        'maksud_lembur',
        'status',
        'dibuat_oleh',
        'catatan_verifikator',
        'is_read_operator',
        'is_read_admin',
        'is_read_kabag',
];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
