<?php

namespace App\Models;

use App\Models\KartuKeluarga;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnggotaKeluarga extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'anggota_keluarga';
    protected $guarded = ['id'];

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class);
    }
}
