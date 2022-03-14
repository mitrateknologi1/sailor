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

    public function anggotaKeluarga()
    {
        return $this->hasMany(AnggotaKeluarga::class);
    }

    
}
