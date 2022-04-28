<?php

namespace App\Models;

use App\Traits\TraitUuid;
use App\Models\KartuKeluarga;
use App\Models\PertumbuhanAnak;
use App\Models\WilayahDomisili;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnggotaKeluarga extends Model
{
    use HasFactory;
    use TraitUuid;
    use SoftDeletes;
    protected $table = 'anggota_keluarga';
    protected $guarded = ['id'];

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

    public function user(){
        return $this->belongsTo(User::class);
    }
      
    public function scopeOfDataSesuaiKecamatan($query, $kecamatan)
    {
        $query->whereHas('wilayahDomisili', function ($query) use ($kecamatan) {
            return $query->where('kecamatan_id', $kecamatan);
        });
    }

    public function scopeOfDataSesuaiDesa($query, $desa)
    {
        $query->whereHas('wilayahDomisili', function ($query) use ($desa) {
            return $query->where('desa_kelurahan_id', $desa);
        });
    }

    public function scopeValid($query)
    {
        $query->where('is_valid', 1);
    }
}
