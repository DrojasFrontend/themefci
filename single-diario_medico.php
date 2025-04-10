<?php
    get_header();
?>

<main class="section-diariomedico__container">

<?php

    get_template_part('template-parts/breadcrumb/seccion', 'breadcrumb-page', array('class' => '') );

    // Seccion Hero
    get_template_part('template-parts/diario-medico/seccion-hero-single');

    // Seccion Contenido
    get_template_part('template-parts/diario-medico/seccion-contenido-single');

    // Texto Imagen Fondo
    get_template_part('template-parts/diario-medico/seccion-texto-imagen-fondo-single');

    // Sección Diario Carrusel
    get_template_part('template-parts/diario-medico/seccion-diario-carrusel');
?>

</main>

<?php
    get_footer();
?>