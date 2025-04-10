<section class="cards">
    <div class="cards__container">
        <?php if (have_rows('grupo_tarjetas_grid')) : ?>
            <?php while (have_rows('grupo_tarjetas_grid')) : the_row(); ?>
                <?php if (have_rows('tarjetas')) : ?>
                    <?php while (have_rows('tarjetas')) : the_row(); ?>
                        <article class="card">
                            <?php
                                $imagen = get_sub_field('imagen');
                                $titulo = get_sub_field('titulo');
                                $descripcion = get_sub_field('descripcion');
                                $cta = get_sub_field('cta');
                            ?>
                            <?php if ($imagen) : ?>
                                <img class="card__image" src="<?php echo esc_url($imagen['url']); ?>" alt="<?php echo esc_attr($imagen['alt']); ?>">
                            <?php endif; ?>
                            <div class="card__content">
                                <?php if ($titulo): ?>
                                    <h5 class="heading--24 color--002D72"><?php echo esc_html($titulo); ?></h5>
                                <?php endif; ?>
                                <?php if ($descripcion): ?>
                                    <div class="heading--18 color--263956 card__description"><?php echo $descripcion; ?></div>
                                <?php endif; ?>
                                <?php
                                    if (is_array($cta) && isset($cta['url'], $cta['title'], $cta['target'])) :
                                        $url = $cta['url'];
                                        $texto = $cta['title'];
                                        $target = $cta['target'] ? $cta['target'] : '_self';
                                ?>
                                    <a href="<?php echo esc_url($url); ?>" target="<?php echo esc_attr($target); ?>" class="card__link"><span class="card-link__span"><?php echo esc_html($texto); ?></span></a>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endwhile; ?>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</section>