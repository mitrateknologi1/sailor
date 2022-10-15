<?php

namespace App\Models;

use App\Traits\TraitUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JawabanDeteksiIbuMelahirkanStunting extends Model
{
    use HasFactory;
    use TraitUuid;

    protected $fillable = [
        "deteksi_ibu_melahirkan_stunting_id",
    ];

    // use SoftDeletes;
    protected $table = 'jawaban_deteksi_ibu_melahirkan_stunting';

    public function SoalIbuMelahirkanStunting()
    {
        return $this->belongsTo(SoalIbuMelahirkanStunting::class, 'soal_id')->withTrashed();
    }
}
