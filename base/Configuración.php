<?php

/**
 * Parámetros globales de Bestiaplanete
 */
class Configuración
{
    /**
     * Los posts con más de estos caracteres serán recortados. Falso no
     * recortará los posts
     **/
    static public $máxima_longitud_post = 512;

    /**
     * Obtiene el contenido de cada post en el resumen, texto o html, el primero
     * que tenga contenido.
     *
     * Si este parámetro es falso, obtiene el contenido en sentido contrario.
     */
    static public $preferir_contenido_corto = false;
}