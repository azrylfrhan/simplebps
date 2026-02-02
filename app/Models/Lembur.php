<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    protected $table = 'lembur';
    protected $fillable = ['pegawai_id', 'tanggal', 'jam_mulai', 'jam_selesai', 'nomor_spkl', 'maksud_lembur', 'dibuat_oleh'];

    public function pegawai() {
        return $this->belongsTo(Pegawai::class);
    }

    public function pembuat() {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
