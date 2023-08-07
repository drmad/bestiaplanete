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
}