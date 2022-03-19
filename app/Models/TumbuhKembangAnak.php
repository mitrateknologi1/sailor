<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TumbuhKembangAnak extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'tumbuh_kembang_anak';
    protected $guarded = ['id'];

    public function pertumbuhanAnak(){
        return $this->hasOne(PertumbuhanAnak::class);
    }

    public function anggotaKeluarga(){
        return $this->belongsTo(AnggotaKeluarga::class);
    }
}
