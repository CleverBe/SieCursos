<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'nombre_archivo', 'comentario', 'materialable_id',
        'materialable_type', 'user_id',
    ];
    // relación de 1 a 1 con tabla User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // relación de 1 a muchos poliformica inversa con tabla Horario y Asignatura
    public function materialable()
    {
        return $this->morphTo();
    }
}
