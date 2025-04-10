<aside class="diario-sidebar">
    <h4 class="heading--30 color--002D72">Últimas publicaciones</h4>

    <?php
    $args = array(
        'post_type'      => 'diario_medico',
        'posts_per_page' => 3,
        'orderby'        => 'date',
        'order'          => 'DESC'
    );

    $diario_query = new WP_Query($args);

    if ($diario_query->have_posts()) :
        while ($diario_query->have_posts()) : $diario_query->the_post();
    ?>
        <div class="sidebar-item">
            <?php 
                $categoria = get_the_category(); 
                $nombre_categoria = !empty($categoria) ? $categoria[0]->name : 'Cardiología'; 
            ?>
            <span class="diario-categoria"><?php echo esc_html($nombre_categoria); ?></span>
            <h6 class="diario-heading18 color--002D72"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
            <p class="diario-fecha"><?php echo get_the_date('j F, Y'); ?></p>
            <a href="<?php the_permalink(); ?>" class="diario-link"><span class="diario-link__span">Leer publicación</span></a>
        </div>
    <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>No hay publicaciones recientes.</p>';
    endif;
    ?>
</aside>