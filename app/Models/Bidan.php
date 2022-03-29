<?php

namespace App\Models;

use App\Models\User;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\LokasiTugas;
use App\Models\DesaKelurahan;
use App\Models\KabupatenKota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bidan extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'bidan';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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

    public function lokasiTugas()
    {
        return $this->hasMany(LokasiTugas::class, 'profil_id', 'id')->where('jenis_profil', 'bidan');
    }

    // public function scopeListLokasiTugas($query){
    //     // get nama desa kelurahan to pluck
    //     $lokasiTugas = $query->lokasiTugas;

    //     return $lokasiTugas;

    // }

    public function scopeActive($query)
    {
        $query->whereHas('user', function ($query) {
            $query->where('status', 1);
        });
    }


}
