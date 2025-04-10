<div class="diario-container">
    <h2 class="heading--48 color--002D72">Últimas publicaciones</h2>

    <?php
        $args = array(
            'post_type'      => 'diario_medico',
            'posts_per_page' => 4,
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
        $query = new WP_Query($args);
    ?>

    <?php if ($query->have_posts()) : ?>
        <div class="diario-grid">
            <?php $count = 0; ?>
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <?php
                    $grupoProfesional = get_field('grupo_profesional');
                    $especialista = $grupoProfesional['especialista'] ?? null;
                    $genero = $grupoProfesional['genero'] ?? '';
                
                    $especialista_nombre = null;
                    $especialista_url = null;
                    $titulo_genero = '';

                    $autor_id = get_post_meta(get_the_ID(), 'author_doctor', true);
                    if ($autor_id) {
                        $autor_nombre = get_the_title($autor_id);
                    } else {
                        $autor_nombre = '';
                    }
                
                    if (!empty($especialista)) {
                        if (is_array($especialista)) {
                            $especialista = $especialista[0]; 
                        }
                
                        if (is_object($especialista)) {
                            $especialista_nombre = get_the_title($especialista->ID);
                            $especialista_url = get_permalink($especialista->ID);
                
                            // Determinar el prefijo basado en el género
                            if ($genero === 'hombre') {
                                $titulo_genero = 'Dr ';
                            } elseif ($genero === 'mujer') {
                                $titulo_genero = 'Dra ';
                            }
                        }
                    }

                    if (empty($especialista_nombre)) {
                        $titulo_genero = 'Dr ';
                        $especialista_nombre = 'Andrés Martínez';
                    }
                ?>
                <?php if ($count == 0) : ?>
                    <!-- Publicación destacada -->
                    <div class="diario-principal">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('large', ['class' => 'diario-img']); ?>
                            </a>
                        <?php endif; ?>
                        <div class="diario-contenido">
                            <?php 
                                $categoria = get_the_category(); 
                                $nombre_categoria = !empty($categoria) ? $categoria[0]->name : 'Cardiología'; 
                            ?>
                            <span class="diario-categoria"><?php echo esc_html($nombre_categoria); ?></span>
                            <span class="diario-fecha"><?php echo get_the_date('j F, Y'); ?></span>
                            <h4 class="heading--30 diario-medico__title color--002D72">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                            <p class="heading--18 color--263956"><?php echo get_the_excerpt(); ?></p>
                            <?php if ($autor_nombre) : ?>
                                <p class="diario-autor__contenido heading--18 color--0C2448">Profesional: <strong><?php echo esc_html($autor_nombre); ?></strong></p>
                            <?php endif; ?>
                            <a href="<?php the_permalink(); ?>" class="diario-link"><span class="diario-link__span">Leer publicación</span></a>
                        </div>
                    </div>
                <?php else : ?>
                    <!-- Publicaciones secundarias -->
                    <?php if ($count == 1) : ?>
                        <div class="diario-secundarios swiper-container">
                            <div class="swiper-wrapper">
                    <?php endif; ?>

                                <div class="diario-card swiper-slide">
                                    <div class="diario-card-body">
                                        <div class="diario-card__tags">
                                            <?php 
                                                $categoria = get_the_category(); 
                                                $nombre_categoria = !empty($categoria) ? $categoria[0]->name : 'Cardiología'; 
                                            ?>
                                            <span class="diario-categoria"><?php echo esc_html($nombre_categoria); ?></span>
                                            <span class="diario-fecha"><?php echo get_the_date('j F, Y'); ?></span>
                                        </div>
                                        <h6 class="diario-heading18 color--002D72">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h6>
                                        <?php if ($autor_nombre) : ?>
                                            <p class="diario-autor heading--18 color--0C2448">Profesional: <strong><?php echo esc_html($autor_nombre); ?></strong></p>
                                        <?php endif; ?>
                                        <a href="<?php the_permalink(); ?>" class="diario-link diario-link__secundario"><span class="diario-link__span">Leer publicación</span></a>
                                    </div>
                                </div>

                    <?php if ($count == 3) : ?>
                            </div>
                        </div>
                        <div id="swiper-pagination-publicaciones"></div>
                    <?php endif; ?>
                <?php endif; ?>
                <?php $count++; ?>
            <?php endwhile; ?>
        </div>

    <?php else : ?>
        <p class="diario-vacio">No hay publicaciones disponibles.</p>
    <?php endif; ?>

    <?php wp_reset_postdata(); ?>
</div>