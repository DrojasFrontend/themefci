<?php
    $grupoQueEs = get_field('grupo_que_es');
    $imagenQueEs = $grupoQueEs['imagen'] ?? '';
    $tituloQueEs = $grupoQueEs['titulo'] ?? '';
    $descripcionQueEs = $grupoQueEs['descripcion'] ?? '';
    $grupoSintomas = get_field('grupo_sintomas');
    $imagenSintomas = $grupoSintomas['imagen'] ?? '';
    $tituloSintomas = $grupoSintomas['titulo'] ?? '';
    $descripcionSintomas = $grupoSintomas['descripcion'] ?? '';
    $grupoDiagnostico = get_field('grupo_diagnostico');
    $imagenDiagnostico = $grupoDiagnostico['imagen'] ?? '';
    $tituloDiagnostico = $grupoDiagnostico['titulo'] ?? '';
    $descripcionDiagnostico = $grupoDiagnostico['descripcion'] ?? '';
    $grupoTratamiento = get_field('grupo_tratamiento');
    $imagenTratamiento = $grupoTratamiento['imagen'] ?? '';
    $tituloTratamiento = $grupoTratamiento['titulo'] ?? '';
    $descripcionTratamiento = $grupoTratamiento['descripcion'] ?? '';
?>

<section id="nav-button__diario" class="section-contenido__button">
    <div class="section-nav__container">
        <nav class="diario-nav">
            <?php if( $tituloQueEs ): ?>
                <a href="#que-es" class="nav-diario__contenido"><?php echo esc_html($tituloQueEs); ?></a>
            <?php endif; ?>
            <?php if( $tituloSintomas ): ?>
                <a href="#sintomas" class="nav-diario__contenido"><?php echo esc_html($tituloSintomas); ?></a>
            <?php endif; ?>
            <?php if( $tituloDiagnostico ): ?>
                <a href="#diagnostico" class="nav-diario__contenido"><?php echo esc_html($tituloDiagnostico); ?></a>
            <?php endif; ?>
            <?php if( $tituloTratamiento ): ?>
                <a href="#tratamiento" class="nav-diario__contenido"><?php echo esc_html($tituloTratamiento); ?></a>
            <?php endif; ?>
        </nav>
    </div>
</section>

<div class="diario-contenido__single">
    <!-- Columna izquierda: Contenido -->
    <div class="diario-main">
		 <?php
        while ( have_posts() ) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
        <section id="que-es" class="diario-section">
            <?php if ($imagenQueEs) : ?>
                <img src="<?php echo esc_url($imagenQueEs['url']); ?>" alt="<?php echo esc_attr($imagenQueEs['alt']); ?>" class="img-content">
            <?php endif; ?>
            <?php if( $descripcionQueEs ): ?>
                <div class="heading--18 color--263956"><?php echo $descripcionQueEs; ?></div>
            <?php endif; ?>
        </section>

        <section id="sintomas" class="diario-section">
            <?php if( $tituloSintomas ): ?>
                <h3 class="heading--36 color--002D72"><?php echo esc_html($tituloSintomas); ?></h3>
            <?php endif; ?>
            <?php if( $descripcionSintomas ): ?>
                <div class="content heading--18 color--263956"><?php echo $descripcionSintomas; ?></div>
            <?php endif; ?>
        </section>

        <section id="diagnostico" class="diario-section">
            <?php if( $tituloDiagnostico ): ?>
                <h3 class="heading--36 color--002D72"><?php echo esc_html($tituloDiagnostico); ?></h3>
            <?php endif; ?>
            <?php if( $descripcionDiagnostico ): ?>
                <div class="content heading--18 color--263956"><?php echo $descripcionDiagnostico; ?></div>
            <?php endif; ?>
        </section>

        <section id="tratamiento" class="diario-section">
            <?php if( $tituloTratamiento ): ?>
                <h3 class="heading--36 color--002D72"><?php echo esc_html($tituloTratamiento); ?></h3>
            <?php endif; ?>
            <?php if( $descripcionTratamiento ): ?>
                <div class="content heading--18 color--263956"><?php echo $descripcionTratamiento; ?></div>
            <?php endif; ?>
        </section>

        <div class="btn-content__up">
            <a href="#nav-button__diario" class="btn-content__diario">Volver arriba <span><svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
            <path d="M5.89284 15.6276C6.14167 15.8661 6.47828 16 6.82913 16C7.17999 16 7.51659 15.8661 7.76542 15.6276L12.5332 11.0939L17.2346 15.6276C17.4834 15.8661 17.82 16 18.1709 16C18.5217 16 18.8583 15.8661 19.1072 15.6276C19.2316 15.5085 19.3304 15.3669 19.3979 15.2108C19.4653 15.0547 19.5 14.8874 19.5 14.7183C19.5 14.5492 19.4653 14.3818 19.3979 14.2258C19.3304 14.0697 19.2316 13.928 19.1072 13.809L13.4761 8.37883C13.3527 8.25879 13.2058 8.16351 13.0439 8.09849C12.8821 8.03347 12.7085 8 12.5332 8C12.3579 8 12.1843 8.03347 12.0225 8.09849C11.8606 8.16351 11.7137 8.25879 11.5903 8.37883L5.89284 13.809C5.76837 13.928 5.66956 14.0697 5.60214 14.2258C5.53472 14.3818 5.5 14.5492 5.5 14.7183C5.5 14.8874 5.53472 15.0547 5.60214 15.2108C5.66956 15.3669 5.76836 15.5085 5.89284 15.6276Z" fill="#E40046"/>
            </svg></span></a>
        </div>
        <?php echo get_template_part('template-parts/diario-medico/content/social-buttons'); ?>
    </div>

    <!-- Columna derecha: Sidebar -->
    <?php echo get_template_part('template-parts/diario-medico/content/sidebar-single'); ?>
</div>