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


class Penyuluh extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'penyuluh';
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

    public function agama()
    {
        return $this->belongsTo(Agama::class);
    }

    public function lokasiTugas()
    {
        return $this->hasMany(LokasiTugas::class, 'profil_id', 'id')->where('jenis_profil', 'penyuluh');
    }


    public function scopeListLokasiTugas($query){
        // get nama desa kelurahan to pluck
        $lokasiTugas = $query->lokasiTugas;

        return $lokasiTugas;

    }

}
