<?php

namespace Blogs\Database;

use Vendimia\Database\{Entity, Field};
use Vendimia\DateTime\DateTime;

use Blogs\Model;

use Usuarios\Database\Usuario;

class Blog extends Entity
{
    #[Field\ManyToOne(Usuario::class)]
    public $usuario;

    #[Field\Char(128)]
    public $nombre;

    #[Field\Char(256)]
    public $url;

    #[Field\Char(256)]
    public $url_feed;

    #[Field\Enum(valid_values: ['json-feed'])]
    public $tipo_feed;

    #[Field\Boolean(default: true)]
    public $activo;
}