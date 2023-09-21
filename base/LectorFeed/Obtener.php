<?php

namespace LectorFeed;

class Obtener
{
    /**
     * Retorna el lector de feed según su tipo
     */
    public static function desdeTipo($tipo): LectorFeedAbstract
    {
        $clase = match($tipo) {
            'json-feed' => JsonFeed::class
        };

        return new $clase;
    }

    /**
     * Devuelve el lector según su tipo mime
     */
    public static function desdeTipoMime($mime): LectorFeedAbstract
    {
        // Si $mime viene con subtipo, lo ignoramos por si las moscas
        $mime = strtolower(explode(';', $mime)[0]);

        $clase = match($mime) {
            'application/feed+json',
            'application/json' => JsonFeed::class
        };

        return new $clase;
    }
}