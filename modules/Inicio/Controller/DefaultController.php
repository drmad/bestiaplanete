<?php

namespace Inicio\Controller;

use Vendimia\Controller\WebController;
use Vendimia\Routing\MethodRoute as Route;
use Vendimia\Core\RequestParameter\{BodyParam,QueryParam};
use Vendimia\Core\Csrf;
use Vendimia\Http\Response;

use Blogs;

class DefaultController extends WebController
{
    #[Route\Get('/')]
    public function listado()
    {
        $posts = Blogs\Database\Post::query()
            ->order('-fecha_publicación')
            ->limit(20)
            ->find()
        ;

        return compact('posts');
    }
}
