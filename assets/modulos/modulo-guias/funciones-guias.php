<?php
defined('ABSPATH') || exit;

/*
 * Funciones de apoyo del módulo de guías.
 */

/**
 * Devuelve las guías publicadas de un término de "tipo_cuidado".
 *
 * @param int $id_termino ID del término.
 * @return WP_Post[] Arreglo de guías (vacío si no hay).
 */
function cf_guias_por_termino($id_termino) {
    return get_posts(array(
        'post_type'      => 'guias',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'no_found_rows'  => true,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'tax_query'      => array(
            array(
                'taxonomy' => 'tipo_cuidado',
                'field'    => 'term_id',
                'terms'    => (int) $id_termino,
            ),
        ),
    ));
}
