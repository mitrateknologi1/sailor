<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StuntingAnak extends Model
{
    use HasFactory;
    protected $table = 'stunting_anak';

    public function anggotaKeluarga()
    {
        return $this->belongsTo(AnggotaKeluarga::class);
    }
}
