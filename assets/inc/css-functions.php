<?php
defined('ABSPATH') || exit;

function cf_cargar_estilos() {

    wp_enqueue_style(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        array(),
        '5.3.3'
    );

    wp_enqueue_style(
        'cuidado-felino-style',
        get_stylesheet_uri(),
        array('bootstrap'),
        filemtime(get_stylesheet_directory() . '/style.css')
    );
}
add_action('wp_enqueue_scripts', 'cf_cargar_estilos');
