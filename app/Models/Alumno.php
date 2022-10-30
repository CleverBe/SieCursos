<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'telefono',
        'fecha_nacimiento',
        'tutor',
        'telef_tutor',
        'user_id'
    ];

    public function horarios()
    {
        return $this->belongsToMany(Horario::class)
            ->using(AlumnoHorario::class)
            ->withPivot(
                'id',
                'fecha_inscripcion',
                'nota',
                'estado',
                'horario_id',
                'alumno_id',
            );
    }

    public function alumnohorario()
    {
        return $this->hasOne(AlumnoHorario::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
