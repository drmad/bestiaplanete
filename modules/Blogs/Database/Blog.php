<?php

namespace Blogs\Database;

use Vendimia\Database\{Entity, Field};
use Vendimia\DateTime\DateTime;

use Blogs\Model;

use Usuarios\Database\Usuario;

class Blog extends Entity
{
    static $pre_save = 'crearHashUrl';

    #[Field\ManyToOne(Usuario::class)]
    public $usuario;

    #[Field\Char(128)]
    public $nombre;

    #[Field\Char(256)]
    public $descripción;

    #[Field\Char(256)]
    public $url;

    #[Field\Char(64)]
    public $hash_url;

    #[Field\Char(256)]
    public $url_feed;

    #[Field\Char(256, null: true)]
    public $url_ícono;

    #[Field\Enum(valid_values: ['json-feed'])]
    public $tipo_feed;

    #[Field\Boolean(default: true)]
    public bool $activo = true;

    public function crearHashUrl()
    {
        $this->hash_url = hash('sha256', $this->url);

        return ['hash_url'];
    }
}
