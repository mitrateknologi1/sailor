<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kecamatan extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'kecamatan';
    protected $appends = ['koordinatPolygon'];

    public function kabupatenKota()
    {
        return $this->belongsTo(KabupatenKota::class, 'kabupaten_kota_id');
    }

    public function desaKelurahan()
    {
        return $this->hasMany(DesaKelurahan::class, 'kecamatan_id');
    }

    public function getKoordinatPolygonAttribute()
    {
        return json_decode($this->polygon);
    }

    public function kartuKeluarga()
    {
        return $this->hasMany(KartuKeluarga::class, 'kabupaten_kota_id');
    }

    public function wilayahDomisili()
    {
        return $this->hasMany(WilayahDomisili::class, 'kecamatan_id');
    }
}
