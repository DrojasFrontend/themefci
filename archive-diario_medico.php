<?php
    get_header();
?>

<main class="section-diariomedico__container">

<?php

    get_template_part('template-parts/breadcrumb/seccion', 'breadcrumb-page', array('class' => '') );

    // Seccion Hero
    get_template_part('template-parts/diario-medico/seccion-hero');

    // Seccion Hero Mobile
    get_template_part('template-parts/diario-medico/seccion-hero-mobile');

    // Seccion Diario Medico Results
    get_template_part('template-parts/diario-medico/seccion-diario-medico');

    // Ultimas Publicaciones
    get_template_part('template-parts/diario-medico/seccion-ultimas-publicaciones');

    // Texto Imagen Fondo
    get_template_part('template-parts/diario-medico/seccion-texto-imagen-fondo');

    // Sección Diario Carrusel
    get_template_part('template-parts/diario-medico/seccion-diario-carrusel');
?>

</main>

<?php
    get_footer();
?>