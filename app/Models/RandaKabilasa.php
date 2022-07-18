<?php

namespace App\Models;

use App\Traits\TraitUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RandaKabilasa extends Model
{
    use HasFactory;
    use TraitUuid;
    protected $table = 'randa_kabilasa';
    protected $fillable = [
        "anggota_keluarga_id",
        "bidan_id",
        "is_mencegah_malnutrisi",
        "is_mencegah_pernikahan_dini",
        "is_meningkatkan_life_skill",
        "kategori_hb",
        "kategori_lingkar_lengan_atas",
        "kategori_imt",
        "kategori_mencegah_malnutrisi",
        "kategori_meningkatkan_life_skill",
        "kategori_mencegah_pernikahan_dini",
        "is_valid_mencegah_malnutrisi",
        "is_valid_mencegah_pernikahan_dini",
        "is_valid_meningkatkan_life_skill",
        "tanggal_validasi",
        "alasan_ditolak_mencegah_malnutrisi",
        "alasan_ditolak_mencegah_pernikahan_dini",
        "alasan_ditolak_meningkatkan_life_skill",
    ];

    public function anggotaKeluarga()
    {
        return $this->belongsTo(AnggotaKeluarga::class)
            ->withTrashed();
    }

    public function bidan()
    {
        return $this->belongsTo(Bidan::class)
            ->withTrashed();
    }

    public function mencegahMalnutrisi()
    {
        return $this->belongsTo(MencegahMalnutrisi::class, 'id', 'randa_kabilasa_id');
    }

    public function mencegahPernikahanDini()
    {
        return $this->belongsTo(MencegahPernikahanDini::class, 'id', 'randa_kabilasa_id');
    }
}
