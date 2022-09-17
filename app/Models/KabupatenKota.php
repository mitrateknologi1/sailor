<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KabupatenKota extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'kabupaten_kota';

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class, 'kabupaten_kota_id');
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function kartuKeluarga()
    {
        return $this->hasMany(KartuKeluarga::class, 'kabupaten_kota_id');
    }

    public function wilayahDomisili()
    {
        return $this->hasMany(WilayahDomisili::class, 'kabupaten_kota_id');
    }
}
