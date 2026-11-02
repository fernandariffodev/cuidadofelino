<?php
defined('ABSPATH') || exit;

/*
 * Módulo ACF: campos personalizados de las guías.
 * Los campos se definen en código (acf_add_local_field_group), así no dependen de
 * configurarlos a mano en el panel. Todo está protegido con function_exists():
 * si el plugin ACF no está activo, el sitio sigue funcionando sin estos datos.
 */

/** Opciones del campo "nivel" (se usan en el campo y al mostrar el valor). */
function cf_niveles_guia() {
    return array(
        'basico'     => 'Básico',
        'intermedio' => 'Intermedio',
        'avanzado'   => 'Avanzado',
    );
}

/** Registra el grupo de campos "Datos de la guía" para el CPT guias. */
function cf_registrar_campos_acf() {

    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key'      => 'group_cf_datos_guia',
        'title'    => 'Datos de la guía',
        'fields'   => array(
            array(
                'key'          => 'field_cf_tiempo_lectura',
                'label'        => 'Tiempo de lectura (minutos)',
                'name'         => 'tiempo_lectura',
                'type'         => 'number',
                'instructions' => 'Cuántos minutos toma leer la guía.',
                'min'          => 1,
                'max'          => 60,
                'step'         => 1,
            ),
            array(
                'key'           => 'field_cf_nivel',
                'label'         => 'Nivel',
                'name'          => 'nivel',
                'type'          => 'select',
                'choices'       => cf_niveles_guia(),
                'default_value' => 'basico',
                'allow_null'    => 0,
                'return_format' => 'value',
            ),
            array(
                'key'          => 'field_cf_consejo_rapido',
                'label'        => 'Consejo rápido',
                'name'         => 'consejo_rapido',
                'type'         => 'textarea',
                'instructions' => 'Una frase corta que resume la guía.',
                'rows'         => 3,
                'maxlength'    => 200,
                'new_lines'    => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'guias',
                ),
            ),
        ),
        'position' => 'normal',
        'style'    => 'default',
        'active'   => true,
    ));
}
add_action('acf/init', 'cf_registrar_campos_acf');

/**
 * Lee un campo ACF de forma segura.
 *
 * @param string   $nombre  Nombre del campo.
 * @param int|bool $post_id ID de la guía (false = la guía actual del bucle).
 * @return mixed Valor del campo, o cadena vacía si no existe o ACF no está activo.
 */
function cf_campo($nombre, $post_id = false) {
    if (!function_exists('get_field')) {
        return '';
    }
    $valor = get_field($nombre, $post_id);
    return ($valor === null || $valor === false) ? '' : $valor;
}

/** Texto legible del nivel ('basico' => 'Básico'). */
function cf_etiqueta_nivel($valor) {
    $niveles = cf_niveles_guia();
    return isset($niveles[$valor]) ? $niveles[$valor] : '';
}

/**
 * Carga, una sola vez, valores de ejemplo en las guías que todavía no tienen datos.
 * Solo corre si ACF está activo.
 */
function cf_valores_acf_iniciales() {

    if (get_option('cf_acf_valores_v1') || !function_exists('update_field')) {
        return;
    }

    // clave en el slug de la guía => tiempo, nivel, consejo
    $datos = array(
        'alimento'  => array(4, 'basico',     'Cambia el alimento de forma gradual durante varios días.'),
        'agua'      => array(3, 'basico',     'Ofrece varios bebederos limpios, lejos del arenero.'),
        'senales'   => array(5, 'intermedio', 'Si el cambio dura más de uno o dos días, consulta a tu veterinario.'),
        'controles' => array(4, 'intermedio', 'Lleva anotadas tus dudas antes de ir al control.'),
        'juegos'    => array(3, 'basico',     'Bastan entre diez y quince minutos de juego, una o dos veces al día.'),
        'rincon'    => array(5, 'intermedio', 'Incluye un rascador estable y un lugar alto para observar.'),
    );

    $guias = get_posts(array(
        'post_type'      => 'guias',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'no_found_rows'  => true,
    ));

    foreach ($guias as $guia) {
        foreach ($datos as $clave => $valores) {
            if (strpos($guia->post_name, $clave) === false) {
                continue;
            }
            if (cf_campo('tiempo_lectura', $guia->ID) === '') {
                update_field('field_cf_tiempo_lectura', $valores[0], $guia->ID);
                update_field('field_cf_nivel', $valores[1], $guia->ID);
                update_field('field_cf_consejo_rapido', $valores[2], $guia->ID);
            }
            break;
        }
    }

    update_option('cf_acf_valores_v1', 1);
}
add_action('acf/init', 'cf_valores_acf_iniciales', 20);
