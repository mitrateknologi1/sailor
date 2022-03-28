<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class WilayahDomisili extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'wilayah_domisili';
    protected $guarded = ['id'];

    public function anggotaKeluarga()
    {
        return $this->belongsTo(AnggotaKeluarga::class);
    }

    public function desaKelurahan()
    {
        return $this->belongsTo(DesaKelurahan::class);
    }


}
