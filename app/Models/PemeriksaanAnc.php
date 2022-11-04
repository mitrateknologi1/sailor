<?php

namespace App\Models;

use App\Traits\TraitUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanAnc extends Model
{
    use HasFactory;
    use TraitUuid;
    protected $guarded = ['id'];

    protected $table = 'pemeriksaan_anc';
}
