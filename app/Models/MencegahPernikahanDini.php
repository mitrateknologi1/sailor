<?php

namespace App\Models;

use App\Traits\TraitUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MencegahPernikahanDini extends Model
{
    use HasFactory;
    use TraitUuid;
    protected $table = 'mencegah_pernikahan_dini';

    public function randaKabilasa()
    {
        return $this->belongsTo(RandaKabilasa::class);
    }
}
