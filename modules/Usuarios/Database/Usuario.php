<?php

namespace Usuarios\Database;

use Vendimia\Database\{Entity, Field};
use Vendimia\DateTime\DateTime;

use Usuarios\Model;
use Blogs\Database\Blog;

class Usuario extends Entity
{
    static $pre_save = 'generarCódigo';

    #[Field\Char(32)]
    public $usuario;

    #[Field\Char(128)]
    public $nombre;

    #[Field\Char(32)]
    public $hash;

    #[Field\OneToMany(Blog::class)]
    public $blogs;

    public function generarCódigo()
    {
        $this->hash = md5("nnntucomoloariaaaass{$this->nombre}");

        return ['hash'];
    }

    public function getModel(): Model\Usuario
    {
        return new Model\Usuario($this);
    }
}