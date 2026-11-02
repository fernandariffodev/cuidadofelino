<?php defined('ABSPATH') || exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="visually-hidden-focusable" href="#primary">Saltar al contenido</a>

<header class="site-header">
    <nav class="navbar navbar-expand-lg navbar-dark cf-navbar">
        <div class="container">
            <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html(get_bloginfo('name')); ?></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Abrir menú">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menuPrincipal">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'menu-principal',
                    'container'      => false,
                    'menu_class'     => 'navbar-nav ms-auto mb-2 mb-lg-0',
                    'fallback_cb'    => 'cf_menu_respaldo',
                    'depth'          => 1,
                ));
                ?>
                <div class="ms-lg-3 mb-2 mb-lg-0">
                    <?php get_search_form(); ?>
                </div>
            </div>
        </div>
    </nav>
</header>
