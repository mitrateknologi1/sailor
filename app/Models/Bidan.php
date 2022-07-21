<?php

namespace App\Models;

use App\Traits\TraitUuid;
use App\Models\User;
use App\Models\Agama;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\LokasiTugas;
use App\Models\DesaKelurahan;
use App\Models\KabupatenKota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Bidan extends Model
{
    use HasFactory;
    use TraitUuid;
    use SoftDeletes;
    use Searchable;
    protected $table = 'bidan';
    protected $guarded = ['id'];
    protected $fillable = [
        "user_id",
        "nik",
        "nama_lengkap",
        "jenis_kelamin",
        "tempat_lahir",
        "tanggal_lahir",
        "agama_id",
        "tujuh_angka_terakhir_str",
        "nomor_hp",
        "email",
        "alamat",
        "desa_kelurahan_id",
        "kecamatan_id",
        "kabupaten_kota_id",
        "provinsi_id",
        "foto_profil",
    ];

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

    public function toSearchableArray()
    {
        return [
            "user_id" => $this->user_id,
            "nik" => $this->nik,
            "nama_lengkap" => $this->nama_lengkap,
            "desa_kelurahan_id" => $this->desa_kelurahan_id,
            "kecamatan_id" => $this->kecamatan_id,
            "kabupaten_kota_id" => $this->kabupaten_kota_id,
            "provinsi_id" => $this->provinsi_id,
        ];
    }
}
