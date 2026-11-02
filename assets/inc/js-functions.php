<?php
defined('ABSPATH') || exit;

function cf_cargar_scripts() {

    wp_enqueue_script(
        'bootstrap-bundle',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        array(),
        '5.3.3',
        true
    );

    // JavaScript propio: validación de formularios, contador, filtro de tabla y botón "volver arriba".
    wp_enqueue_script(
        'cuidado-felino-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array('bootstrap-bundle'),
        filemtime(get_template_directory() . '/assets/js/main.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'cf_cargar_scripts');
