<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AlumnoHorario extends Pivot
{
    use HasFactory;

    public $incrementing = true;

    protected $fillable = [
        'fecha_inscripcion', 'primera_nota', 'segunda_nota', 'nota_final',
        'estado', 'alumno_id', 'horario_id'
    ];
    // relación de 1 a 1 con tabla Horario
    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }
    // relación de 1 a 1 con tabla Alumno
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
    // relacion de 1 a muchos con la tabla pagos
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
