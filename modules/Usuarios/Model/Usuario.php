<?php

namespace Usuarios\Model;

use Usuarios\Database;

class Usuario
{
    public function __construct(private Database\Usuario $usuario)
    {

    }

    /**
     *
     */
    public function obtenerUrlHackergotchi()
    {
        $ruta = 'public/hackergotchi/' .
            md5("nnntucomoloariaaaass{$this->usuario->pk()}") .
            '.jpg'
        ;

        return $ruta;
    }

    public function obtenerNombreParaMostrar()
    {
        if ($this->usuario->alias) {
            return $this->usuario->alias;
        }

        $this->usuario->nombre;
    }
}