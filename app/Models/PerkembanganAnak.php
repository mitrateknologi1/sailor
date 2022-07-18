<?php

namespace App\Models;

use App\Traits\TraitUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerkembanganAnak extends Model
{
    use TraitUuid;
    use HasFactory;
    protected $table = 'perkembangan_anak';
    protected $guarded = ['id'];
    protected $fillable = [
        "anggota_keluarga_id",
        "bidan_id",
        "motorik_kasar",
        "motorik_halus",
        "is_valid",
        "tanggal_validasi",
        "alasan_ditolak",
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

    public function sesuaiLokasiTugas($lokasiTugas)
    {
        return $this->hasMany(AnggotaKeluarga::class)->whereIn('desa_kelurahan_id', $lokasiTugas);
    }

    public function scopeValid($query)
    {
        $query->where('is_valid', 1);
    }
}
