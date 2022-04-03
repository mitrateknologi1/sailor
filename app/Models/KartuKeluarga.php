<?php

namespace App\Models;

use App\Models\AnggotaKeluarga;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class KartuKeluarga extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'kartu_keluarga';
    protected $guarded = ['id'];


    public function anggotaKeluarga()
    {
        return $this->hasMany(AnggotaKeluarga::class);
    }

    public function statusKeluarga($status)
    {
        // if($method == 'POST'){
            return $this->hasMany(AnggotaKeluarga::class)->where('status_hubungan_dalam_keluarga', 'like', '%' . $status . '%');
        // } 
        // else{
        //     return $this->hasMany(AnggotaKeluarga::class)->where('status_hubungan_dalam_keluarga', 'like', '%' . $status . '%')->withTrashed();

        // }
    }
}
