<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'modulo', 'monto', 'fecha_pago', 'fecha_limite',
        'a_pagar', 'mes_pago', 'comprobante',
        'observaciones', 'alumno_horario_id'
    ];
    // relación de 1 a 1 con tabla AlumnoHorario
    public function alumno_horario()
    {
        return $this->belongsTo(AlumnoHorario::class);
    }
}

