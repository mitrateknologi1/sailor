<?php

namespace App\Models;

use App\Traits\TraitUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanMeningkatkanLifeSkill extends Model
{
    use HasFactory;
    use TraitUuid;
    protected $table = 'jawaban_meningkatkan_life_skill';
}
