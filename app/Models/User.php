<?php

namespace App\Models;

use App\Traits\TraitUuid;
use App\Models\Admin;
use App\Models\Bidan;
use App\Models\Penyuluh;
use App\Models\LokasiTugas;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, TraitUuid, Searchable;

    protected $guarded = ['id'];
    protected $fillable = [
        "nomor_hp",
        "nik",
        "is_remaja",
        "status",
        "password",
        "role"
    ];

    public function profil()
    {
        if (Auth::user()->role == 'bidan') {
            return $this->hasOne(Bidan::class, 'user_id', 'id');
        } else if (Auth::user()->role == 'penyuluh') {
            return $this->hasOne(Penyuluh::class, 'user_id', 'id');
        } else if (Auth::user()->role == 'admin') {
            return $this->hasOne(Admin::class, 'user_id', 'id');
        } else if (Auth::user()->role == 'keluarga') {
            return $this->hasOne(AnggotaKeluarga::class, 'user_id', 'id');
        }
    }

    public function scopeProfilAkun($query, $role)
    {
        if ($role == 'bidan') {
            return $query->hasOne(Bidan::class, 'user_id', 'id');
        } else if ($role == 'penyuluh') {
            return $query->hasOne(Penyuluh::class, 'user_id', 'id');
        } else if ($role == 'admin') {
            return $query->hasOne(Admin::class, 'user_id', 'id');
        } else if ($role == 'keluarga') {
            return $query->hasOne(AnggotaKeluarga::class, 'user_id', 'id');
        }
    }


    public function keluarga()
    {
        return $this->hasOne(AnggotaKeluarga::class, 'user_id', 'id');
    }

    public function bidan()
    {
        return $this->hasOne(Bidan::class, 'user_id', 'id')->withTrashed();
    }

    public function penyuluh()
    {
        return $this->hasOne(Penyuluh::class, 'user_id', 'id');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id', 'id');
    }

    public function kepalaKeluarga()
    {
        return $this->hasOne(AnggotaKeluarga::class, 'user_id', 'id')->withTrashed();
    }

    public function remaja()
    {
        return $this->hasOne(AnggotaKeluarga::class, 'user_id', 'id');
    }

    // lokasi tugas if role != admin
    public function lokasiTugas()
    {
        $profil = $this->profil;
    }

    public function pemberitahuan()
    {
        return $this->hasMany(Pemberitahuan::class)->latest();
    }

    // public function lokasiTugas(){
    //     if(Auth::user()->role == 'bidan'){
    //         return $this->hasMany(LokasiTugas::class, 'profil_id', 'id');
    //     }
    // }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function toSearchableArray()
    {
        return [
            "nomor_hp" => $this->nomor_hp,
            "nik" => $this->nik,
        ];
    }
}
