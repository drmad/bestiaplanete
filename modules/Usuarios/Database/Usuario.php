<?php

namespace Usuarios\Database;

use Vendimia\Database\{Entity, Field};
use Vendimia\DateTime\DateTime;

use Usuarios\Model;

class Usuario extends Entity
{
    #[Field\Char(128)]
    public $nombre;

    #[Field\Char(32)]
    public $alias;

    public function getModel(): Model\Usuario
    {
        return new Model\Usuario($this);
    }
}