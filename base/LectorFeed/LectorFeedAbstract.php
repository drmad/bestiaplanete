<?php

namespace LectorFeed;

use Blogs\Database\{Blog, Post};
use Vendimia\DateTime\DateTime;

abstract class LectorFeedAbstract
{
    /** Lista de tags HTML permitidos */
    const TAGS_PERMITIDOS = [
        'p', 'div', 'span', 'a', 'b', 'i', 'strong', 'em', 'h1', 'h2', 'h3',
        'h4', 'h5', 'h6', 'code', 'pre', 'ul', 'ol', 'li',
        'blockquote'
    ];

    /** Estos tags HTML acepta que no se cierren */
    const TAGS_SIN_CERRAR = ['br'];

    /**
     * Elimina tags HTML no permitidos.
     *
     * También añade el tag de cerrado al final, para evitar que destruya la
     * web.
     */
    public function filtrarHTML($origen): string
    {
        $tags_abiertos = [];

        // Lista para remover tags, en formato listo para strtr()
        $lista_remoción = [];

        // Si hay una elipsis al final, y hay que cortar el origen, regresamos
        // la elipsis
        $hay_elipsis = str_ends_with($origen, '…');

        // Buscamos si hay un tag incompleto, por si ha sido cortado a mitad.
        $último_menor_qué = strrpos($origen, '<');

        // Si no hay un "menor qué", entonces no hay tags. No hacemos nada
        if ($último_menor_qué !== false) {
            $último_mayor_qué = strrpos($origen, '>');

            // El último "mayor qué" debe estar _después_ que el último "menor qué",
            // de lo contrario, hay un tag mal formado al final
            if ($último_mayor_qué < $último_menor_qué) {
                // Simple, lo removemos
                $origen = substr($origen, 0, $último_menor_qué);
                if ($hay_elipsis) {
                    $origen .= '…';
                }
            }
        }


        $patrón = '/<(.+?)>/';
        $tags = preg_match_all($patrón, $origen, $matches, flags: PREG_SET_ORDER);

        foreach ($matches as $match) {
            $tag = $match[0];
            $nombre_tag = explode(' ', $match[1])[0];

            // Los tags que no se cierran acaban en /. Si hay un / final, lo
            // removemos
            if (str_ends_with($nombre_tag, '/')) {
                $nombre_tag = substr($nombre_tag, 0, -1);
            }


            $tag_cerrado = false;
            if ($nombre_tag[0] == '/') {
                $tag_cerrado = true;
                $nombre_tag = substr($nombre_tag, 1);
            }

            // El tag está prohibido?
            if (!in_array($nombre_tag, self::TAGS_PERMITIDOS)) {
                $lista_remoción[$tag] = '';
            }

            if ($tag_cerrado) {
                // Removemos el tag de la lista. Debería de existir
                $índice = array_search($nombre_tag, array_reverse($tags_abiertos, preserve_keys: true));

                if ($índice !== false) {
                    unset($tags_abiertos[$índice]);
                }

            } else {
                if (!in_array($nombre_tag, self::TAGS_SIN_CERRAR)) {
                    // Añadimos el tag en la lista
                    $tags_abiertos[] = $nombre_tag;
                }
            }
        }

        // Removemos los tags inválidos
        if ($lista_remoción) {
            $origen = strtr($origen, $lista_remoción);
        }

        // Añadimos todos los tags que quedaron abiertos
        foreach($tags_abiertos as $tag) {
            $origen .= "</{$tag}>";
        }

        return $origen;
    }

    /**
     * Procesa texto plano, devuelve un HTML simple
     */
    public function procesarTexto($origen): string
    {
        $párrafos = preg_split("/[\n\r]{2,}/", $origen);
        $html = join('', array_map(fn($párrafo) => "<p>{$párrafo}</p>", $párrafos));

        return $html;
    }

    /**
     * Graba o actualizar un post en un blog con la info obtenida de procesar()
     */
    public function grabarPost(Blog $blog, array $información_posts)
    {
        foreach ($información_posts as $información_post) {
            // Buscamos si existe el post
            $post = Post::obtenerPorIdentificador($información_post['identificador']);

            if (!$post) {
                $post = new Post;

                // Para los nuevos posts, si no hay fecha de creación o
                // publicación, usamos la fecha actual
                if (!$información_post['fecha_publicación']) {
                    $información_post['fecha_publicación'] = DateTime::now();
                }
                if (!$información_post['fecha_modificación']) {
                    $información_post['fecha_modificación'] = DateTime::now();
                }
            }

            // En este punto, si no hay fecha de creación o modificación
            // en inforamción_post, la removemos para que no pase un null a la
            // db
            if (!$información_post['fecha_publicación']) {
                unset($información_post['fecha_publicación']);
            }
            if (!$información_post['fecha_modificación']) {
                unset($información_post['fecha_modificación']);
            }

            $información_post['blog'] = $blog;
            $post->update(...$información_post);
        }
    }

    /**
     * Procesa un feed, añadiendo o actualizando los post en $blog
     *
     * @var string $feed Origen del feed sin procesar. Debería ser pasado como
     *                   referencia.
     * @return array
     */
    abstract public function procesar(&$feed): array;

    /**
     * Devuelve el tipo del feed
     */
    abstract public function obtenerTipo(): string;

}
