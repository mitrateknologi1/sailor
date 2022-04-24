<?php

namespace App\Models;

use App\Traits\TraitUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerkembanganAnak extends Model
{
    use HasFactory;
    use TraitUuid;
    use SoftDeletes;
    protected $table = 'perkembangan_anak';
    protected $guarded = ['id'];

    public function anggotaKeluarga(){
        return $this->belongsTo(AnggotaKeluarga::class)
        ->withTrashed();
    }

    public function bidan(){
        return $this->belongsTo(Bidan::class)
        ->withTrashed();
    }

    public function sesuaiLokasiTugas($lokasiTugas){
        return $this->hasMany(AnggotaKeluarga::class)->whereIn('desa_kelurahan_id', $lokasiTugas); 
    }

    // active
    public function scopeOfValid($query, $status){
        return $query->where('is_valid', $status);
    }
}
