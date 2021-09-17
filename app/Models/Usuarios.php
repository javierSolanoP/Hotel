<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
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
                           'sesion',
                           'avatar',
                           'id_role'];
}
