<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'estado',
        'fecha_asistencia',
        'alumno_horario_id',
    ];
    // relación de 1 a 1 con tabla AlumnoHorario
    public function AlumnoHorario()
    {
        return $this->belongsTo(AlumnoHorario::class);
    }
}
