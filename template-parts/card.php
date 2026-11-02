<?php
defined('ABSPATH') || exit;
?>
<article <?php post_class('card h-100 cf-card'); ?>>
    <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
        <?php cf_imagen_guia('card-img-top'); ?>
    </a>
    <div class="card-body d-flex flex-column">
        <h3 class="h5 card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php
        if (get_post_type() === 'guias') :
            $cf_minutos = cf_campo('tiempo_lectura');
            $cf_nivel   = cf_etiqueta_nivel(cf_campo('nivel'));
            if ($cf_minutos !== '' || $cf_nivel !== '') : ?>
                <p class="cf-meta">
                    <?php if ($cf_minutos !== '') : ?>
                        <span><?php echo esc_html((int) $cf_minutos); ?> min de lectura</span>
                    <?php endif; ?>
                    <?php if ($cf_nivel !== '') : ?>
                        <span class="cf-nivel"><?php echo esc_html($cf_nivel); ?></span>
                    <?php endif; ?>
                </p>
            <?php endif;
        endif; ?>
        <p class="card-text"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 22)); ?></p>
        <a class="btn btn-outline-cf btn-sm mt-auto align-self-start" href="<?php the_permalink(); ?>">Leer más</a>
    </div>
</article>
