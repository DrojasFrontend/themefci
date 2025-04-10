document.addEventListener("DOMContentLoaded", function () {
    const publicacionesSwiper = new Swiper(".publicaciones__swiper", {
        slidesPerView: 1.2,
        spaceBetween: 10,
        centeredSlides: false,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            680: {
                slidesPerView: 2,
                spaceBetween: 36,
                centeredSlides: false,
            },
            1200: {
                slidesPerView: 3,
                spaceBetween: 36,
                centeredSlides: false,
            },
            1280: {
                slidesPerView: 3,
                spaceBetween: 36,
                centeredSlides: false,
            },
        },
    });

    // Inicializar el swiper de diario-secundarios con responsive
    let diarioSecundariosSwiper = null;

    function initDiarioSecundariosSwiper() {
        if (window.innerWidth <= 1024) {
            if (!diarioSecundariosSwiper) {
                diarioSecundariosSwiper = new Swiper(".diario-secundarios", {
                    slidesPerView: 1.2,
                    spaceBetween: 10,
                    pagination: {
                        el: "#swiper-pagination-publicaciones",
                        clickable: true,
                    },
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    loop: true,
                });
            }
        } else {
            if (diarioSecundariosSwiper) {
                diarioSecundariosSwiper.destroy(true, true);
                diarioSecundariosSwiper = null;
            }
        }
    }
    initDiarioSecundariosSwiper();

    window.addEventListener("resize", initDiarioSecundariosSwiper);
});

/* Filtro Desktop */

    let specialties = [];
    let filteredSpecialties = [];
    let especialidades = diarioMedicoData.especialidades;
    let profesionales = diarioMedicoData.profesionales;
    let activeFilters = {
        type: null,
        values: []
    };
    const itemsPerLoad = 3;
    let itemsShown = 0;

    document.addEventListener('DOMContentLoaded', () => {
        // Cargar datos iniciales
        specialties = diarioMedicoData.diarioMedico;
        filteredSpecialties = specialties;
        
        // Event listener para el select de tipo de filtro
        document.getElementById('filterTypeSelect').addEventListener('change', function() {
            const filterType = this.value;
            activeFilters.type = filterType;
            activeFilters.values = [];
            renderFilterCheckboxes(filterType);
            document.getElementById('filterCheckboxesContainer').style.display = 'block';
            updateActiveFilters();
        });
        
        // Event listener para el botón de borrar filtros
        document.getElementById('clearFiltersBtn').addEventListener('click', clearAllFilters);
        
        // Event listener para el select de ordenamiento
        document.getElementById('orderSelect').addEventListener('change', function() {
            sortSpecialties(this.value);
        });

        // Renderizar especialidades iniciales
        renderSpecialties(false);
    });
    
    // Función para renderizar los checkboxes de filtro
    // Modificamos la función renderFilterCheckboxes para crear un multiselect dropdown
    function renderFilterCheckboxes(filterType) {
        const container = document.getElementById('filterCheckboxesContainer');
        container.innerHTML = '';
        
        const options = filterType === 'especialidad' ? especialidades : profesionales;
        
        // Crear el elemento select
        const selectElement = document.createElement('select');
        selectElement.id = 'multiSelectFilter';
        selectElement.className = 'select2-multiple';
        selectElement.multiple = true;
        
        // Añadir las opciones al select
        options.forEach(option => {
            const optionElement = document.createElement('option');
            optionElement.value = option.id;
            optionElement.textContent = option.name;
            optionElement.dataset.filterType = filterType;
            selectElement.appendChild(optionElement);
        });
        
        // Añadir el select al contenedor
        container.appendChild(selectElement);
        
        // Inicializar select2 con checkbox personalizado
        $(document).ready(function() {
            $('#multiSelectFilter').select2({
                placeholder: 'Selecciona una o más opciones',
                allowClear: true,
                width: '100%',
                closeOnSelect: false,
                language: {
                    noResults: () => 'No se encontraron resultados'
                },
                // Personalizar el renderizado para mostrar checkboxes
                templateResult: formatOption,
                // Mostrar siempre el placeholder en lugar de las opciones seleccionadas
                templateSelection: formatPlaceholder
            }).on('select2:select', function(e) {
                const optionId = e.params.data.id;
                const optionName = e.params.data.text;
                
                activeFilters.values.push({
                    id: optionId,
                    name: optionName
                });
                
                updateActiveFilters();
                applyFilters();
            }).on('select2:unselect', function(e) {
                const optionId = e.params.data.id;
                
                activeFilters.values = activeFilters.values.filter(filter => filter.id != optionId);
                
                updateActiveFilters();
                applyFilters();
            });
            
            // Transformar el select2 para mostrar como select normal cuando está cerrado
            $('.select2-container--default').addClass('custom-select2');
        });
        
        // Función para formatear las opciones como checkboxes
        function formatOption(option) {
            if (!option.id) return option.text;
            
            // Verificar si está seleccionado
            const isSelected = $('#multiSelectFilter').val()?.includes(option.id);
            
            // Crear el checkbox con estilos
            const $checkbox = $(
                `<div class="select2-option-checkbox">
                    <input type="checkbox" ${isSelected ? 'checked' : ''} id="check-${option.id}" />
                    <label for="check-${option.id}">${option.text}</label>
                </div>`
            );

            // Hacer toda la opción clicable
            $checkbox.css('cursor', 'pointer').on('click', function(e) {
                // Si el clic no fue en el checkbox
                if (!$(e.target).is('input[type="checkbox"]')) {
                    // Evitar la propagación
                    e.stopPropagation();
                    e.preventDefault();
                    
                    // Encontrar el checkbox
                    const checkbox = $(this).find('input[type="checkbox"]');
                    // Cambiar su estado
                    checkbox.prop('checked', !checkbox.prop('checked'));
                    
                    // Simular la selección/deselección en el select2
                    const optionId = $(this).data('option-id');
                    const currentValues = $('#multiSelectFilter').val() || [];
                    
                    if (checkbox.prop('checked')) {
                        $('#multiSelectFilter').val([...currentValues, optionId]).trigger('change');
                    } else {
                        $('#multiSelectFilter').val(currentValues.filter(v => v !== optionId)).trigger('change');
                    }
                    
                    return false;
                }
            });
            
            return $checkbox;
        }
        
        // Función para mostrar siempre el placeholder en el select
        function formatPlaceholder() {
            return 'Selecciona una o más opciones';
        }
    }

function filterCheckboxes(searchTerm) {
    const checkboxItems = document.querySelectorAll('#checkboxesWrap .checkbox-item');
    
    checkboxItems.forEach(item => {
        const itemName = item.dataset.name;
        if (itemName.includes(searchTerm)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
    
    // Mensaje si no hay resultados
    const noResultsMsg = document.getElementById('noCheckboxResults');
    const hasVisibleItems = Array.from(checkboxItems).some(item => item.style.display !== 'none');
    
    if (!hasVisibleItems && searchTerm !== '') {
        if (!noResultsMsg) {
            const msg = document.createElement('div');
            msg.id = 'noCheckboxResults';
            msg.className = 'no-checkbox-results';
            msg.textContent = 'No se encontraron resultados';
            document.getElementById('checkboxesWrap').appendChild(msg);
        }
    } else if (noResultsMsg) {
        noResultsMsg.remove();
    }
}
    
    // Función para actualizar los filtros activos
    function updateActiveFilters() {
        // Ocultar siempre el contenedor original de filtros activos
        const container = document.getElementById('activeFiltersContainer');
        if (container) {
            container.style.display = 'none';
        }
        
        // Actualizar en la sección de resultados
        const resultsContainer = document.querySelector('.diario-medico-container');
        
        // Verificar si ya existe el contenedor de filtros activos en resultados
        let resultsFilterContainer = document.getElementById('resultsActiveFiltersContainer');
        
        if (!resultsFilterContainer) {
            // Si no existe, lo creamos
            resultsFilterContainer = document.createElement('div');
            resultsFilterContainer.id = 'resultsActiveFiltersContainer';
            resultsFilterContainer.className = 'results-active-filters-container';
            
            // Creamos el contenedor para la lista de filtros
            const resultsFilterList = document.createElement('div');
            resultsFilterList.id = 'resultsFiltersList';
            resultsFilterList.className = 'results-filters-list';
            
            // Creamos el botón de borrar
            const resultsClearBtn = document.createElement('button');
            resultsClearBtn.id = 'resultsClearFiltersBtn';
            resultsClearBtn.className = 'clear-filters-btn';
            resultsClearBtn.innerHTML = `
            <span>Borrar filtros</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                <path d="M10.5579 9.00002L15.2829 4.28252C15.4242 4.14129 15.5035 3.94974 15.5035 3.75002C15.5035 3.55029 15.4242 3.35874 15.2829 3.21752C15.1417 3.07629 14.9502 2.99695 14.7504 2.99695C14.5507 2.99695 14.3592 3.07629 14.2179 3.21752L9.50044 7.94252L4.78294 3.21752C4.64171 3.07629 4.45017 2.99695 4.25044 2.99695C4.05072 2.99695 3.85917 3.07629 3.71794 3.21752C3.57671 3.35874 3.49737 3.55029 3.49737 3.75002C3.49737 3.94974 3.57671 4.14129 3.71794 4.28252L8.44294 9.00002L3.71794 13.7175C3.64765 13.7872 3.59185 13.8702 3.55377 13.9616C3.5157 14.053 3.49609 14.151 3.49609 14.25C3.49609 14.349 3.5157 14.4471 3.55377 14.5384C3.59185 14.6298 3.64765 14.7128 3.71794 14.7825C3.78766 14.8528 3.87062 14.9086 3.96201 14.9467C4.0534 14.9848 4.15143 15.0044 4.25044 15.0044C4.34945 15.0044 4.44748 14.9848 4.53888 14.9467C4.63027 14.9086 4.71322 14.8528 4.78294 14.7825L9.50044 10.0575L14.2179 14.7825C14.2877 14.8528 14.3706 14.9086 14.462 14.9467C14.5534 14.9848 14.6514 15.0044 14.7504 15.0044C14.8495 15.0044 14.9475 14.9848 15.0389 14.9467C15.1303 14.9086 15.2132 14.8528 15.2829 14.7825C15.3532 14.7128 15.409 14.6298 15.4471 14.5384C15.4852 14.4471 15.5048 14.349 15.5048 14.25C15.5048 14.151 15.4852 14.053 15.4471 13.9616C15.409 13.8702 15.3532 13.7872 15.2829 13.7175L10.5579 9.00002Z" fill="#263956"/>
            </svg>
            `;
            resultsClearBtn.addEventListener('click', clearAllFilters);
            
            resultsFilterContainer.appendChild(resultsFilterList);
            resultsFilterContainer.appendChild(resultsClearBtn);
            
            // Insertamos antes del contenedor de especialidades
            resultsContainer.insertBefore(resultsFilterContainer, document.getElementById('specialtiesContainer'));
        }
        
        // Obtenemos la lista de filtros en resultados
        const resultsFilterList = document.getElementById('resultsFiltersList');
        resultsFilterList.innerHTML = '';
        
        if (activeFilters.values.length > 0) {
            // Mostrar filtros solo en la sección de resultados
            resultsFilterContainer.style.display = 'flex';
            
            // Renderizar los filtros en la sección de resultados
            activeFilters.values.forEach(filter => {
                const resultsFilterTag = document.createElement('span');
                resultsFilterTag.className = 'filter-tag';
                resultsFilterTag.innerHTML = `${filter.name} <button class="remove-filter" data-id="${filter.id}"><svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
<path d="M10.5579 9.00002L15.2829 4.28252C15.4242 4.14129 15.5035 3.94974 15.5035 3.75002C15.5035 3.55029 15.4242 3.35874 15.2829 3.21752C15.1417 3.07629 14.9502 2.99695 14.7504 2.99695C14.5507 2.99695 14.3592 3.07629 14.2179 3.21752L9.50044 7.94252L4.78294 3.21752C4.64171 3.07629 4.45017 2.99695 4.25044 2.99695C4.05072 2.99695 3.85917 3.07629 3.71794 3.21752C3.57671 3.35874 3.49737 3.55029 3.49737 3.75002C3.49737 3.94974 3.57671 4.14129 3.71794 4.28252L8.44294 9.00002L3.71794 13.7175C3.64765 13.7872 3.59185 13.8702 3.55377 13.9616C3.5157 14.053 3.49609 14.151 3.49609 14.25C3.49609 14.349 3.5157 14.4471 3.55377 14.5384C3.59185 14.6298 3.64765 14.7128 3.71794 14.7825C3.78766 14.8528 3.87062 14.9086 3.96201 14.9467C4.0534 14.9848 4.15143 15.0044 4.25044 15.0044C4.34945 15.0044 4.44748 14.9848 4.53888 14.9467C4.63027 14.9086 4.71322 14.8528 4.78294 14.7825L9.50044 10.0575L14.2179 14.7825C14.2877 14.8528 14.3706 14.9086 14.462 14.9467C14.5534 14.9848 14.6514 15.0044 14.7504 15.0044C14.8495 15.0044 14.9475 14.9848 15.0389 14.9467C15.1303 14.9086 15.2132 14.8528 15.2829 14.7825C15.3532 14.7128 15.409 14.6298 15.4471 14.5384C15.4852 14.4471 15.5048 14.349 15.5048 14.25C15.5048 14.151 15.4852 14.053 15.4471 13.9616C15.409 13.8702 15.3532 13.7872 15.2829 13.7175L10.5579 9.00002Z" fill="#E40046"/>
</svg></button>`;
                resultsFilterList.appendChild(resultsFilterTag);
            });
            
            // Agregar event listeners a los botones de eliminar filtro de manera más robusta
            document.querySelectorAll('.remove-filter').forEach(button => {
                button.addEventListener('click', function() {
                    const filterId = this.getAttribute('data-id');
                    
                    // Desmarcar el checkbox en el select2
                    const checkboxId = `${activeFilters.type}-${filterId}`;
                    const checkbox = document.getElementById(checkboxId);
                    if (checkbox) {
                        checkbox.checked = false;
                    }
                    
                    // También necesitamos actualizar el select2 directamente
                    if ($('#multiSelectFilter').length) {
                        // Obtener los valores actuales
                        const currentValues = $('#multiSelectFilter').val() || [];
                        // Filtrar para quitar el valor
                        const newValues = currentValues.filter(val => val !== filterId);
                        // Establecer los nuevos valores
                        $('#multiSelectFilter').val(newValues).trigger('change');
                    }
                    
                    // Actualizar activeFilters.values
                    activeFilters.values = activeFilters.values.filter(filter => filter.id != filterId);
                    
                    updateActiveFilters();
                    applyFilters();
                });
            });
        } else {
            // Ocultar el contenedor de resultados si no hay filtros activos
            resultsFilterContainer.style.display = 'none';
        }
    }
    
    // Función para aplicar los filtros seleccionados
    function applyFilters() {
        if (activeFilters.values.length === 0) {
            filteredSpecialties = specialties;
        } else {
            filteredSpecialties = specialties.filter(specialty => {
                if (activeFilters.type === 'especialidad') {
                    // Filtrar por categoría
                    // Como category está en formato de cadena HTML, necesitamos extraer los nombres
                    const categoryText = specialty.category;
                    return activeFilters.values.some(filter => {
                        return categoryText.includes(filter.name);
                    });
                } else if (activeFilters.type === 'profesional') {
                    // Filtrar por profesional médico
                    return activeFilters.values.some(filter => {
                        return specialty.specialist && specialty.specialist.includes(filter.name);
                    });
                }
                return true;
            });
        }
        
        console.log('Aplicando filtros:', activeFilters);
        console.log('Resultados filtrados:', filteredSpecialties.length);
        
        renderSpecialties(false);
    }
    
    // Función para limpiar todos los filtros
    function clearAllFilters() {
    // Resetear el selector de tipo de filtro
    document.getElementById('filterTypeSelect').value = '';
    
    // Ocultar los checkboxes
    document.getElementById('filterCheckboxesContainer').style.display = 'none';
    
    // Limpiar select2 si existe
    if ($('#multiSelectFilter').length) {
        $('#multiSelectFilter').val(null).trigger('change');
    }
    
    // Limpiar los filtros activos
    activeFilters.type = null;
    activeFilters.values = [];
    
    // Ocultar filtros en la sección de resultados
    const resultsFilterContainer = document.getElementById('resultsActiveFiltersContainer');
    if (resultsFilterContainer) {
        resultsFilterContainer.style.display = 'none';
    }
    
    // Resetear la búsqueda
    document.getElementById('searchInput').value = '';
    
    // Resetear los filtros por letra
    document.querySelectorAll('.btn-filter').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Mostrar todas las especialidades
    filteredSpecialties = specialties;
    renderSpecialties(false);
}
    
    // Función para renderizar especialidades
    function renderSpecialties(isLoadMore = false) {
        const container = document.getElementById('specialtiesContainer');
    
    // Si no es "cargar más", limpiamos el contenedor
    if (!isLoadMore) {
        container.innerHTML = '';
        itemsShown = 0;
        
        // Verificar si existe el título, si existe lo eliminamos
        const existingTitle = document.getElementById('resultsTitle');
        if (existingTitle) {
            existingTitle.remove();
        }
        
        // Solo mostrar el título si hay filtros activos, búsqueda o alguna letra seleccionada
        const hasActiveFilters = activeFilters.values.length > 0;
        const hasActiveSearch = document.getElementById('searchInput').value.trim() !== '';
        const hasActiveLetter = document.querySelector('.btn-filter.active') !== null;
        
        if (hasActiveFilters || hasActiveSearch || hasActiveLetter) {
            // Crear y agregar el título de resultados
            const resultsTitle = document.createElement('h2');
            resultsTitle.id = 'resultsTitle';
            resultsTitle.className = 'heading--48 color--002D72';
            resultsTitle.textContent = 'Resultados de la búsqueda';
            
            // Insertar el título antes del contenedor de especialidades
            container.parentNode.insertBefore(resultsTitle, container);
        }
    }

    
    if (filteredSpecialties.length === 0) {
        // Eliminar el título si no hay resultados
        const existingTitle = document.getElementById('resultsTitle');
        if (existingTitle) {
            existingTitle.remove();
        }
        
        container.innerHTML = `
            <div class="section-results__container">
                <p class="heading--30 color--002D72">No hay resultados.</p>
                <button id="resetFiltersBtn" class="boton-v2 boton-v2--rojo-rojo">Volver</button>
            </div>
        `;
        
        document.getElementById('resetFiltersBtn').addEventListener('click', resetFilters);
        
        // Agregar clase si no hay resultados
        const loadMoreButton = document.querySelector('.section-load__moreBtn');
        if (loadMoreButton) {
            loadMoreButton.classList.add('no-results');
        }
        return;
    }

    // Calculamos cuántos elementos mostrar en esta carga
    const end = Math.min(itemsShown + itemsPerLoad, filteredSpecialties.length);
    const itemsToRender = filteredSpecialties.slice(itemsShown, end);

    // Añadimos los nuevos elementos
    itemsToRender.forEach(specialty => {
        container.innerHTML += `
            <div class="diario-medico-item">
                <div class="diario-medico-img">
                    <img src="${specialty.image}" alt="${specialty.title}">
                </div>
                <div class="diario-medico-content">
                    <div class="diario-card__tags">
                        <span class="diario-categoria">${specialty.category}</span>
                        <span class="diario-fecha">${specialty.date}</span>
                    </div>
                    <h5 class="heading--24 color--002D72">${specialty.title}</h5>
                    <p class="heading--18 color--263956">${specialty.excerpt}</p>
                    ${specialty.autor_doctor ? `<p class="diario-autor heading--18 color--0C2448">Profesional: <strong>${specialty.autor_doctor}</strong></p>` : ''}
                    <a href="${specialty.link}" class="diario-link"><span class="diario-link__span">Leer publicación</span></a>
                </div>
            </div>
        `;
    });

    // Actualizamos el contador de elementos mostrados
    itemsShown = end;
    
    // Removemos todos los botones "Ver más" existentes
    const existingButtons = document.querySelectorAll('.section-load__moreBtn');
    existingButtons.forEach(button => {
        button.remove();
    });
    
    // Si hay más elementos por mostrar, añadimos el botón "Ver más"
    if (itemsShown < filteredSpecialties.length) {
        const loadMoreButton = document.createElement('div');
        loadMoreButton.className = 'section-load__moreBtn';
        loadMoreButton.innerHTML = `<button id="loadMoreBtn" class="boton-v2 boton-v2--blanco-rojo">Ver más</button>`;
        container.parentNode.appendChild(loadMoreButton);
        
        document.getElementById('loadMoreBtn').addEventListener('click', function() {
            renderSpecialties(true); // Llamamos a renderSpecialties con isLoadMore = true
        });

        // Eliminar clase si hay resultados
        loadMoreButton.classList.remove('no-results');
    }
}

    // Función para buscar enfermedades en input
    function filterSpecialties() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const normalizeText = (text) => {
            return text
                .normalize('NFD')               
                .replace(/[\u0300-\u036f]/g, '')
                .toLowerCase();
        };
        
        // Primero aplicamos los filtros avanzados si están activos
        let baseResults = specialties;
        if (activeFilters.type && activeFilters.values.length > 0) {
            baseResults = specialties.filter(specialty => {
                if (activeFilters.type === 'especialidad') {
                    const categoryText = specialty.category;
                    return activeFilters.values.some(filter => {
                        return categoryText.includes(filter.name);
                    });
                } else if (activeFilters.type === 'profesional') {
                    return activeFilters.values.some(filter => {
                        return specialty.specialist && specialty.specialist.includes(filter.name);
                    });
                }
                return true;
            });
        }
        
        // Luego aplicamos el filtro de búsqueda
        if (query.trim() === '') {
            filteredSpecialties = baseResults;
        } else {
            filteredSpecialties = baseResults.filter(specialty => {
                const cleanTitle = normalizeText(
                    specialty.title.replace(/^[¿\-\(\)\.,:;\s]+/, '')
                );
                const cleanQuery = normalizeText(query);
                return cleanTitle.includes(cleanQuery);
            });
        }
        
        renderSpecialties(false);
    }

    // Función para filtrar enfermedades por inicial
    function filterByLetter(letter) {
        document.querySelectorAll('.btn-filter').forEach(button => {
            button.classList.remove('active');
        });

        const activeButton = document.querySelector(`.btn-filter[onclick="filterByLetter('${letter}')"]`);
        if (activeButton) {
            activeButton.classList.add('active');
        }
        
        // Primero aplicamos los filtros avanzados si están activos
        let baseResults = specialties;
        if (activeFilters.type && activeFilters.values.length > 0) {
            baseResults = specialties.filter(specialty => {
                if (activeFilters.type === 'especialidad') {
                    const categoryText = specialty.category;
                    return activeFilters.values.some(filter => {
                        return categoryText.includes(filter.name);
                    });
                } else if (activeFilters.type === 'profesional') {
                    return activeFilters.values.some(filter => {
                        return specialty.specialist && specialty.specialist.includes(filter.name);
                    });
                }
                return true;
            });
        }

        if (letter === 'all') {
            filteredSpecialties = baseResults;
        } else {
            filteredSpecialties = baseResults.filter(specialty => {
                const cleanTitle = specialty.title.replace(/^[¿\-\(\)\.,:;\s]+/, '');
                return cleanTitle.toLowerCase().startsWith(letter.toLowerCase());
            });
        }
        renderSpecialties(false);
    }

    // Función para ordenar enfermedades por fecha
    function sortSpecialties(order) {
        if (order === 'reciente') {
            // Ordenar de más reciente a más antiguo
            filteredSpecialties.sort((a, b) => new Date(b.date) - new Date(a.date));
        } else if (order === 'antiguo') {
            // Ordenar de más antiguo a más reciente
            filteredSpecialties.sort((a, b) => new Date(a.date) - new Date(b.date));
        }
        
        renderSpecialties(false);
    }

    // Función para restablecer todos los filtros
    function resetFilters() {
    // Restablecer el input de búsqueda
    document.getElementById('searchInput').value = '';
    
    // Restablecer los botones de filtrado por letra
    document.querySelectorAll('.btn-filter').forEach(button => {
        button.classList.remove('active');
    });
    
    // Resetear el select de tipo de filtro
    document.getElementById('filterTypeSelect').value = '';
    
    // Ocultar los checkboxes
    document.getElementById('filterCheckboxesContainer').style.display = 'none';
    
    // Limpiar los filtros activos
    activeFilters.type = null;
    activeFilters.values = [];
    
    // Ocultar filtros en la sección de resultados
    const resultsFilterContainer = document.getElementById('resultsActiveFiltersContainer');
    if (resultsFilterContainer) {
        resultsFilterContainer.style.display = 'none';
    }
    
    // Eliminar el título de resultados
    const resultsTitle = document.getElementById('resultsTitle');
    if (resultsTitle) {
        resultsTitle.remove();
    }
    
    // Resetear la búsqueda
    document.getElementById('searchInput').value = '';
    
    // Resetear los filtros por letra
    document.querySelectorAll('.btn-filter').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Activar el botón "Todos" si existe
    const allButton = document.querySelector('.btn-filter[onclick="filterByLetter(\'all\')"]');
    if (allButton) {
        allButton.classList.add('active');
    }
    
    // Restablecer el select de ordenamiento si existe
    const orderSelect = document.getElementById('orderSelect');
    if (orderSelect) {
        orderSelect.value = ''; // O el valor predeterminado que desees
    }
    
    // Restablecer las especialidades filtradas
    filteredSpecialties = specialties;
    
    // Renderizar nuevamente
    renderSpecialties(false);
}

/* End Filtro Desktop */

/* Filtro Mobile */
let mobileActiveFilters = {
    specialty: [],
    professional: []
};

// Función para inicializar los filtros móviles
function initMobileFilters() {
    // Cargar datos
    const specialtySelect = document.getElementById('specialtySelect');
    const professionalSelect = document.getElementById('professionalSelect');
    
    // Cargar opciones de especialidades
    especialidades.forEach(specialty => {
        const option = document.createElement('option');
        option.value = specialty.id;
        option.textContent = specialty.name;
        specialtySelect.appendChild(option);
    });
    
    // Cargar opciones de profesionales
    profesionales.forEach(professional => {
        const option = document.createElement('option');
        option.value = professional.id;
        option.textContent = professional.name;
        professionalSelect.appendChild(option);
    });
    
    // Inicializar select2 para los selects móviles
    // Inicializar select2 para los selects móviles
    $(document).ready(function() {
        $('#specialtySelect, #professionalSelect').select2({
            dropdownParent: $('.mobile-filters-content'),
            closeOnSelect: false,
            placeholder: 'Selecciona una o más opciones',
            language: {
                noResults: () => 'No se encontraron resultados'
            },
            // Personalizar el renderizado para mostrar checkboxes
            templateResult: formatMobileOption,
            // Mostrar siempre el placeholder
            templateSelection: formatMobilePlaceholder
        }).on('select2:select select2:unselect', updateMobileActiveFilters);
    });

    // Función para formatear las opciones como checkboxes
    function formatMobileOption(option) {
        if (!option.id) return option.text;
        
        // Verificar si está seleccionado
        const select = $(option.element).parent('select')[0];
        const isSelected = $(select).val()?.includes(option.id);
        
        // Crear el checkbox con estilos
        const $checkbox = $(
            `<div class="select2-option-checkbox" data-option-id="${option.id}">
                <input type="checkbox" ${isSelected ? 'checked' : ''} id="mobile-check-${option.id}" />
                <label for="mobile-check-${option.id}">${option.text}</label>
            </div>`
        );
        
        // Hacer toda la opción clicable
        $checkbox.css('cursor', 'pointer').on('click', function(e) {
            // Si el clic no fue en el checkbox
            if (!$(e.target).is('input[type="checkbox"]')) {
                // Evitar la propagación
                e.stopPropagation();
                e.preventDefault();
                
                // Encontrar el checkbox
                const checkbox = $(this).find('input[type="checkbox"]');
                // Cambiar su estado
                checkbox.prop('checked', !checkbox.prop('checked'));
                
                // Simular la selección/deselección en el select2
                const optionId = $(this).data('option-id');
                const select = $(option.element).parent('select');
                const currentValues = select.val() || [];
                
                if (checkbox.prop('checked')) {
                    select.val([...currentValues, optionId]).trigger('change');
                } else {
                    select.val(currentValues.filter(v => v !== optionId)).trigger('change');
                }
                
                return false;
            }
        });
        
        return $checkbox;
    }

    // Función para mostrar siempre el placeholder en el select
    function formatMobilePlaceholder() {
        return '';
    }
    
    // Event listeners
    document.getElementById('openMobileFilters').addEventListener('click', openMobileFiltersPanel);
    document.getElementById('backToResults').addEventListener('click', closeMobileFiltersPanel);
    document.getElementById('applyMobileFilters').addEventListener('click', applyMobileFilters);
    document.getElementById('cancelMobileFilters').addEventListener('click', cancelMobileFilters);
    document.getElementById('mobileClearFilters').addEventListener('click', clearMobileFilters);
    document.getElementById('applyMobileFilters').disabled = true;
}

// Función para limpiar todos los filtros móviles
function clearMobileFilters() {
    // Restablecer selects
    $('#specialtySelect, #professionalSelect').val(null).trigger('change');
    
    // Limpiar filtros activos
    mobileActiveFilters.specialty = [];
    mobileActiveFilters.professional = [];
    
    // Actualizar UI
    updateMobileActiveFilters();
    
    // Limpiar también los filtros globales
    activeFilters.type = null;
    activeFilters.values = [];
    
    // Actualizar los resultados globales
    filteredSpecialties = specialties; // Restablecer a todas las especialidades
    renderSpecialties(false); // Volver a renderizar los resultados
    
    // También ocultar el contenedor de filtros activos en los resultados
    const resultsFilterContainer = document.getElementById('resultsActiveFiltersContainer');
    if (resultsFilterContainer) {
        resultsFilterContainer.style.display = 'none';
    }
    
    // Eliminar el título de resultados si existe
    const resultsTitle = document.getElementById('resultsTitle');
    if (resultsTitle) {
        resultsTitle.remove();
    }
}

// Función para abrir el panel de filtros
function openMobileFiltersPanel() {
    document.getElementById('mobileFiltersPanel').classList.add('open');
    document.body.style.overflow = 'hidden'; // Prevenir scroll
    
    // Sincronizar los filtros activos globales con los filtros móviles
    syncActiveFiltersToMobile();
}

// Nueva función para sincronizar filtros activos globales con móviles
function syncActiveFiltersToMobile() {
    // Limpiar selecciones actuales
    $('#specialtySelect, #professionalSelect').val(null).trigger('change');
    
    // Restablecer filtros móviles
    mobileActiveFilters.specialty = [];
    mobileActiveFilters.professional = [];
    
    // Si hay filtros activos globales, sincronizarlos
    if (activeFilters.type && activeFilters.values.length > 0) {
        if (activeFilters.type === 'especialidad') {
            // Seleccionar las opciones correspondientes en el select de especialidades
            const values = activeFilters.values.map(filter => filter.id);
            $('#specialtySelect').val(values).trigger('change');
            
            // Actualizar mobileActiveFilters
            mobileActiveFilters.specialty = [...activeFilters.values];
        } else if (activeFilters.type === 'profesional') {
            // Seleccionar las opciones correspondientes en el select de profesionales
            const values = activeFilters.values.map(filter => filter.id);
            $('#professionalSelect').val(values).trigger('change');
            
            // Actualizar mobileActiveFilters
            mobileActiveFilters.professional = [...activeFilters.values];
        }
    }
    
    // Actualizar la UI de filtros activos
    updateMobileActiveFilters();
}

// Función para cerrar el panel de filtros
function closeMobileFiltersPanel() {
    document.getElementById('mobileFiltersPanel').classList.remove('open');
    document.body.style.overflow = ''; // Restaurar scroll
}

// Función para actualizar los filtros activos
function updateMobileActiveFilters() {
    const specialtySelect = document.getElementById('specialtySelect');
    const professionalSelect = document.getElementById('professionalSelect');
    const activeFiltersContainer = document.getElementById('mobileActiveFilters');
    const clearFiltersContainer = document.getElementById('mobileClearFiltersContainer');
    
    // Limpiar filtros activos
    mobileActiveFilters.specialty = [];
    mobileActiveFilters.professional = [];
    
    // Recopilar filtros de especialidad
    Array.from(specialtySelect.selectedOptions).forEach(option => {
        mobileActiveFilters.specialty.push({
            id: option.value,
            name: option.textContent
        });
    });
    
    // Recopilar filtros de profesional
    Array.from(professionalSelect.selectedOptions).forEach(option => {
        mobileActiveFilters.professional.push({
            id: option.value,
            name: option.textContent
        });
    });
    
    // Actualizar UI de filtros activos
    activeFiltersContainer.innerHTML = '';
    
    // Añadir etiquetas para especialidades
    mobileActiveFilters.specialty.forEach(filter => {
        const tag = document.createElement('span');
        tag.className = 'mobile-filter-tag';
        tag.dataset.type = 'specialty';
        tag.dataset.id = filter.id;
        tag.innerHTML = `${filter.name} <button class="remove-mobile-filter" data-type="specialty" data-id="${filter.id}"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
        <path d="M10.0579 9.00014L14.7829 4.28264C14.9242 4.14141 15.0035 3.94987 15.0035 3.75014C15.0035 3.55041 14.9242 3.35887 14.7829 3.21764C14.6417 3.07641 14.4502 2.99707 14.2504 2.99707C14.0507 2.99707 13.8592 3.07641 13.7179 3.21764L9.00044 7.94264L4.28294 3.21764C4.14171 3.07641 3.95017 2.99707 3.75044 2.99707C3.55072 2.99707 3.35917 3.07641 3.21794 3.21764C3.07671 3.35887 2.99737 3.55041 2.99737 3.75014C2.99737 3.94987 3.07671 4.14141 3.21794 4.28264L7.94294 9.00014L3.21794 13.7176C3.14765 13.7874 3.09185 13.8703 3.05377 13.9617C3.0157 14.0531 2.99609 14.1511 2.99609 14.2501C2.99609 14.3491 3.0157 14.4472 3.05377 14.5386C3.09185 14.63 3.14765 14.7129 3.21794 14.7826C3.28766 14.8529 3.37062 14.9087 3.46201 14.9468C3.5534 14.9849 3.65143 15.0045 3.75044 15.0045C3.84945 15.0045 3.94748 14.9849 4.03888 14.9468C4.13027 14.9087 4.21322 14.8529 4.28294 14.7826L9.00044 10.0576L13.7179 14.7826C13.7877 14.8529 13.8706 14.9087 13.962 14.9468C14.0534 14.9849 14.1514 15.0045 14.2504 15.0045C14.3495 15.0045 14.4475 14.9849 14.5389 14.9468C14.6303 14.9087 14.7132 14.8529 14.7829 14.7826C14.8532 14.7129 14.909 14.63 14.9471 14.5386C14.9852 14.4472 15.0048 14.3491 15.0048 14.2501C15.0048 14.1511 14.9852 14.0531 14.9471 13.9617C14.909 13.8703 14.8532 13.7874 14.7829 13.7176L10.0579 9.00014Z" fill="#E40046"/>
        </svg></button>`;
        activeFiltersContainer.appendChild(tag);
    });
    
    // Añadir etiquetas para profesionales
    mobileActiveFilters.professional.forEach(filter => {
        const tag = document.createElement('span');
        tag.className = 'mobile-filter-tag';
        tag.dataset.type = 'professional';
        tag.dataset.id = filter.id;
        tag.innerHTML = `${filter.name} <button class="remove-mobile-filter" data-type="professional" data-id="${filter.id}"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
        <path d="M10.0579 9.00014L14.7829 4.28264C14.9242 4.14141 15.0035 3.94987 15.0035 3.75014C15.0035 3.55041 14.9242 3.35887 14.7829 3.21764C14.6417 3.07641 14.4502 2.99707 14.2504 2.99707C14.0507 2.99707 13.8592 3.07641 13.7179 3.21764L9.00044 7.94264L4.28294 3.21764C4.14171 3.07641 3.95017 2.99707 3.75044 2.99707C3.55072 2.99707 3.35917 3.07641 3.21794 3.21764C3.07671 3.35887 2.99737 3.55041 2.99737 3.75014C2.99737 3.94987 3.07671 4.14141 3.21794 4.28264L7.94294 9.00014L3.21794 13.7176C3.14765 13.7874 3.09185 13.8703 3.05377 13.9617C3.0157 14.0531 2.99609 14.1511 2.99609 14.2501C2.99609 14.3491 3.0157 14.4472 3.05377 14.5386C3.09185 14.63 3.14765 14.7129 3.21794 14.7826C3.28766 14.8529 3.37062 14.9087 3.46201 14.9468C3.5534 14.9849 3.65143 15.0045 3.75044 15.0045C3.84945 15.0045 3.94748 14.9849 4.03888 14.9468C4.13027 14.9087 4.21322 14.8529 4.28294 14.7826L9.00044 10.0576L13.7179 14.7826C13.7877 14.8529 13.8706 14.9087 13.962 14.9468C14.0534 14.9849 14.1514 15.0045 14.2504 15.0045C14.3495 15.0045 14.4475 14.9849 14.5389 14.9468C14.6303 14.9087 14.7132 14.8529 14.7829 14.7826C14.8532 14.7129 14.909 14.63 14.9471 14.5386C14.9852 14.4472 15.0048 14.3491 15.0048 14.2501C15.0048 14.1511 14.9852 14.0531 14.9471 13.9617C14.909 13.8703 14.8532 13.7874 14.7829 13.7176L10.0579 9.00014Z" fill="#E40046"/>
        </svg></button>`;
        activeFiltersContainer.appendChild(tag);
    });
    
    // Añadir listeners para remover filtros
    document.querySelectorAll('.remove-mobile-filter').forEach(button => {
        button.addEventListener('click', removeMobileFilter);
    });
    
    // Verificar si hay filtros activos
    const hasActiveFilters = mobileActiveFilters.specialty.length > 0 || mobileActiveFilters.professional.length > 0;
    
    // Mostrar/ocultar el botón de borrar filtros
    clearFiltersContainer.style.display = hasActiveFilters ? 'block' : 'none';
    
    // Habilitar/deshabilitar botón de aplicar
    document.getElementById('applyMobileFilters').disabled = !hasActiveFilters;
}

// Función para remover un filtro activo
function removeMobileFilter(e) {
    const type = e.currentTarget.dataset.type;
    const id = e.currentTarget.dataset.id;
    
    // Remover del select
    if (type === 'specialty') {
        const option = document.querySelector(`#specialtySelect option[value="${id}"]`);
        if (option) option.selected = false;
    } else if (type === 'professional') {
        const option = document.querySelector(`#professionalSelect option[value="${id}"]`);
        if (option) option.selected = false;
    }
    
    // Actualizar select2
    $(`#${type}Select`).trigger('change');
    
    // Actualizar filtros activos
    updateMobileActiveFilters();
}

// Función para aplicar los filtros
function applyMobileFilters() {
    // Combinar los filtros de especialidad y profesional
    activeFilters.values = [];
    
    if (mobileActiveFilters.specialty.length > 0) {
        activeFilters.type = 'especialidad';
        activeFilters.values = mobileActiveFilters.specialty;
    } else if (mobileActiveFilters.professional.length > 0) {
        activeFilters.type = 'profesional';
        activeFilters.values = mobileActiveFilters.professional;
    }
    
    // Aplicar filtros
    applyFilters();
    
    // Actualizar UI
    updateActiveFilters();
    
    // Cerrar panel
    closeMobileFiltersPanel();
}

// Función para cancelar los filtros
function cancelMobileFilters() {
    // Restablecer selects
    $('#specialtySelect, #professionalSelect').val(null).trigger('change');
    
    // Limpiar filtros activos
    mobileActiveFilters.specialty = [];
    mobileActiveFilters.professional = [];
    
    // Actualizar UI
    updateMobileActiveFilters();
    
    // Cerrar panel
    closeMobileFiltersPanel();
}

// Inicializar al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar filtros móviles
    initMobileFilters();
});