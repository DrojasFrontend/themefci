<?php
    $grupoHero = get_field('grupo_hero');
    $titulo = $grupoHero['titulo'] ?? '';
    $descripcion = $grupoHero['descripcion'] ?? '';

    $hayContenido = $titulo || $descripcion;
?>

<?php if ($hayContenido): ?>
    <section class="hero">
        <div class="hero-container">
            <?php if( $titulo ): ?>
                <h1 class="heading--64 color--002D72"><?php echo esc_html($titulo); ?></h1>
            <?php endif; ?>
            <?php if( $descripcion ): ?>
                <p class="heading--18 color--263956"><?php echo esc_html($descripcion); ?></p>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>