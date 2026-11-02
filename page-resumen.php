<?php
defined('ABSPATH') || exit;

get_header();

$tipos = get_terms(array(
    'taxonomy'   => 'tipo_cuidado',
    'hide_empty' => false,
    'orderby'    => 'term_id',
    'order'      => 'ASC',
));
$total_guias = 0;
?>

<main id="primary" class="site-main container my-5">
    <?php while (have_posts()) : the_post(); ?>
        <header class="mb-4">
            <h1 class="cf-page-title"><?php the_title(); ?></h1>
            <div class="cf-content"><?php the_content(); ?></div>
        </header>
    <?php endwhile; ?>

    <?php if (!is_wp_error($tipos) && !empty($tipos)) : ?>

        <div class="mb-3 cf-narrow">
            <label for="cf-filtro-tabla" class="form-label">Filtrar la tabla</label>
            <input type="search" class="form-control" id="cf-filtro-tabla" placeholder="Escribe un tipo o el título de una guía">
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle cf-table" id="cf-tabla-guias">
                <caption>Guías publicadas, agrupadas por tipo de cuidado</caption>
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Tipo de cuidado</th>
                        <th scope="col" class="text-center">N.º de guías</th>
                        <th scope="col">Guías</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tipos as $tipo) :
                        $guias        = cf_guias_por_termino($tipo->term_id);
                        $total_guias += count($guias);
                        $enlace_tipo  = get_term_link($tipo); ?>
                        <tr>
                            <th scope="row">
                                <?php if (!is_wp_error($enlace_tipo)) : ?>
                                    <a href="<?php echo esc_url($enlace_tipo); ?>"><?php echo esc_html($tipo->name); ?></a>
                                <?php else : ?>
                                    <?php echo esc_html($tipo->name); ?>
                                <?php endif; ?>
                            </th>
                            <td class="text-center"><span class="badge text-bg-secondary"><?php echo esc_html(count($guias)); ?></span></td>
                            <td>
                                <?php if (!empty($guias)) : ?>
                                    <ul class="list-unstyled mb-0">
                                        <?php foreach ($guias as $guia) : ?>
                                            <li><a href="<?php echo esc_url(get_permalink($guia)); ?>"><?php echo esc_html(get_the_title($guia)); ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else : ?>
                                    <span class="text-muted">Sin guías todavía</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="row">Total</th>
                        <td class="text-center"><strong><?php echo esc_html($total_guias); ?></strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

    <?php else : ?>
        <div class="alert alert-info" role="alert">Aún no hay tipos de cuidado registrados.</div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
