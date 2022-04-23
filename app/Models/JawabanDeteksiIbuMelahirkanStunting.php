<?php

namespace App\Models;

use App\Traits\TraitUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanDeteksiIbuMelahirkanStunting extends Model
{
    use HasFactory;
    use TraitUuid;
    protected $table = 'jawaban_deteksi_ibu_melahirkan_stunting';
}
