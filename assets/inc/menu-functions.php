<?php
defined('ABSPATH') || exit;

function cf_registrar_menus() {
    register_nav_menus(array(
        'menu-principal' => 'Menú principal',
    ));
}
add_action('after_setup_theme', 'cf_registrar_menus');

function cf_menu_clase_li($classes, $item, $args) {
    if (isset($args->theme_location) && $args->theme_location === 'menu-principal') {
        $classes[] = 'nav-item';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'cf_menu_clase_li', 10, 3);

function cf_menu_clase_enlace($atts, $item, $args) {
    if (isset($args->theme_location) && $args->theme_location === 'menu-principal') {
        $clase = 'nav-link';
        if (!empty($item->current)) {
            $clase .= ' active';
        }
        $atts['class'] = $clase;
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'cf_menu_clase_enlace', 10, 3);

/*
 * Menú de respaldo: se usa solo si en Apariencia > Menús no hay un menú asignado.
 */
function cf_menu_respaldo() {
    $enlaces = array(
        'Inicio' => home_url('/'),
        'Guías'  => get_post_type_archive_link('guias'),
    );

    $pagina_blog = get_option('page_for_posts');
    if ($pagina_blog) {
        $enlaces['Blog'] = get_permalink($pagina_blog);
    }

    $paginas = array(
        'resumen'  => 'Resumen',
        'contacto' => 'Contacto',
    );
    foreach ($paginas as $slug => $texto) {
        $pagina = get_page_by_path($slug);
        if ($pagina) {
            $enlaces[$texto] = get_permalink($pagina);
        }
    }

    echo '<ul class="navbar-nav ms-auto mb-2 mb-lg-0">';
    foreach ($enlaces as $texto => $url) {
        if ($url) {
            echo '<li class="nav-item"><a class="nav-link" href="' . esc_url($url) . '">' . esc_html($texto) . '</a></li>';
        }
    }
    echo '</ul>';
}
