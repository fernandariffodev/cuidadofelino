<?php
defined('ABSPATH') || exit;

function guias_register() {

    $labels = array(
        'name'               => 'Guías',
        'singular_name'      => 'Guía',
        'add_new'            => 'Agregar nueva',
        'add_new_item'       => 'Agregar nueva guía',
        'edit_item'          => 'Editar guía',
        'new_item'           => 'Nueva guía',
        'view_item'          => 'Ver guía',
        'search_items'       => 'Buscar guías',
        'not_found'          => 'No se encontró',
        'not_found_in_trash' => 'No se encontró en la papelera',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'guias', 'with_front' => false),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_icon'          => 'dashicons-heart',
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
        'taxonomies'         => array('post_tag'), // las guías también admiten etiquetas
    );

    register_post_type('guias', $args);
}

add_action('init', 'guias_register');

function registrar_taxonomia_personalizada() {

    $labels = array(
        'name'              => 'Tipos de cuidado',
        'singular_name'     => 'Tipo',
        'search_items'      => 'Buscar tipos',
        'all_items'         => 'Todos los tipos',
        'parent_item'       => 'Tipo padre',
        'parent_item_colon' => 'Tipo padre:',
        'edit_item'         => 'Editar tipo',
        'update_item'       => 'Actualizar tipo',
        'add_new_item'      => 'Agregar nuevo tipo',
        'new_item_name'     => 'Nuevo nombre de tipo',
        'menu_name'         => 'Tipos de cuidado',
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'tipo-de-cuidado'),
    );

    register_taxonomy('tipo_cuidado', array('guias'), $args);
}

add_action('init', 'registrar_taxonomia_personalizada');

/*
 * Las páginas de etiqueta (/tag/nombre/) solo muestran entradas por defecto:
 * aquí se agregan las guías a esa consulta.
 */
function cf_incluir_guias_en_etiquetas($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_tag()) {
        $query->set('post_type', array('post', 'guias'));
    }
}
add_action('pre_get_posts', 'cf_incluir_guias_en_etiquetas');
