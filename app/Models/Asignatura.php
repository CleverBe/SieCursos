<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'descripcion', 'estado', 'image', 'area_id',
    ];
    // relación de 1 a 1 con tabla Area
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    // relación de 1 a muchos con tabla Horario
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
    // relación de 1 a muchos polimorfica con tabla Material
    public function materials()
    {
        return $this->morphMany(Material::class, 'materialable');
    }

    public function getImagenAttribute()
    {
        if ($this->image == null) {
            return 'noimage.jpg';
        }
        if (file_exists('storage/asignaturas/' . $this->image))
            return $this->image;
        else {
            return 'noimage.jpg';
        }
    }
}
