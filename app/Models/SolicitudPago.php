<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudPago extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_solicitante', 'telefono_solicitante', 'comprobante', 'fecha_transferencia',
        'comentarios', 'estado', 'visto_Admin', 'visto_Student', 'pago_id'
    ];
    // relación de 1 a 1 con tabla Pago
    public function pago()
    {
        return $this->belongsTo(Pago::class);
    }
}
