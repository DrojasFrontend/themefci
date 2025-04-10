<?php
function enqueue_scripts_nuevos() {
    // Define version variable
    $version = '1.0.0';
    
    // Enqueue jQuery
    wp_enqueue_script('jquery');
    
    // Mover el CSS fuera del condicional y darle una prioridad alta (número bajo)
    $citasMedicasCssFileURI = get_template_directory_uri() . '/template/css-lacardio.css';
    wp_enqueue_style('css_lacardio', $citasMedicasCssFileURI, array(), $version, 'all');
    
    function enqueue_swiper_assets_() {
        // Enqueue Swiper CSS
        wp_enqueue_style('swiper_css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), null);
        // Enqueue Swiper JS
        wp_enqueue_script('swiper_js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array('jquery'), null, true);
    }

    // Paginas
    $paginas = array(
        'template/template-inicio.php',
    );

    if(is_page_template($paginas) ) {
        enqueue_swiper_assets_();
        
        $citasMedicasJsFileURI = get_template_directory_uri() . '/template/js-lacardio.js';
        wp_register_script('js_lacardio', $citasMedicasJsFileURI, array('jquery'), $version, true);
        wp_enqueue_script('js_lacardio');
    }

    // Localize Script
    wp_localize_script('main_js', 'lm_params', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
    ));
}

// Cambiar la prioridad del hook (5 es una prioridad alta)
add_action('wp_enqueue_scripts', 'enqueue_scripts_nuevos', 20);
