<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombres',
        'apellidos',
        'identificacion',
        'direccion',
        'telefono',
        'pais',
        'ciudad',
        'jefe_id', // Asegúrate de incluir esto para la relación jefe
    ];

    // Relación muchos a muchos con cargos
    public function cargos()
    {
        return $this->belongsToMany(Cargo::class, 'cargo_empleado');
    }

    // Relación con el jefe del empleado
    public function jefe()
    {
        return $this->belongsTo(Empleado::class, 'jefe_id');
    }

    // Relación para obtener los colaboradores de un jefe
    public function colaboradores()
    {
        return $this->hasMany(Empleado::class, 'jefe_id');
    }
}
