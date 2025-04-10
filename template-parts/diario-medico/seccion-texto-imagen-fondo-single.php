<?php 
    $grupoTextoImagenFondo = get_field('grupo_texto_imagen_fondo');
    $titulo = $grupoTextoImagenFondo['titulo'] ?? '';
    $descripcion = $grupoTextoImagenFondo['descripcion'] ?? '';
    $imagen = $grupoTextoImagenFondo['imagen'] ?? '';
    $cta = $grupoTextoImagenFondo['cta'] ?? '';

    $hayContenido = $titulo || $descripcion || $imagen;
?>

<?php if ($hayContenido): ?>
    <section class="section-directorio__info">
        <div class="banner__container">
            <div class="banner__content">
                <?php if( $titulo ): ?>
                    <h2 class="heading--48 color--002D72"><?php echo esc_html($titulo); ?></h2>
                <?php endif; ?>
                <?php if( $descripcion ): ?>
                    <div class="heading--18 color--0C2448">
                        <?php echo $descripcion; ?>
                    </div>
                <?php endif; ?>
                <?php
                    if (is_array($cta) && isset($cta['url'], $cta['title'], $cta['target'])) :
                        $url = $cta['url'];
                        $texto = $cta['title'];
                        $target = $cta['target'] ? $cta['target'] : '_self';
                ?>
                <a href="<?php echo esc_url($url); ?>" target="<?php echo esc_attr($target); ?>" class="boton-v2 boton-v2--rojo-rojo"><?php echo esc_html($texto); ?></a>
                <?php endif; ?>
            </div>
            <div class="banner__image">
                <?php if ($imagen) : ?>
                    <img src="<?php echo esc_url($imagen['url']); ?>" alt="<?php echo esc_attr($imagen['alt']); ?>" class="banner__img">
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>