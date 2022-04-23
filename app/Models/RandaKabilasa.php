<?php

namespace App\Models;

use App\Traits\TraitUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RandaKabilasa extends Model
{
    use HasFactory;
    use TraitUuid;
    protected $table = 'randa_kabilasa';

    public function anggotaKeluarga()
    {
        return $this->belongsTo(AnggotaKeluarga::class)
            ->withTrashed();
    }

    public function bidan()
    {
        return $this->belongsTo(Bidan::class)
            ->withTrashed();
    }

    public function mencegahMalnutrisi()
    {
        return $this->belongsTo(MencegahMalnutrisi::class, 'id', 'randa_kabilasa_id');
    }

    public function mencegahPernikahanDini()
    {
        return $this->belongsTo(MencegahPernikahanDini::class, 'id', 'randa_kabilasa_id');
    }
}
