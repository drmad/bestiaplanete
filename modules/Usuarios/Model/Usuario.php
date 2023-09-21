<?php

namespace Usuarios\Model;

use Usuarios\Database;

class Usuario
{
    public function __construct(private Database\Usuario $usuario)
    {

    }

    /**
     * Retorna la ruta del hackergotchi del usuario
     */
    public function obtenerUrlHackergotchi()
    {
        return "public/hackergotchi/{$this->usuario->hash}.jpg";
    }

    public function obtenerNombreParaMostrar()
    {
        if ($this->usuario->usuario) {
            return $this->usuario->usuario;
        }

        $this->usuario->nombre;
    }
}