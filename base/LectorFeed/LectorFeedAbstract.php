<?php

namespace LectorFeed;

use Blogs\Database\Blog;

abstract class LectorFeedAbstract
{
    /** Lista de tags HTML permitidos */
    const TAGS_HTML_PERMITIDOS = [
        'p', 'div', 'span', 'a', 'b', 'i', 'strong', 'em', 'h1', 'h2', 'h3',
        'h4', 'h5', 'h6', 'code', 'pre', 'img', 'figure', 'ul', 'ol', 'blockquote'
    ];

    /** Estos tags HTML acepta que no se cierren */
    const TAGS_SIN_CERRAR = ['img', 'br'];

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
            if (!in_array($nombre_tag, self::TAGS_HTML_PERMITIDOS)) {
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
     * Procesa un feed, añadiendo o actualizando los post en $blog
     *
     * @var Blog $blog Blog donde añadir o actualizar los posts
     * @var string $feed Origen del feed sin procesar. Debería ser pasado como
     *                   referencia.
     */
    abstract public function procesar(Blog $blog, &$feed);
}