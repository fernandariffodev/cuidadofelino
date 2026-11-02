<?php
defined('ABSPATH') || exit;

function cf_contenido_inicial() {

    $tipos = array(
        'alimentacion' => 'Alimentación',
        'salud'        => 'Salud',
        'juego'        => 'Juego y enriquecimiento',
    );
    foreach ($tipos as $slug => $nombre) {
        if (!term_exists($slug, 'tipo_cuidado')) {
            wp_insert_term($nombre, 'tipo_cuidado', array('slug' => $slug));
        }
    }

    if (!get_option('cf_guias_ejemplo_creadas')) {

        $existentes = get_posts(array(
            'post_type'      => 'guias',
            'posts_per_page' => 1,
            'post_status'    => 'any',
        ));

        if (empty($existentes)) {

            $guias = array(
                array(
                    'tipo'      => 'alimentacion',
                    'titulo'    => 'Cómo elegir el alimento adecuado para tu gato',
                    'extracto'  => 'Criterios simples para leer la etiqueta y escoger según la edad, el peso y las necesidades de tu gato.',
                    'contenido' => '<p>Los gatos son carnívoros estrictos, por eso su alimento debe tener una buena fuente de proteína animal como primer ingrediente. Al comparar productos, fíjate en que estén formulados para la etapa de vida de tu gato: gatito, adulto o senior.</p><p>Lee la etiqueta con calma, revisa la porción diaria recomendada y haz los cambios de alimento de forma gradual durante varios días. Si tu gato tiene alguna condición de salud, consulta primero con tu veterinario.</p>',
                ),
                array(
                    'tipo'      => 'alimentacion',
                    'titulo'    => 'Cómo ayudar a tu gato a tomar más agua',
                    'extracto'  => 'Ideas sencillas para aumentar la hidratación: fuentes, alimento húmedo y buenos hábitos.',
                    'contenido' => '<p>Muchos gatos toman poca agua por instinto. Ofrecer varios bebederos limpios en distintos lugares de la casa, lejos de la comida y del arenero, ayuda a que beban más.</p><p>Las fuentes de agua en movimiento y el alimento húmedo también aportan hidratación. Cambia el agua todos los días y lava los recipientes con frecuencia.</p>',
                ),
                array(
                    'tipo'      => 'salud',
                    'titulo'    => 'Señales de que tu gato necesita ir al veterinario',
                    'extracto'  => 'Cambios de conducta, apetito y aseo que conviene no ignorar.',
                    'contenido' => '<p>Los gatos suelen disimular el malestar, así que los cambios pequeños importan. Un apetito distinto, mucho más sueño de lo normal, esconderse, cambios en el uso del arenero o dejar de asearse pueden ser señales de que algo no anda bien.</p><p>Si notas alguno de estos cambios por más de un día o dos, o aparecen vómitos, dificultad para respirar o dolor, consulta a tu veterinario lo antes posible.</p>',
                ),
                array(
                    'tipo'      => 'salud',
                    'titulo'    => 'Controles preventivos: qué conversar con tu veterinario',
                    'extracto'  => 'Una guía para preparar las visitas de control y no olvidar ninguna pregunta.',
                    'contenido' => '<p>Las visitas de control permiten detectar problemas a tiempo. En la consulta conviene conversar sobre vacunas, desparasitación, peso, alimentación y el estado de los dientes.</p><p>Lleva anotadas tus dudas y los cambios que hayas visto en casa. Tu veterinario te indicará con qué frecuencia debe ir tu gato según su edad y su estilo de vida.</p>',
                ),
                array(
                    'tipo'      => 'juego',
                    'titulo'    => 'Juegos simples para mantener activo a tu gato en casa',
                    'extracto'  => 'Rutinas cortas de juego que gastan energía y fortalecen el vínculo con tu gato.',
                    'contenido' => '<p>Bastan entre diez y quince minutos de juego, una o dos veces al día. Los juguetes tipo caña con plumas o cintas imitan a una presa y estimulan su instinto de caza.</p><p>Deja que tu gato atrape el juguete al final de la sesión y guarda los juguetes con cuerdas para que no queden a su alcance sin supervisión.</p>',
                ),
                array(
                    'tipo'      => 'juego',
                    'titulo'    => 'Cómo armar un rincón de enriquecimiento ambiental',
                    'extracto'  => 'Rascadores, alturas y escondites: pequeños cambios que mejoran el bienestar felino.',
                    'contenido' => '<p>Un ambiente enriquecido ayuda a prevenir el aburrimiento y el estrés. Incluye un rascador estable, un lugar alto para observar y un escondite tranquilo donde tu gato pueda descansar.</p><p>Rota los juguetes cada cierto tiempo y ofrece una ventana segura desde donde mirar el exterior. Observa qué prefiere y ajusta el espacio a su personalidad.</p>',
                ),
            );

            foreach ($guias as $guia) {
                $id_guia = wp_insert_post(wp_slash(array(
                    'post_type'    => 'guias',
                    'post_status'  => 'publish',
                    'post_title'   => $guia['titulo'],
                    'post_excerpt' => $guia['extracto'],
                    'post_content' => $guia['contenido'],
                )));

                if ($id_guia && !is_wp_error($id_guia)) {
                    wp_set_object_terms($id_guia, $guia['tipo'], 'tipo_cuidado');
                }
            }
        }

        update_option('cf_guias_ejemplo_creadas', 1);
    }

    flush_rewrite_rules();
}
add_action('after_switch_theme', 'cf_contenido_inicial');
