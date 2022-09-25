<?php

namespace App\Models;

use App\Traits\TraitUuid;
use App\Models\KartuKeluarga;
use App\Models\PertumbuhanAnak;
use App\Models\WilayahDomisili;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class AnggotaKeluarga extends Model
{
    use HasFactory;
    use TraitUuid;
    use SoftDeletes;
    use Searchable;
    protected $table = 'anggota_keluarga';
    protected $guarded = ['id'];
    protected $appends = ['umur'];
    protected $fillable = [
        "bidan_id",
        "kartu_keluarga_id",
        "user_id",
        "nama_lengkap",
        "nik",
        "jenis_kelamin",
        "tempat_lahir",
        "tanggal_lahir",
        "agama_id",
        "pendidikan_id",
        "jenis_pekerjaan_id",
        "golongan_darah_id",
        "status_perkawinan_id",
        "tanggal_perkawinan",
        "status_hubungan_dalam_keluarga_id",
        "kewarganegaraan",
        "no_paspor",
        "no_kitap",
        "nama_ayah",
        "nama_ibu",
        "foto_profil",
        "is_valid",
        "tanggal_validasi",
        "alasan_ditolak",
    ];

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class);
    }

    public function bidan()
    {
        return $this->belongsTo(Bidan::class);
    }

    public function pertumbuhanAnak()
    {
        return $this->hasMany(PertumbuhanAnak::class);
    }

    public function perkembanganAnak()
    {
        return $this->hasMany(PerkembanganAnak::class);
    }

    public function randaKabilasa()
    {
        return $this->hasMany(RandaKabilasa::class);
    }

    public function stuntingAnak()
    {
        return $this->hasMany(StuntingAnak::class);
    }

    public function ibuMelahirkanStunting()
    {
        return $this->hasMany(DeteksiIbuMelahirkanStunting::class);
    }

    public function perkiraanMelahirkan()
    {
        return $this->hasMany(PerkiraanMelahirkan::class);
    }

    public function deteksiDini()
    {
        return $this->hasMany(DeteksiDini::class);
    }

    public function anc()
    {
        return $this->hasMany(Anc::class);
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

    public function agama()
    {
        return $this->belongsTo(Agama::class);
    }

    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class);
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'jenis_pekerjaan_id');
    }

    public function golonganDarah()
    {
        return $this->belongsTo(GolonganDarah::class);
    }

    public function statusPerkawinan()
    {
        return $this->belongsTo(StatusPerkawinan::class);
    }

    public function getBidan($id)
    {
        $anggotaKeluarga = AnggotaKeluarga::where('id', $id)
            ->withTrashed()->first();
        $lokasiDomisili = $anggotaKeluarga->wilayahDomisili
            ->desa_kelurahan_id;
        $bidan = Bidan::with('lokasiTugas')
            ->whereHas('lokasiTugas', function ($query) use ($lokasiDomisili) {
                return $query->where('desa_kelurahan_id', $lokasiDomisili);
            })->get();
        return $bidan;
    }

    public function statusHubunganDalamKeluarga()
    {
        return $this->belongsTo(StatusHubungan::class, 'status_hubungan_dalam_keluarga_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOfDataSesuaiKecamatan($query, $kecamatan)
    {
        $query->whereHas('wilayahDomisili', function ($query) use ($kecamatan) {
            return $query->where('kecamatan_id', "$kecamatan");
        });
    }

    public function scopeOfDataSesuaiDesa($query, $desa)
    {
        $query->whereHas('wilayahDomisili', function ($query) use ($desa) {
            return $query->where('desa_kelurahan_id', "$desa");
        });
    }

    public function scopeValid($query)
    {
        $query->where('is_valid', 1);
    }

    public function getUmurAttribute()
    {
        return Carbon::parse($this->attributes['tanggal_lahir'])->age;
    }

    public function toSearchableArray()
    {
        return [
            "bidan_id" => $this->bidan_id,
            "kartu_keluarga_id" => $this->kartu_keluarga_id,
            "user_id" => $this->user_id,
            "nama_lengkap" => $this->nama_lengkap,
            "nik" => $this->nik,
            "nama_ayah" => $this->nama_ayah,
            "nama_ibu" => $this->nama_ibu,
        ];
    }
}
