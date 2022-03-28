<?php

namespace App\Models;

use App\Models\Bidan;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\DesaKelurahan;
use App\Models\KabupatenKota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class LokasiTugas extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'lokasi_tugas';

    // public function profil()
    // {
    //     return $this->belongsTo(Bidan::class, 'profil_id', 'id');
    // }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function kabupatenKota()
    {
        return $this->belongsTo(KabupatenKota::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function desaKelurahan()
    {
        return $this->belongsTo(DesaKelurahan::class);
    }

    public function scopeOfLokasiTugas($query, $id)
    {
        return $query->where('profil_id', $id)
        ->where('jenis_profil', Auth::user()->role)
        ->get()->pluck('desa_kelurahan_id');
    }
    
}
