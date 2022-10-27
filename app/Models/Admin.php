<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'telefono',
        'user_id',
    ];
    // relación de 1 a 1 con tabla User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
