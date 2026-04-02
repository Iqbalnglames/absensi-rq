<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function izins()
    {
        return $this->hasMany(Izin::class);
    }

    public function mapel()
    {
        return $this->belongsToMany(Mapel::class, 'mapel_gurus');
    }

    public function jadwal_mengajar()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function jadwal_kerja()
    {
        return $this->hasMany(JamKerja::class);
    }

    public function kelas()
    {
        return $this->hasOne(Kelas::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }
}
