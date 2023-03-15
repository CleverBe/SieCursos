<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'cedula', 'profile',
        'status', 'password', 'image',
    ];
    // relación de 1 a 1 con tabla Alumno
    public function alumno()
    {
        return $this->hasOne(Alumno::class);
    }
    // relación de 1 a 1 con tabla Professor
    public function professor()
    {
        return $this->hasOne(Professor::class);
    }
    // relación de 1 a 1 con tabla Admin
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
    // relación de 1 a muchos con la tabla Material
    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function getImageAttribute($image)
    {
        if ($image == null) {
            return 'noimage.png';
        }
        if (file_exists('storage/usuarios/' . $image)){
            return $image;
        }
        else {
            return 'noimage.png';
        }
    }

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
}
