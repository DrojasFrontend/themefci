<?php
    $grupoProfesional = get_field('grupo_profesional');
    $especialista = $grupoProfesional['especialista'] ?? null;
    $genero = $grupoProfesional['genero'] ?? '';

    $especialista_nombre = null;
    $especialista_url = null;
    $titulo_genero = '';

    $autor_id = get_post_meta(get_the_ID(), 'author_doctor', true);
    $autor_url = $autor_id ? get_permalink($autor_id) : '';
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
                $titulo_genero = 'Dr. ';
            } elseif ($genero === 'mujer') {
                $titulo_genero = 'Dra. ';
            }
        }
    }

    if (empty($especialista_nombre)) {
        $titulo_genero = 'Dr. ';
        $especialista_nombre = 'Andrés Martínez';
    }
?>

<section class="single-hero__section">
    <div class="hero-diario">
        <div class="hero-diario-contenido">
            <div class="diario-card__tags">
                <?php 
                    $categoria = get_the_category(); 
                    $nombre_categoria = !empty($categoria) ? $categoria[0]->name : 'Cardiología'; 
                ?>
                <span class="diario-categoria"><?php echo esc_html($nombre_categoria); ?></span>
                <span class="diario-fecha"><?php echo get_the_date('j F, Y'); ?></span>
            </div>

            <h2 class="heading--48 color--002D72"><?php the_title(); ?></h2>
            <p class="heading--14 color--002D72">Escrito por:</p>
            <h4 class="heading--30 color--002D72"><?php echo esc_html($titulo_genero . $autor_nombre); ?></h4>
            <?php if (!empty($autor_url)) : ?>
            <a href="<?php echo esc_url($autor_url); ?>" class="diario-link">
                <span class="diario-link__span">
                    Ver perfil
                </span>
            </a>
            <?php endif; ?>
        </div>

        <div class="hero-diario-explora">
            <h4 class="heading--30 color--002D72">Explora nuestra especialidad</h4>
            <p class="heading--18 color--263956">Descubre toda la información, servicios y profesionales que te ofrecemos.</p>
            <?php 
                $categoria = get_the_category(); 
                if (!empty($categoria)) : 
                    $categoria_nombre = $categoria[0]->name;
                    $categoria_url = get_category_link($categoria[0]->term_id);
            ?>
            <a href="#" class="diario-link"><span class="diario-link__span">Visitar <?php echo esc_html($categoria_nombre); ?></span></a>
            <?php endif; ?>
        </div>
    </div>
</section>