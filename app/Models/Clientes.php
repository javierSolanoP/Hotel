<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;

    protected $fillable = ['cedula', 
                           'nombre', 
                           'apellido', 
                           'genero', 
                           'edad', 
                           'fecha_nacimiento',
                           'email',
                           'password',
                           'telefono',
                           'sesion'];
}
