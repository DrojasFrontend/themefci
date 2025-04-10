<section class="section__publicaciones">
    <h2 class="heading--48 color--002D72">Publicaciones más leídas</h2>
    <div class="publicaciones__container">
        <div class="swiper publicaciones__swiper">
            <div class="swiper-wrapper">
                <?php
                $args = array(
                    'post_type'      => 'diario_medico',
                    'posts_per_page' => 6,
                    'order'          => 'DESC',
                );
                $query = new WP_Query($args);

                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                        $categoria = get_the_terms(get_the_ID(), 'category')[0]->name ?? 'Cardiología';
                        $fecha = get_the_date('d F, Y');
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
                    <div class="swiper-slide">
                        <article class="publicaciones__card">
                            <div class="diario-medico-img">
                                <?php the_post_thumbnail('medium'); ?>
                            </div>
                            <div class="diario-medico-content">
                                <div class="diario-card__tags">
                                    <span class="diario-categoria"><?php echo esc_html($categoria); ?></span>
                                    <span class="diario-fecha"><?php echo esc_html($fecha); ?></span>
                                </div>
                                <h5 class="publicaciones__title heading--24 color--002D72">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h5>
                                <p class="heading--18 color--263956"><?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?></p>
                                <?php if ($autor_nombre) : ?>
                                    <p class="diario-autor heading--18 color--0C2448">Profesional: <strong><?php echo esc_html($autor_nombre); ?></strong></p>
                                <?php endif; ?>
                                <a href="<?php the_permalink(); ?>" class="diario-link"><span class="diario-link__span">Leer publicación</span></a>
                            </div>
                        </article>
                    </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>No hay publicaciones disponibles.</p>';
                endif;
                ?>
            </div>
        </div>

        <div class="swiper-custom-button swiper-button-prev"></div>
        <div class="swiper-custom-button swiper-button-next"></div>

        <div class="swiper-pagination"></div>
    </div>
</section>