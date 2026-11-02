<?php
defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main container my-5">
    <?php while (have_posts()) : the_post(); ?>
        <article <?php post_class('cf-article'); ?>>

            <?php
            $tipos_guia = get_the_term_list(get_the_ID(), 'tipo_cuidado', '<span class="cf-badge">', '</span><span class="cf-badge">', '</span>');
            if ($tipos_guia && !is_wp_error($tipos_guia)) : ?>
                <p class="mb-2"><?php echo $tipos_guia; ?></p>
            <?php endif; ?>

            <h1 class="cf-page-title"><?php the_title(); ?></h1>

            <?php
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
            <?php endif; ?>

            <?php cf_imagen_guia('cf-featured', 'large'); ?>

            <?php $cf_consejo = cf_campo('consejo_rapido'); ?>
            <?php if ($cf_consejo !== '') : ?>
                <aside class="cf-consejo" aria-label="Consejo rápido">
                    <strong>Consejo rápido:</strong> <?php echo esc_html($cf_consejo); ?>
                </aside>
            <?php endif; ?>

            <div class="cf-content"><?php the_content(); ?></div>

            <?php the_tags('<div class="cf-tags mt-4"><span class="text-muted me-2">Etiquetas:</span>', ' ', '</div>'); ?>

            <a class="btn btn-outline-cf mt-4" href="<?php echo esc_url(get_post_type_archive_link('guias')); ?>">&larr; Ver todas las guías</a>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
