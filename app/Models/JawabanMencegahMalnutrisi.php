<?php

namespace App\Models;

use App\Traits\TraitUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanMencegahMalnutrisi extends Model
{
    use HasFactory;
    use TraitUuid;
    protected $guarded = ['id'];
    protected $table = 'jawaban_mencegah_malnutrisi';
    protected $fillable = [
        "mencegah_malnutrisi_id",
        "soal_id",
        "jawaban",
    ];
}
