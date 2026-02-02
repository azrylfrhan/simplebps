<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    protected $table = 'tim';
    protected $fillable = ['nama_tim', 'ketua_tim'];

    public function pegawai() {
        return $this->hasMany(Pegawai::class);
    }
}
