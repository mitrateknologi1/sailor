<?php

namespace App\Models;

use App\Traits\TraitUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anc extends Model
{
    use HasFactory;
    use TraitUuid;
    protected $table = 'anc';
    protected $fillable = [
        "anggota_keluarga_id",
        "bidan_id",
        "pemeriksaan_ke",
        "kategori_badan",
        "kategori_tekanan_darah",
        "kategori_lengan_atas",
        "kategori_denyut_jantung",
        "kategori_hemoglobin_darah",
        "vaksin_tetanus_sebelum_hamil",
        "vaksin_tetanus_sesudah_hamil",
        "minum_tablet",
        "konseling",
        "posisi_janin",
        "is_valid",
        "tanggal_validasi",
        "alasan_ditolak",
    ];

    public function anggotaKeluarga()
    {
        return $this->belongsTo(AnggotaKeluarga::class)->withTrashed();
    }

    public function bidan()
    {
        return $this->belongsTo(Bidan::class);
    }

    public function sesuaiLokasiTugas($lokasiTugas)
    {
        return $this->hasMany(AnggotaKeluarga::class)->whereIn('desa_kelurahan_id', $lokasiTugas);
    }

    public function pemeriksaanAnc()
    {
        return $this->belongsTo(PemeriksaanAnc::class, 'id', 'anc_id');
    }
}
