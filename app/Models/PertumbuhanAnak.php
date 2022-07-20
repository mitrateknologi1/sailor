<?php

namespace App\Models;

use App\Traits\TraitUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertumbuhanAnak extends Model
{
    use HasFactory;
    use TraitUuid;
    protected $table = 'pertumbuhan_anak';
    protected $guarded = ['id'];
    protected $fillable = [
        "anggota_keluarga_id",
        "bidan_id",
        "berat_badan",
        "zscore",
        "hasil",
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
