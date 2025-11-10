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
    public function obtenerTipo(): string
    {
        return 'json-feed';
    }

    public function procesar(&$feed): array
    {
        $json = json_decode($feed);

        $blog = [];
        $posts = [];


        $blog = [
            'nombre' => $json->title,
            'descripción' => $json->description ?? '',
            'url' => $json->home_page_url ?? '',
            'url_ícono' => $json->icon ?? '',
        ];

        foreach ($json->items as $ítem) {

            if (Configuración::$preferir_contenido_corto) {
                $origen = [
                    'resumen' => $ítem->summary ?? '',
                    'html' => $ítem->content_html ?? '',
                    'texto' => $ítem->content_text ?? '',
                ];
            } else {
                $origen = [
                    'html' => $ítem->content_html ?? '',
                    'texto' => $ítem->content_text ?? '',
                    'resumen' => $ítem->summary ?? '',
                ];
            }

            $cuerpo = '';

            // Analizamos cada origen buscando contenido
            foreach ($origen as $tipo => $contenido) {
                if (!$contenido) {
                    continue;
                }

                // Cortamos el post ahorita, de ser necesario, para que corrija
                // los tags que pueden desaparecer
                $longitud = Configuración::$máxima_longitud_post;
                if ($longitud && mb_strlen($contenido) > $longitud) {
                    $contenido = mb_substr($contenido, 0, $longitud) . '…';
                }

                $cuerpo = match ($tipo) {
                    'resumen' => '<p>' . strip_tags($contenido) . '</p>',
                    'texto' => $this->procesarTexto($contenido),
                    'html' => $this->filtrarHTML($contenido),
                };

                break;
            }

            $posts[] = [
                'identificador' => $ítem->id,
                'fecha_publicación' => ($ítem->date_published ?? false) ? new DateTime($ítem->date_published ?? null) : null,
                'fecha_modificación' => ($ítem->date_modified ?? false) ? new DateTime($ítem->date_modified ?? null) : null,
                'url_imagen' => $ítem->image ?? null,
                'título' => $ítem->title ?? null,
                'cuerpo' => $cuerpo,
                'permalink' => $ítem->url,
            ];
        }

        return compact('blog', 'posts');
    }
}
