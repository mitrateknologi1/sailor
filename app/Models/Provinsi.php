<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provinsi extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'provinsi';

    public function kabupatenKota()
    {
        return $this->hasMany(KabupatenKota::class, 'provinsi_id');
    }

    public function kartuKeluarga()
    {
        return $this->hasMany(KartuKeluarga::class, 'provinsi_id');
    }

    public function wilayahDomisili()
    {
        return $this->hasMany(WilayahDomisili::class, 'provinsi_id');
    }
}
