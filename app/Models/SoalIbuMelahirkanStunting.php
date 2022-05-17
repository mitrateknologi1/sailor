<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SoalIbuMelahirkanStunting extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'soal_ibu_melahirkan_stunting';
}
