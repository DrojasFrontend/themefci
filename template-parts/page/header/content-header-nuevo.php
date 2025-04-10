<?php
    $sitename   = get_bloginfo('name');
    $homeurl    = get_home_url();
    $logo_id    = get_theme_mod('custom_logo');
    $logo       = wp_get_attachment_image_src($logo_id, 'full');
?>

<div class="customHeaderTop customHeaderTopNuevo">
	<div class="d-flex justify-content-between w-100 px-24">
        <div class="d-flex align-items-center">
            <a href="https://www.elempleo.com/co/sitio-empresarial/cardio-infantil/ofertas-laborales" target="_blank" title="Trabaja con nosotros">Trabaja con nosotros</a>
            <a href="https://www.lacardio.org/ley-de-transparencia/" target="_blank" title="Transparencia y buen Gobierno">Transparencia y buen Gobierno</a>
            <a href="https://www.lacardio.org/noticias/" target="_blank" title="Noticias y eventos">Noticias y eventos</a>
            <a href="https://fundacion.cardioinfantil.org/" target="_blank" title="Donaciones">Dona ahora</a>
        </div>
        <div class="position-relative">
            <?php get_template_part('template-parts/page/header/content', 'header-contactanos') ?>
        </div>
    </div>	
</div>
<header class="customHeader customHeaderNuevo">
    <div class="customHeader__wrapper">
        <!-- logo -->
        <div class="customHeader__logo">
            <a href="<?php echo esc_url($homeurl) ?>">
                <?php if ($logo) { ?>
                    <img src="<?php echo esc_url($logo[0]) ?>" alt="Logo <?php echo esc_attr($sitename) ?>" width="127" height="46" />
                <?php } ?>
            </a>
        </div>
        <!-- Fin Logo -->
        <button class="customHeader-boton__menu" type="button" id="js-toggle-button">
            <span></span>
        </button>
        <!-- Menu Escritorio -->
            <?php get_template_part('template-parts/page/header/content', 'header-escritorio-nuevo') ?>
        <!-- Fin Menu Escritorio -->

        <!-- Menu Escritorio -->
        <?php get_template_part('template-parts/page/header/content', 'header-mobile-nuevo') ?>
        <!-- Fin Menu Escritorio -->
		<!-- Buscar -->
        <?php get_template_part('template-parts/page/header/content', 'header-buscar-nuevo') ?>
        <!-- Fin Buscar -->

        <!-- Buscar -->
        <?php get_template_part('template-parts/page/header/content', 'header-contacto-nuevo') ?>
        <!-- Fin Buscar -->

    </div>
    
</header>