<?php

namespace Blogs\Database;

use Vendimia\Database\{Entity, Field};
use Vendimia\DateTime\DateTime;

use Posts\Model;

class Post extends Entity
{
    static $pre_save = 'preSave';

    #[Field\ManyToOne(Blog::class)]
    public $blog;

    /**
     * ID del post, informado por el origen
     */
    #[Field\Char(512)]
    public $identificador;

    /**
     * ID hasheado del post, en SHA256
     */
    #[Field\FixChar(64)]
    public $identificador_hashed;

    #[Field\DateTime]
    public $fecha_publicación;

    #[Field\DateTime(null: true)]
    public $fecha_modificación;

    #[Field\Char(128, null: true)]
    public $título;

    #[Field\Text]
    public $cuerpo;

    #[Field\Char(512, null: true, default: null)]
    public ?string $url_imagen = null;

    #[Field\Char(512, null: true, default: null)]
    public ?string $permalink = null;

    public function preSave()
    {
        $this->identificador_hashed = hash("sha256", $this->identificador);

        return ['identificador_hashed'];
    }

    /**
     * Retorna un post buscando por el hash del identificador
     */
    public static function obtenerPorIdentificador($identificador): ?self
    {
        return self::get(
            identificador_hashed: hash("sha256", $identificador)
        );
    }
}
