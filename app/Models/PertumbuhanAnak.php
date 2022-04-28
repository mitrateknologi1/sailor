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

    public function anggotaKeluarga(){
        return $this->belongsTo(AnggotaKeluarga::class)
        ->withTrashed();
    }

    public function bidan(){
        return $this->belongsTo(Bidan::class)
        ->withTrashed()
        ;
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
