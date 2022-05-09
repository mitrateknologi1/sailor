<?php

namespace App\Models;

use App\Traits\TraitUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StuntingAnak extends Model
{
    use HasFactory;
    use TraitUuid;
    protected $table = 'stunting_anak';

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
