<section class="section-hero__mobile">
    <div class="mobile-filter-container">

        <p class="subheading color--002D72 uppercase">BIENVENIDOS A NUESTRO</p>
        <h1 class="heading--46 color--002D72">Diario médico</h1>

        <div class="btn-filter__container">
            <p class="heading--18 color--0C2448">Selecciona la <strong>letra inicial de la enfermedad</strong> que estás buscando.</p>
            <div class="btn-filter__content">
                <?php
                    $letters = range('A', 'Z');
                    foreach ($letters as $letter) {
                        echo '<button class="btn-filter" onclick="filterByLetter(\'' . $letter . '\')">' . $letter . '</button>';
                    }
                ?>
            </div>
        </div>

        <div class="btn-mobile__filter">
            <p class="heading--18 color--0C2448">Filtra tu contenido <strong>por especialidad</strong> o <strong>profesional médico</strong>.</p>
            <button id="openMobileFilters" class="mobile-filter-button">
                Filtrar búsqueda
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <g clip-path="url(#clip0_8985_18058)">
                    <path d="M13.9995 24C13.7831 24 13.5726 23.9298 13.3995 23.8L9.39949 20.8C9.2753 20.7069 9.17449 20.5861 9.10507 20.4472C9.03564 20.3084 8.99949 20.1552 8.99949 20V14.38L1.98349 6.487C1.48521 5.92488 1.15987 5.23082 1.04657 4.48823C0.933273 3.74565 1.03684 2.98615 1.34482 2.30101C1.65279 1.61588 2.15208 1.03426 2.78267 0.626066C3.41326 0.217873 4.14832 0.000474419 4.89949 0L19.0995 0C19.8506 0.000881051 20.5855 0.218639 21.2158 0.627107C21.8461 1.03557 22.3451 1.61737 22.6528 2.30259C22.9604 2.9878 23.0637 3.74727 22.9501 4.48975C22.8365 5.23222 22.5109 5.9261 22.0125 6.488L14.9995 14.38V23C14.9995 23.2652 14.8941 23.5196 14.7066 23.7071C14.5191 23.8946 14.2647 24 13.9995 24ZM10.9995 19.5L12.9995 21V14C12.9997 13.7552 13.0897 13.5189 13.2525 13.336L20.5205 5.159C20.7628 4.88508 20.921 4.54704 20.9759 4.18545C21.0309 3.82387 20.9803 3.4541 20.8303 3.12056C20.6802 2.78701 20.4371 2.50386 20.1301 2.30509C19.8231 2.10632 19.4652 2.00038 19.0995 2H4.89949C4.53394 2.00055 4.17631 2.10655 3.8695 2.30527C3.56268 2.50399 3.3197 2.78699 3.1697 3.12035C3.0197 3.45371 2.96905 3.82326 3.02382 4.18468C3.07859 4.5461 3.23646 4.88405 3.47849 5.158L10.7475 13.336C10.9099 13.519 10.9996 13.7553 10.9995 14V19.5Z" fill="#E40046"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_8985_18058">
                    <rect width="24" height="24" fill="white"/>
                    </clipPath>
                    </defs>
                </svg>
            </button>
        </div>
        
        <div id="mobileFiltersPanel" class="mobile-filters-panel">
            <div class="mobile-filter-header">
                <button id="backToResults" class="back-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M15.6276 5.39284C15.8661 5.64167 16 5.97828 16 6.32913C16 6.67999 15.8661 7.01659 15.6276 7.26542L11.0939 12.0332L15.6276 16.7346C15.8661 16.9834 16 17.32 16 17.6709C16 18.0217 15.8661 18.3583 15.6276 18.6072C15.5085 18.7316 15.3669 18.8304 15.2108 18.8979C15.0547 18.9653 14.8874 19 14.7183 19C14.5492 19 14.3818 18.9653 14.2258 18.8979C14.0697 18.8304 13.928 18.7316 13.809 18.6072L8.37883 12.9761C8.25879 12.8527 8.16351 12.7058 8.09849 12.5439C8.03348 12.3821 8 12.2085 8 12.0332C8 11.8579 8.03348 11.6843 8.09849 11.5225C8.16351 11.3606 8.25879 11.2137 8.37883 11.0903L13.809 5.39284C13.928 5.26836 14.0697 5.16956 14.2258 5.10214C14.3818 5.03472 14.5492 5 14.7183 5C14.8874 5 15.0547 5.03472 15.2108 5.10214C15.3669 5.16956 15.5085 5.26836 15.6276 5.39284Z" fill="white"/>
                </svg>
                    Regresar
                </button>
            </div>

            <div class="mobile-filters-content">
                <!-- Filtro por especialidad -->
                <div class="mobile-filter-section">
                    <h5 class="heading--20__mobile">Filtrar contenido por especialidad</h5>
                    <div class="mobile-select-container">
                        <select id="specialtySelect" class="mobile-select" multiple>
                        </select>
                    </div>
                </div>
                
                <!-- Filtro por profesional -->
                <div class="mobile-filter-section">
                    <h5 class="heading--20__mobile">Filtrar contenido por profesional médico</h5>
                    <div class="mobile-select-container">
                        <select id="professionalSelect" class="mobile-select" multiple>
                        </select>
                    </div>
                </div>
                
                <!-- Contenedor para los filtros activos -->
                <div id="mobileActiveFilters" class="mobile-active-filters">
                </div>
                <div id="mobileClearFiltersContainer" class="mobile-clear-filters-container" style="display: none;">
                    <button id="mobileClearFilters" class="mobile-clear-filters-button">
                        <span>Borrar filtros</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <path d="M10.0579 9.00014L14.7829 4.28264C14.9242 4.14141 15.0035 3.94987 15.0035 3.75014C15.0035 3.55041 14.9242 3.35887 14.7829 3.21764C14.6417 3.07641 14.4502 2.99707 14.2504 2.99707C14.0507 2.99707 13.8592 3.07641 13.7179 3.21764L9.00044 7.94264L4.28294 3.21764C4.14171 3.07641 3.95017 2.99707 3.75044 2.99707C3.55072 2.99707 3.35917 3.07641 3.21794 3.21764C3.07671 3.35887 2.99737 3.55041 2.99737 3.75014C2.99737 3.94987 3.07671 4.14141 3.21794 4.28264L7.94294 9.00014L3.21794 13.7176C3.14765 13.7874 3.09185 13.8703 3.05377 13.9617C3.0157 14.0531 2.99609 14.1511 2.99609 14.2501C2.99609 14.3491 3.0157 14.4472 3.05377 14.5386C3.09185 14.63 3.14765 14.7129 3.21794 14.7826C3.28766 14.8529 3.37062 14.9087 3.46201 14.9468C3.5534 14.9849 3.65143 15.0045 3.75044 15.0045C3.84945 15.0045 3.94748 14.9849 4.03888 14.9468C4.13027 14.9087 4.21322 14.8529 4.28294 14.7826L9.00044 10.0576L13.7179 14.7826C13.7877 14.8529 13.8706 14.9087 13.962 14.9468C14.0534 14.9849 14.1514 15.0045 14.2504 15.0045C14.3495 15.0045 14.4475 14.9849 14.5389 14.9468C14.6303 14.9087 14.7132 14.8529 14.7829 14.7826C14.8532 14.7129 14.909 14.63 14.9471 14.5386C14.9852 14.4472 15.0048 14.3491 15.0048 14.2501C15.0048 14.1511 14.9852 14.0531 14.9471 13.9617C14.909 13.8703 14.8532 13.7874 14.7829 13.7176L10.0579 9.00014Z" fill="#263956"/>
                        </svg>
                    </button>
                </div>
                
                <!-- Botones de acción -->
                <div class="mobile-filter-actions">
                    <button id="applyMobileFilters" class="apply-filters-button">Aplicar filtros</button>
                    <button id="cancelMobileFilters" class="cancel-button">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</section>