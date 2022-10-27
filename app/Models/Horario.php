<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo', 'modalidad',
        'periodo', 'hora_inicio', 'hora_fin', 'fecha_inicio', 'fecha_fin', 'dia_de_cobro', 'estado',
        'aula_id', 'professor_id', 'asignatura_id'
    ];
    // relación de 1 a 1 con tabla Aula
    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }
    // relación de 1 a 1 con tabla Profesor
    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }
    // relación de 1 a 1 con tabla Asignatura
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }
    // relación de muchos a mucho con tabla Alumno
    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class);
    }
    // relación de 1 a muchos polimorfica con tabla Material
    public function materials()
    {
        return $this->morphMany(Material::class, 'materialable');
    }
}
