<?php
/* CSS and JS */
function gmOrd_add_theme_scripts()
{
    if ( is_admin() ) return;
    if (
        is_singular() ||
        is_post_type_archive('ordenanza') ||
        is_tax('materia')
    ){

        // CSS
        wp_enqueue_style('gadmur-icons', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css', array(), FALSE, 'all');
        wp_enqueue_style('gadmur-bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css', array(), FALSE, 'all');
        wp_enqueue_style('gadmur', GADMUR_ORDENANZAS_PLUGIN_URL . '/css/common-styles.css', array(), FALSE, 'all');
        // JS
        wp_enqueue_script('gadmur-popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array('jquery'), NULL, true);
        wp_enqueue_script('gadmur-bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array('jquery'), NULL, true);
        wp_enqueue_script('gadmur', GADMUR_ORDENANZAS_PLUGIN_URL . '/js/common-script.js', array('jquery'), NULL, true);  
    }
}
add_action('wp_enqueue_scripts', 'gmOrd_add_theme_scripts');


/* Template include */
add_filter('template_include', 'ordenanza_archive_template', 99);
function ordenanza_archive_template($template)
{
    if (
        is_post_type_archive('ordenanza') ||
        is_tax('materia')
        ) {
        $template = GADMUR_ORDENANZAS_PLUGIN_DIR . '/frontend/templates/archive-template.php';
    }
    if (is_singular('ordenanza')) {
        $template = GADMUR_ORDENANZAS_PLUGIN_DIR . '/frontend/templates/single-template.php';
    }
    return $template;
}
