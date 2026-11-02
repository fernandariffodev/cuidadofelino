<?php
defined('ABSPATH') || exit;

function cf_fotos_guias() {
    return array(
        'alimento'  => 'alimento.jpg',
        'agua'      => 'agua.jpg',
        'senales'   => 'senales.jpg',
        'controles' => 'controles.jpg',
        'juegos'    => 'juegos.jpg',
        'rincon'    => 'rincon.jpg',
    );
}

function cf_foto_guia_url($post_id) {
    if (get_post_type($post_id) !== 'guias') {
        return '';
    }
    $slug = get_post_field('post_name', $post_id);
    foreach (cf_fotos_guias() as $clave => $archivo) {
        if (strpos($slug, $clave) !== false) {
            return get_template_directory_uri() . '/assets/img/' . $archivo;
        }
    }
    return '';
}

function cf_imagen_guia($clase = 'card-img-top', $tamano = 'medium_large') {
    if (has_post_thumbnail()) {
        the_post_thumbnail($tamano, array('class' => $clase));
        return;
    }
    $url = cf_foto_guia_url(get_the_ID());
    if ($url) {
        echo '<img class="' . esc_attr($clase) . '" src="' . esc_url($url) . '" alt="' . esc_attr(get_the_title()) . '" loading="lazy">';
    } else {
        echo '<div class="cf-placeholder" aria-hidden="true"></div>';
    }
}
