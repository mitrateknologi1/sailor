<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemberitahuan extends Model
{
    use HasFactory;
    protected $table = 'pemberitahuan';
    protected $guarded = ['id'];
    protected $fillable = [
        'user_id',
        'fitur_id',
        'anggota_keluarga_id',
        'judul',
        'isi',
        'tentang',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function anggotaKeluarga()
    {
        return $this->belongsTo(AnggotaKeluarga::class)
            ->withTrashed();
    }
}
