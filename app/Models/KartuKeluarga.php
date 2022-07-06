<?php

namespace App\Models;

use App\Traits\TraitUuid;
use App\Models\Bidan;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\DesaKelurahan;
use App\Models\KabupatenKota;
use App\Models\AnggotaKeluarga;
use App\Models\WilayahDomisili;
use App\Models\WilayahDomisiliKK;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class KartuKeluarga extends Model
{
    use HasFactory;
    use TraitUuid;
    use SoftDeletes;
    protected $table = 'kartu_keluarga';
    protected $guarded = ['id'];
    protected $fillable = [
        "bidan_id",
        "nomor_kk",
        "nama_kepala_keluarga",
        "alamat",
        "rt",
        "rw",
        "kode_pos",
        "desa_kelurahan_id",
        "kecamatan_id",
        "kabupaten_kota_id",
        "provinsi_id",
        "file_kk",
        "is_valid",
        "tanggal_validasi",
        "alasan_ditolak",
    ];


    public function anggotaKeluarga()
    {
        return $this->hasMany(AnggotaKeluarga::class);
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

    public function kepalaKeluarga()
    {
        return $this->hasOne(AnggotaKeluarga::class)->where('status_hubungan_dalam_keluarga_id', 1);
    }

    public function bidan()
    {
        return $this->belongsTo(Bidan::class)->withTrashed();
    }

    public function wilayahDomisili()
    {
        return $this->hasOne(WilayahDomisili::class)
            ->withTrashed();
    }

    public function scopeOfDataSesuaiLokasiTugas($query, $lokasiTugas)
    {
        $query->whereHas('wilayahDomisili', function ($query) use ($lokasiTugas) {
            return $query->whereIn('desa_kelurahan_id', $lokasiTugas);
        });
    }

    public function getBidan($id)
    {
        $kepalaKeluarga = KartuKeluarga::with('kepalaKeluarga')
            ->where('id', $id)
            ->first();
        $lokasiDomisili = $kepalaKeluarga->kepalaKeluarga->wilayahDomisili->desa_kelurahan_id;
        $bidan = Bidan::with('lokasiTugas')
            ->whereHas('lokasiTugas', function ($query) use ($lokasiDomisili) {
                return $query->where('desa_kelurahan_id', $lokasiDomisili);
            })->get();
        return $bidan;
    }

    public function statusKeluarga($status)
    {
        return $this->hasMany(AnggotaKeluarga::class)->where('status_hubungan_dalam_keluarga_id', 'like', '%' . $status . '%');
    }

    public function scopeValid($query)
    {
        $query->where('is_valid', 1);
    }
}
