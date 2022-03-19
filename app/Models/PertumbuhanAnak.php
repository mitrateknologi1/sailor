<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PertumbuhanAnak extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'pertumbuhan_anak';
    protected $guarded = ['id'];


    public function tumbuhKembangAnak()
    {
        return $this->belongsTo(TumbuhKembangAnak::class);
    }
    
}
