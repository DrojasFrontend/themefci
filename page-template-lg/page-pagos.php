<?php

    /* 
    Template Name: Plantilla Pagos
    */ 

    get_header();
?>

<main class="pagos__container">

    <?php
        get_template_part('template-parts/breadcrumb/seccion', 'breadcrumb-page', array('class' => '') );

        // Seccion Hero
        get_template_part('template-parts/pagos/seccion-hero');

        // Seccion Tarjetas Grid
        get_template_part('template-parts/pagos/seccion-tarjetas-grid');
    ?>

</main>

<?php
    get_footer();
?>