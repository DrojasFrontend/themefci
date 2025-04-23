<section class="customFormularioAsociacionUsuarios pt-84 pb-84 px-24 d-none" data-seccion-formulario>
    <div class="customContainer px-0 pb-84">
        <div class="col-12 col-lg-8 px-0 m-auto">
            <div class="row">
                <div class="col-12 col-lg-5">
                    <div class="d-flex align-items-center h-100">
                        <!-- Barra de progreso -->
                        <div class="step-progress-bar">
                            <div class="progress-fill"></div>
                            <div class="step active" data-step="1">
                                <img src="http://lacardio.local/wp-content/uploads/2025/04/paso-1.svg" alt="">
                            </div>
                            <div class="step" data-step="2">
                                <img src="http://lacardio.local/wp-content/uploads/2025/04/paso-2.svg" alt="">
                            </div>
                            <div class="step" data-step="3">
                                <img src="http://lacardio.local/wp-content/uploads/2025/04/paso-3.svg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-7">
                    <?php echo do_shortcode('[contact-form-7 id="c1741ab" title="Inscripción a la Asociación de Usuarios"]'); ?>
                </div>
            </div>
        </div>
        <div class="d-lg-none pt-48">
            <button type="button" class="customModal__close customButton customButton-white w-100">
                Salir del formulario
                <img src="http://lacardio.local/wp-content/uploads/2025/04/icono-salir.svg" alt="" title="icono salir">
            </button>
        </div>
    </div>
    <!-- Añadimos el cargador de transición -->
    <div class="step-loader">
        <div class="loader-spinner"></div>
        <div class="loader-text">Cargando paso 1 de 3...</div>
    </div>
</section>
