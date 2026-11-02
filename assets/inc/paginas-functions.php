<?php
defined('ABSPATH') || exit;

/*
 * Crea una sola vez las páginas base del mapa de navegación:
 * "Contacto" (page-contacto.php) y "Resumen de guías" (page-resumen.php).
 * WordPress aplica cada plantilla por el slug de la página.
 */
function cf_crear_paginas_base() {

    if (get_option('cf_paginas_base_v1') || !current_user_can('manage_options')) {
        return;
    }

    $paginas = array(
        'resumen'  => array(
            'titulo'    => 'Resumen de guías',
            'contenido' => '<p>Todas las guías del sitio ordenadas por tipo de cuidado. Usa el buscador de la tabla para encontrar un tema.</p>',
        ),
        'contacto' => array(
            'titulo'    => 'Contacto',
            'contenido' => '<p>¿Tienes una duda o quieres sugerir un tema? Escríbenos con este formulario.</p>',
        ),
    );

    foreach ($paginas as $slug => $datos) {
        if (!get_page_by_path($slug)) {
            wp_insert_post(array(
                'post_type'    => 'page',
                'post_status'  => 'publish',
                'post_title'   => $datos['titulo'],
                'post_name'    => $slug,
                'post_content' => $datos['contenido'],
            ));
        }
    }

    update_option('cf_paginas_base_v1', 1);
}
add_action('admin_init', 'cf_crear_paginas_base');

/*
 * Asigna, una sola vez, etiquetas de ejemplo a las guías que todavía no tienen ninguna.
 */
function cf_etiquetas_iniciales() {

    if (get_option('cf_etiquetas_v1') || !current_user_can('manage_options')) {
        return;
    }

    // clave en el slug de la guía => etiquetas
    $etiquetas = array(
        'alimento'  => array('nutrición', 'alimento'),
        'agua'      => array('hidratación', 'nutrición'),
        'senales'   => array('veterinario', 'prevención'),
        'controles' => array('veterinario', 'prevención'),
        'juegos'    => array('enriquecimiento', 'bienestar'),
        'rincon'    => array('enriquecimiento', 'bienestar'),
    );

    $guias = get_posts(array(
        'post_type'      => 'guias',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'no_found_rows'  => true,
    ));

    foreach ($guias as $guia) {
        if (has_tag('', $guia)) {
            continue;
        }
        foreach ($etiquetas as $clave => $lista) {
            if (strpos($guia->post_name, $clave) !== false) {
                wp_set_post_tags($guia->ID, $lista, true);
                break;
            }
        }
    }

    update_option('cf_etiquetas_v1', 1);
}
add_action('admin_init', 'cf_etiquetas_iniciales');
