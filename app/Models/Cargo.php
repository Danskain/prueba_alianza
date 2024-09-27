<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    // Relación muchos a muchos con empleados
    public function empleados()
    {
        return $this->belongsToMany(Empleado::class, 'cargo_empleado');
    }
}
