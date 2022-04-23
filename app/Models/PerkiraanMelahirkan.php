<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerkiraanMelahirkan extends Model
{
    use HasFactory;
    protected $table = 'perkiraan_melahirkan';

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
}
