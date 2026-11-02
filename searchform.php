<?php
defined('ABSPATH') || exit;

$cf_id_buscar = wp_unique_id('cf-buscar-');
?>
<form role="search" method="get" class="cf-search d-flex" action="<?php echo esc_url(home_url('/')); ?>">
    <label class="visually-hidden" for="<?php echo esc_attr($cf_id_buscar); ?>">Buscar guías</label>
    <input
        type="search"
        id="<?php echo esc_attr($cf_id_buscar); ?>"
        class="form-control form-control-sm me-2"
        name="s"
        placeholder="Buscar guías"
        value="<?php echo esc_attr(get_search_query()); ?>"
        required>
    <button class="btn btn-cf btn-sm" type="submit">Buscar</button>
</form>
