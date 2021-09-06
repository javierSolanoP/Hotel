<?php
namespace App\Http\Controllers\Require\AbstractClass;

abstract class Usuario {

    public function __construct( protected $nombre = '',
                                 protected $apellido = '',
                                 protected $email = '',
                                 protected $password = '',
                                 protected $confirmPassword = ''
    ){}
    
}