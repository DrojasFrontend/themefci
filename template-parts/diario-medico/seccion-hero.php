<section class="section-hero__diariomedico">
    <div class="section-hero__container">
        <div class="section-hero__content">
            <div class="col-md-6">
                <p class="subheading color--002D72 uppercase">BIENVENIDOS A NUESTRO</p>
                <h1 class="heading--46 color--002D72">Diario médico</h1>
                <p class="diario-medico__description heading--18 color--0C2448">Filtra tu contenido <strong>por especialidad</strong> o <strong>profesional médico</strong>.</p>
                <div class="mb-4 position-relative">
                    <div class="filter-select-container">
                        <select id="filterTypeSelect" class="filter-select">
                            <option value="" selected disabled>Selecciona una opción</option>
                            <option value="profesional">Profesional médico</option>
                            <option value="especialidad">Especialidad</option>
                        </select>
                    </div>
                    
                    <!-- Contenedor para los checkboxes de filtro -->
                    <div id="filterCheckboxesContainer" class="filter-checkboxes-container" style="display: none;">
                    </div>
                    
                    <!-- Contenedor para los filtros activos -->
                    <div id="activeFiltersContainer" class="active-filters-container" style="display: none;">
                        <div class="active-filters-list" id="activeFiltersList"></div>
                        <button id="clearFiltersBtn" class="clear-filters-btn">Borrar filtros</button>
                    </div>
                </div>
            </div>

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
        </div>
    </div>
</section>

<section class="section-input__search">
    <div class="section-input__container">
        <div class="search__input">
            <input type="text" id="searchInput" class="input-text" placeholder="¿Qué estás buscando el día de hoy?" onkeyup="filterSpecialties()">
            <svg class="search-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M21.7104 20.29L18.0004 16.61C19.4405 14.8144 20.1379 12.5353 19.9492 10.2413C19.7605 7.94733 18.7001 5.81281 16.9859 4.27667C15.2718 2.74053 13.0342 1.91954 10.7333 1.9825C8.43243 2.04546 6.24311 2.98759 4.61553 4.61517C2.98795 6.24275 2.04582 8.43207 1.98286 10.7329C1.9199 13.0338 2.7409 15.2714 4.27704 16.9855C5.81318 18.6997 7.94769 19.7601 10.2417 19.9488C12.5357 20.1375 14.8148 19.4401 16.6104 18L20.2904 21.68C20.3834 21.7738 20.494 21.8482 20.6158 21.8989C20.7377 21.9497 20.8684 21.9758 21.0004 21.9758C21.1324 21.9758 21.2631 21.9497 21.385 21.8989C21.5068 21.8482 21.6174 21.7738 21.7104 21.68C21.8906 21.4936 21.9914 21.2444 21.9914 20.985C21.9914 20.7257 21.8906 20.4765 21.7104 20.29ZM11.0004 18C9.61592 18 8.26255 17.5895 7.1114 16.8203C5.96026 16.0511 5.06305 14.9579 4.53324 13.6788C4.00342 12.3997 3.8648 10.9923 4.1349 9.63439C4.40499 8.27653 5.07168 7.02925 6.05065 6.05028C7.02961 5.07131 8.27689 4.40463 9.63476 4.13453C10.9926 3.86443 12.4001 4.00306 13.6792 4.53287C14.9583 5.06268 16.0515 5.95989 16.8207 7.11103C17.5899 8.26218 18.0004 9.61556 18.0004 11C18.0004 12.8565 17.2629 14.637 15.9501 15.9498C14.6374 17.2625 12.8569 18 11.0004 18Z" fill="#E40046"/>
            </svg>
        </div>
        <div class="select-container">
            <div class="icon">
            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M21.6431 5.14286C21.6431 5.77524 21.1327 6.28571 20.5003 6.28571H4.50028C3.8679 6.28571 3.35742 5.77524 3.35742 5.14286C3.35742 4.51048 3.8679 4 4.50028 4H20.5003C21.1327 4 21.6431 4.51048 21.6431 5.14286ZM8.3098 17.7143H4.50028C3.8679 17.7143 3.35742 18.2248 3.35742 18.8571C3.35742 19.4895 3.8679 20 4.50028 20H8.3098C8.94218 20 9.45266 19.4895 9.45266 18.8571C9.45266 18.2248 8.94218 17.7143 8.3098 17.7143ZM14.405 10.8571H4.50028C3.8679 10.8571 3.35742 11.3676 3.35742 12C3.35742 12.6324 3.8679 13.1429 4.50028 13.1429H14.405C15.0374 13.1429 15.5479 12.6324 15.5479 12C15.5479 11.3676 15.0374 10.8571 14.405 10.8571Z" fill="#E40046"/>
            </svg>
            </div>
            <select id="orderSelect">
                <option value="" selected disabled>Ordenar por</option>
                <option value="reciente">Más reciente</option>
                <option value="antiguo">Más antiguo</option>
            </select>
        </div>
    </div>
</section>