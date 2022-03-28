<?php

namespace App\Models;

use App\Models\KartuKeluarga;
use App\Models\PertumbuhanAnak;
use App\Models\WilayahDomisili;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function pertumbuhanAnak()
    {
        return $this->hasMany(PertumbuhanAnak::class);
    }
    
    public function wilayahDomisili()
    {
        return $this->hasOne(WilayahDomisili::class);
    }

    public function scopeOfDataSesuaiLokasiTugas($query, $lokasiTugas)
    {
        $query->whereHas('wilayahDomisili', function ($query) use ($lokasiTugas) {
            return $query->whereIn('desa_kelurahan_id', $lokasiTugas);
        });
    }
}
