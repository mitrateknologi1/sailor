<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeteksiIbuMelahirkanStunting extends Model
{
    use HasFactory;
    protected $table = 'deteksi_ibu_melahirkan_stunting';

    public function anggotaKeluarga()
    {
        return $this->belongsTo(AnggotaKeluarga::class);
    }

    public function bidan()
    {
        return $this->belongsTo(Bidan::class);
    }

    public function sesuaiLokasiTugas($lokasiTugas)
    {
        return $this->hasMany(AnggotaKeluarga::class)->whereIn('desa_kelurahan_id', $lokasiTugas);
    }
}
