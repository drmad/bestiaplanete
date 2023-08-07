<?php

namespace LectorFeed;

use Vendimia\DateTime\DateTime;

use Blogs\Database\{Blog, Post};

use Configuración;


/**
 * Procesa un feed en formato JsonFeed 1.1
 *
 * @see https://www.jsonfeed.org/version/1.1/
 */
class JsonFeed extends LectorFeedAbstract
{
    public function procesar(Blog $blog, &$feed)
    {
        $json = json_decode($feed);

        foreach ($json->items as $ítem) {

            if (Configuración::$preferir_contenido_corto) {
                $origen = [
                    'resumen' => $ítem->summary ?? '',
                    'texto' => $ítem->content_text ?? '',
                    'html' => $ítem->content_html ?? '',
                ];
            } else {
                $origen = [
                    'html' => $ítem->content_html ?? '',
                    'texto' => $ítem->content_text ?? '',
                    'resumen' => $ítem->summary ?? '',
                ];
            }

            $cuerpo = false;

            // Analizamos cada origen buscando contenido
            foreach ($origen as $tipo => $contenido) {
                if (!$contenido) {
                    continue;
                }

                // Cortamos el post ahorita, de ser necesario, para que corrija
                // los tags que pueden desaparecer
                $longitud = Configuración::$máxima_longitud_post;
                if ($longitud && strlen($contenido) > $longitud) {
                    $contenido = substr($contenido, 0, $longitud) . '…';
                }

                if ($tipo == 'resumen') {
                    // Texto plano
                    $cuerpo = '<p>' . strip_tags($contenido) . '</p>';
                } elseif ($tipo == 'texto') {
                    $cuerpo = $this->procesarTexto($contenido);
                } else {
                    $cuerpo = $this->filtrarHTML($contenido);
                }
            }

            if (!$cuerpo) {
                throw new Exception();
            }

            // Buscamos si existe el post
            $post = Post::obtenerPorIdentificador($ítem->id);

            if (!$post) {
                $post = new Post;
            }

            $post->update(
                blog: $blog,
                identificador: $ítem->id,
                fecha_publicación: new DateTime($ítem->date_published ?? null),
                fecha_modificación: new DateTime($ítem->date_modified ?? null),
                url_imagen: $ítem->image ?? null,
                título: $ítem->title ?? null,
                cuerpo: $cuerpo,
                permalink: $ítem->url,
           );
        }
    }
}