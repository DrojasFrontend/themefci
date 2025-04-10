document.addEventListener("DOMContentLoaded", function () {
	const toggleButton = document.getElementById("js-toggle-button");
	const menuMobile = document.getElementById("js-menu-mobile");

	toggleButton.addEventListener("click", function () {
		this.classList.toggle("is-active");
		menuMobile.classList.toggle("is-active");
		document.body.classList.toggle("is-active");
	});
});

/* Menu Escritorio */
document.addEventListener("DOMContentLoaded", function () {
	var menuItems = document.querySelectorAll(".has-submenu");

	menuItems.forEach(function (menuItem) {
		var subMenu = findSubMenu(menuItem);

		menuItem.addEventListener("mouseover", function () {
			if (subMenu) {
				menuItem.classList.add("is-hover");
			}
		});

		menuItem.addEventListener("mouseleave", function () {
			if (subMenu) {
				menuItem.classList.remove("is-hover");
			}
		});

		if (subMenu) {
			subMenu.addEventListener("mouseover", function () {
				menuItem.classList.add("is-hover");
			});

			subMenu.addEventListener("mouseleave", function () {
				menuItem.classList.remove("is-hover");
			});
		}
	});

	function findSubMenu(element) {
		var sibling = element.nextElementSibling;
		while (sibling) {
			if (sibling.tagName.toLowerCase() === "div") {
				var potentialSubMenu = sibling.querySelector(
					".sub-menu-nivel-0-wrapper, .sub-menu-nivel-1-wrapper, .sub-menu-nivel-2-wrapper, .sub-menu-nivel-3-wrapper"
				);
				if (potentialSubMenu) {
					return potentialSubMenu;
				}
			}
			sibling = sibling.nextElementSibling;
		}
		return null;
	}
});

/* Menu Mobile */
document.addEventListener("DOMContentLoaded", function () {
	const hasSubmenu = document.querySelectorAll(".has-submenu-mobile");
	const allSubmenus = document.querySelectorAll(
		".sub-menu-mobile-nivel-0, .sub-menu-mobile-nivel-1, .sub-menu-mobile-nivel-2, .sub-menu-mobile-nivel-3"
	);

	function closeAllSubmenus() {
		allSubmenus.forEach(function (submenu) {
			submenu.classList.remove("is-open");
		});
	}

	function handleSubmenuClick(event) {
		event.preventDefault();
		const submenu = this.nextElementSibling;

		if (submenu.classList.contains("is-open")) {
			submenu.classList.remove("is-open");
		} else {
			closeAllSubmenus();
			submenu.classList.add("is-open");
		}
	}

	hasSubmenu.forEach(function (item) {
		item.addEventListener("click", handleSubmenuClick);
	});

	const submenuTitles = document.querySelectorAll(
		".sub-menu-mobile-nivel-0-title, .sub-menu-mobile-nivel-1-title, .sub-menu-mobile-nivel-2-title, .sub-menu-mobile-nivel-3-title"
	);

	function handleTitleClick() {
		const parentSubMenu = this.parentElement.parentElement;
		const grandParentSubMenu = parentSubMenu.parentElement.parentElement;

		parentSubMenu.classList.remove("is-open");
		grandParentSubMenu.classList.add("is-open");
	}

	submenuTitles.forEach(function (title) {
		title.addEventListener("click", handleTitleClick);
	});
});

jQuery(document).ready(function ($) {
	// Manejar clic en una categoría

	$(".post-item").slice(0, 6).show();
	$("[data-vermas]").click(function (e) {
		e.preventDefault();

		$(".post-item:hidden").slice(0, 3).fadeIn("slow");

		if ($(".post-item:hidden").length == 0) {
			$("[data-vermas]").fadeOut("slow");
		}
	});

	$(document).on("click", ".category-link", function (e) {
		e.preventDefault();
		var catID = $(this).data("cat-id");
		getPostsByCategory(catID);

		$(".category-link").removeClass("active");
		// Agregar la clase 'active' al enlace de categoría seleccionado
		$(".category-link[data-cat-id='" + catID + "']").addClass("active");
	});

	// Obtener la primera categoría al cargar la página
	$.ajax({
		url: lm_params.ajaxurl,
		type: "POST",
		data: {
			action: "get_first_category_id",
		},
		success: function (response) {
			var firstCatID = parseInt(response);
			getPostsByCategory(firstCatID);

			// Agregar la clase 'active' al enlace de la primera categoría
			$(".category-link").removeClass("active");
			$(".category-link[data-cat-id='" + firstCatID + "']").addClass("active");
		},
	});

	$.ajax({
		url: lm_params.ajaxurl,
		type: "POST",
		data: {
			action: "get_blog_follows_categories",
		},
		success: function (response) {
			$(".categories").html(response);
		},
	});

	// Función para obtener posts por categoría
	function getPostsByCategory(catID) {
		$.ajax({
			url: lm_params.ajaxurl,
			type: "POST",
			data: {
				action: "get_posts_by_category",
				catID: catID,
			},
			success: function (response) {
				// Mostrar posts utilizando Slick
				$(".posts").html(response);
				$blogFellowSlider = $(".blogFellowSlider");
				blogFellowSliderSettings = {
					slidesToShow: 4,
					slidesToScroll: 1,
					dots: true,
					arrows: true,
					infinite: false,
					responsive: [
						{
							breakpoint: 1024,
							settings: {
								slidesToShow: 2,
								arrows: false,
							},
						},
					],
				};
				$blogFellowSlider.slick(blogFellowSliderSettings);
			},
		});
	}

	$("#search-input").on("input", function () {
		var searchTerm = $(this).val();
		searchPosts(searchTerm);
	});

	// Función para obtener posts por titulo
	function searchPosts(searchTerm) {
		$.ajax({
			url: lm_params.ajaxurl,
			type: "POST",
			data: {
				action: "search_blog_fellows",
				searchTerm: searchTerm,
			},
			success: function (response) {
				$(".posts").html(response);

				// Mostrar elementos iniciales
				$(".post-item").slice(0, 3).show();
				$("[data-vermas]").click(function (e) {
					e.preventDefault();
					$(".post-item:hidden").slice(0, 3).fadeIn("slow");
					if ($(".post-item:hidden").length == 0) {
						$("[data-vermas]").fadeOut("slow");
					}
				});
				// $blogFellowSlider = $(".blogFellowSlider");
				// blogFellowSliderSettings = {
				//   slidesToShow: 4,
				//   slidesToScroll: 1,
				//   dots: true,
				//   arrows: true,
				//   infinite: false,
				//   responsive: [
				//     {
				//       breakpoint: 1024,
				//       settings: {
				//         slidesToShow: 2,
				//         arrows: false,
				//       }
				//     },
				//   ]
				// };
				// $blogFellowSlider.slick(blogFellowSliderSettings);
			},
		});
	}

	var $sliderFullWidth = $(".sliderFullWidth");
	var $progressBar = $(".progress");
	var $progressBarLabel = $(".slider__label");
	var $skeletonLoader = $(".skeleton-loader");

	$progressBar.css("background-size", "20% 100%").attr("aria-valuenow", 20);
	$progressBarLabel.text("20% completed");

	$sliderFullWidth.on(
		"beforeChange",
		function (event, slick, currentSlide, nextSlide) {
			var calc;
			if (nextSlide === 0) {
				calc = 20; // Mantiene 20% en el primer slide
			} else {
				calc = (nextSlide / (slick.slideCount - 1)) * 100;
			}
			$progressBar
				.css("background-size", calc + "% 100%")
				.attr("aria-valuenow", calc);
			$progressBarLabel.text(calc + "% completed");
		}
	);

	$sliderFullWidth.on("init", function () {
		$skeletonLoader.hide();
	});

	$(window).on("load", function () {
		$sliderFullWidth.slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			speed: 400,
			dots: true,
			arrows: false,
			adaptiveHeight: true,
		});
	});

	let $sliderContainer = $("#sliderEventos");

	if ($sliderContainer.length > 0) {
		// Inicializa el carrusel de la información del evento
		let $slickEventoInfo = $sliderContainer
			.find(".slickEventoInfo")
			.slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				dots: true,
				arrows: true,
				fade: false,
				asNavFor: $sliderContainer.find(".slickEventoDia"),
				infinite: false,
				responsive: [
					{
						breakpoint: 768, // A partir de 768px y menos (dispositivos móviles)
						settings: {
							arrows: false,
						},
					},
				],
			})
			.on("setPosition", function () {
				setEqualHeight($(this));
			});

		// Inicializa el carrusel de los días con ajuste para móviles
		var $slickEventoDia = $sliderContainer.find(".slickEventoDia").slick({
			slidesToShow: 6, // Muestra 6 días en escritorio
			slidesToScroll: 1,
			asNavFor: $sliderContainer.find(".slickEventoInfo"),
			dots: false,
			centerMode: true,
			focusOnSelect: true,
			infinite: false,
			variableWidth: false, // Elementos con ancho fijo

			// Configuración responsive
			responsive: [
				{
					breakpoint: 768, // A partir de 768px y menos (dispositivos móviles)
					settings: {
						slidesToShow: 2, // Muestra 2 días en dispositivos móviles
						centerMode: false, // Desactiva el centrado en móviles
						variableWidth: false, // Mantén el ancho fijo
						arrows: false,
					},
				},
			],
		});

		// Función que ajusta el slider a la posición 0 si el evento más cercano es el primero
		function ajustarPosicionSlider(closestEventIndex) {
			if (closestEventIndex === 0) {
				// Para escritorio y dispositivos móviles
				$slickEventoDia.slick("slickSetOption", "centerMode", false, true);
				$slickEventoInfo.slick("slickSetOption", "centerMode", false, true);

				// Reiniciar sliders a la posición inicial
				$slickEventoDia.slick("slickGoTo", 0);
				$slickEventoInfo.slick("slickGoTo", 0);
			} else {
				// Si no es el primer evento, lo navega normalmente
				$slickEventoInfo.slick("slickGoTo", closestEventIndex);
			}
		}

		// Verificar si el evento más cercano es el primero
		if (closestEventIndex !== -1) {
			ajustarPosicionSlider(closestEventIndex);
		}

		// Detectar versión móvil y aplicar el ajuste para la versión mobile también
		var mobileQuery = window.matchMedia("(max-width: 768px)"); // Ajusta el tamaño para dispositivos móviles

		// Si es móvil, aplicamos la misma lógica
		if (mobileQuery.matches) {
			ajustarPosicionSlider(closestEventIndex);
		}

		// Escuchar cambios en el tamaño de la pantalla y ajustar cuando se pasa a móvil o desktop
		mobileQuery.addEventListener("change", function (e) {
			if (e.matches) {
				// Si entra en el tamaño móvil
				ajustarPosicionSlider(closestEventIndex);
			}
		});
	}

	const $slickTargetas = $("#sliderAtencionInvestigacion");
	const slickTargetasSettings = {
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: true,
		arrows: true,
		infinite: false,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					arrows: false,
				},
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
				},
			},
		],
	};
	if ($slickTargetas.length > 0) {
		$slickTargetas.slick(slickTargetasSettings).on("setPosition", function () {
			setEqualHeight($(this));
		});
	}

	$window = $(window);
	const $slickArticulos = $(".slickArticulos");
	const slickArticulosSettings = {
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: true,
		arrows: false,
		infinite: false,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 2,
					arrows: false,
				},
			},
			{
				breakpoint: 780,
				settings: {
					slidesToShow: 1,
					arrows: false,
				},
			},
		],
	};
	if ($slickArticulos.length > 0) {
		$slickArticulos.slick(slickArticulosSettings);
	}

	$slickNoticias = $(".slickNoticias");
	slickNoticiasSettings = {
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: true,
		arrows: true,
		infinite: false,
		adaptiveHeight: false,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 2,
					arrows: false,
				},
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					arrows: false,
				},
			},
		],
	};
	$slickNoticias.slick(slickNoticiasSettings).on("setPosition", function () {
		setEqualHeight($(this));
	});

	$slickProfesionalesUrg = $(".slickProfesionalesUrg");
	slickProfesionalesUrgSettings = {
		slidesToShow: 4,
		slidesToScroll: 1,
		dots: true,
		arrows: true,
		infinite: false,
		adaptiveHeight: false,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 2,
					arrows: false,
				},
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					arrows: false,
				},
			},
		],
	};
	if ($slickProfesionalesUrg.length > 0) {
		$slickProfesionalesUrg.slick(slickProfesionalesUrgSettings);
	}

	$slickServiciosHome = $(".slickServiciosHome");
	slickServiciosHomeSettings = {
		slidesToShow: 6,
		slidesToScroll: 1,
		dots: true,
		arrows: true,
		infinite: false,
		adaptiveHeight: false,
		responsive: [
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 4,
					arrows: false,
				},
			},
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 3,
					arrows: false,
				},
			},
			{
				breakpoint: 680,
				settings: {
					/*slidesToShow: 1,
					arrows: false,*/
					slidesToShow: 2, // 2 columnas
					slidesToScroll: 2,
					rows: 3, // 3 filas, total 6 imágenes visibles
					arrows: false,
				},
			},
		],
	};
	$slickServiciosHome.slick(slickServiciosHomeSettings);

	$(".tab-links a").on("click", function (e) {
		var currentAttrValue = $(this).attr("href");

		$(".tab").removeClass("active");
		$(currentAttrValue).addClass("active");

		$(".tab-links li").removeClass("active");
		$(this).parent("li").addClass("active");
		$(".slickMultimedia").slick("setPosition");
		e.preventDefault();
	});

	var $slickMultimedia = $(".slickMultimedia");

	// Configuración inicial del carousel
	var slickMultimediaSettings = {
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: true,
		arrows: false,
		infinite: false,
		adaptiveHeight: false,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
				},
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				},
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
			{
				breakpoint: 9999,
				settings: "unslick",
			},
		],
	};

	function initSlick() {
		if (window.innerWidth < 1024) {
			$slickMultimedia.slick(slickMultimediaSettings);
		} else {
			$slickMultimedia.slick("unslick");
		}
	}

	function setEqualHeight(slider) {
		let maxHeight = 0;
		slider.find(".slick-slide").each(function () {
			let slideHeight = $(this).outerHeight();
			if (slideHeight > maxHeight) {
				maxHeight = slideHeight;
			}
		});
		slider.find(".slick-slide .seccion__alto").css("height", maxHeight + "px");
	}

	initSlick();
	$(window).on("resize", function () {
		initSlick();
	});

	$(".slickPersonalizado article").closest("div").addClass("seccion__alto");

	jQuery("#open-contact").on("click", function () {
		jQuery(this).parent().toggleClass("active");
	});

	// Buacador Blog Fellow
	function realizarBusqueda() {
		let author = $("#author_name").val();
		let order = $("#order").val();
		let search = $('input[name="s"]').val();

		$.ajax({
			url: lm_params.ajaxurl,
			type: "POST",
			data: {
				action: "filter_posts",
				author_name: author,
				order: order,
				s: search,
			},
			beforeSend: function () {
				$("#filtros-loader").fadeIn();
				$(".seccionArticulos section").fadeOut(); // Esconde artículos antes de cargar
			},
			success: function (response) {
				$(".seccionArticulos").html(response).fadeIn();
				$("#filtros-loader").fadeOut();
				actualizarFiltros();
			},
			error: function (xhr, status, error) {
				console.error("Error en la solicitud AJAX:", status, error);
				$("#filtros-loader").fadeOut();
			},
		});
	}

	function actualizarFiltros() {
		let filtrosAplicados = "";

		// Obtener valores de los filtros
		let author = $("#author_name").val();
		let order = $("#order").val();
		let search = $('input[name="s"]').val();

		// Construir los filtros seleccionados como HTML
		if (author) {
			filtrosAplicados += `<span class="filtro-chip">${author} <button type="button" class="eliminar-filtro" data-filtro="author"></button></span>`;
		}

		if (order === "last_week") {
			filtrosAplicados += `<span class="filtro-chip">Última semana <button type="button" class="eliminar-filtro" data-filtro="order"></button></span>`;
		} else if (order === "ASC") {
			filtrosAplicados += `<span class="filtro-chip">Orden: Ascendente <button type="button" class="eliminar-filtro" data-filtro="order"></button></span>`;
		} else if (order === "DESC") {
			filtrosAplicados += `<span class="filtro-chip">Orden: Descendente <button type="button" class="eliminar-filtro" data-filtro="order"></button></span>`;
		}

		if (search) {
			filtrosAplicados += `<span class="filtro-chip">Buscar: ${search} <button type="button" class="eliminar-filtro" data-filtro="search"></button></span>`;
		}

		// Mostrar los filtros en el contenedor
		$(".filtros-aplicados").html(filtrosAplicados);

		// Mover el botón de borrar filtros después de los filtros aplicados
		$(".borrar-filtros").appendTo(".filtros-aplicados-contenedor");

		// Mostrar u ocultar el botón de borrar filtros en función de si hay filtros
		if (filtrosAplicados !== "") {
			$(".borrar-filtros").show();
			$(".seccionArticulosBuscados").fadeOut();
		} else {
			$(".borrar-filtros").hide();
			$(".seccionArticulosBuscados").fadeIn();
		}

		// Evento para eliminar filtros
		$(".eliminar-filtro").on("click", function () {
			let filtro = $(this).data("filtro");
			if (filtro === "author") {
				$("#author_name").val("");
			} else if (filtro === "order") {
				$("#order").val("");
			} else if (filtro === "search") {
				$('input[name="s"]').val("");
			}
			// Disparar la búsqueda nuevamente con los filtros actualizados
			realizarBusqueda();
		});
	}

	// Disparar la búsqueda cuando se cambian los filtros o se escribe en el input
	/*let searchTimeout;
	$('input[name="s"]').on("keyup", function () {
		clearTimeout(searchTimeout);
		searchTimeout = setTimeout(realizarBusqueda, 300);
	});

	$("#author_name, #order").on("change", function () {
		realizarBusqueda();
	});*/

	// Botón de resetear filtros
	$('button[type="reset"]').click(function () {
		window.location.reload();
	});

	//Slider Podcast Fellows

	const $slickEventoPodcatsFellows = $(".slickEventoPodcatsFellows");
	const slickEventoPodcatsFellowsSettings = {
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: true,
		arrows: true,
		infinite: false,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 2,
					arrows: true,
				},
			},
			{
				breakpoint: 780,
				settings: {
					slidesToShow: 1,
					arrows: true,
				},
			},
		],
	};
	if ($slickEventoPodcatsFellows.length > 0) {
		$slickEventoPodcatsFellows.slick(slickEventoPodcatsFellowsSettings);
	}

	//Slider Eventos Fellows

	const $slickEventoFellows = $(".slickEventoFellows");
	const slickEventoFellowsSettings = {
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: true,
		arrows: true,
		infinite: false,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 2,
					arrows: true,
				},
			},
			{
				breakpoint: 780,
				settings: {
					slidesToShow: 1,
					arrows: true,
				},
			},
		],
	};

	if ($slickEventoFellows.length > 0) {
		$slickEventoFellows.slick(slickEventoFellowsSettings);

		// Función para actualizar visibilidad de los dots
		function updateVisibleDots(slick, currentSlide) {
			const $dots = slick.$dots.find("li");
			const totalDots = $dots.length;
			const maxVisibleDots = 5;

			// Calcular rango de indices visibles
			let start = Math.max(0, currentSlide - Math.floor(maxVisibleDots / 2));
			let end = start + maxVisibleDots;

			// Ajustar rango si excede los límites
			if (end > totalDots) {
				end = totalDots;
				start = Math.max(0, end - maxVisibleDots);
			}

			// Remover clases y agregar a los dots visibles
			$dots.removeClass("visible-dot");
			$dots.slice(start, end).addClass("visible-dot");
		}

		// Evento `init` para inicializar los dots
		$slickEventoFellows.on("init", function (event, slick) {
			updateVisibleDots(slick, 0); // Inicial con el primer slide
		});

		// Evento `afterChange` para actualizar los dots al deslizar
		$slickEventoFellows.on(
			"afterChange",
			function (event, slick, currentSlide) {
				updateVisibleDots(slick, currentSlide);
			}
		);
	}
});

// Script de seguimiento con auto-diagnóstico para Google Analytics
// Coloca este script al final de tu página antes de </body>

(function() {
  // Función para registrar en la consola con formato para facilitar la identificación
  function log(message, data) {
    console.log('%c EVENT TRACKER: ' + message, 'background: #f8f9fa; color: #28a745; padding: 3px; border-radius: 3px;', data || '');
  }
  
  // Función para registrar errores
  function logError(message, error) {
    console.error('%c EVENT TRACKER ERROR: ' + message, 'background: #f8d7da; color: #721c24; padding: 3px; border-radius: 3px;', error || '');
  }

  // Función para enviar eventos a Google Analytics con detección automática
  function sendEvent(category, action, label, value) {
    try {
      // Intentar primero con gtag (GA4)
      if (typeof gtag === 'function') {
        gtag('event', action, {
          'event_category': category,
          'event_label': label,
          'value': value
        });
        log('Evento enviado a GA4 (gtag)', { category, action, label, value });
        return true;
      }
      
      // Intentar con dataLayer (GTM)
      else if (typeof dataLayer !== 'undefined') {
        dataLayer.push({
          'event': action,
          'eventCategory': category,
          'eventAction': action,
          'eventLabel': label,
          'eventValue': value
        });
        log('Evento enviado a GTM (dataLayer)', { category, action, label, value });
        return true;
      }
      
      // Intentar con ga (Universal Analytics)
      else if (typeof ga === 'function') {
        ga('send', 'event', category, action, label, value);
        log('Evento enviado a UA (ga)', { category, action, label, value });
        return true;
      }
      
      // Intentar con _gaq (Analytics antiguo)
      else if (typeof _gaq !== 'undefined') {
        _gaq.push(['_trackEvent', category, action, label, value]);
        log('Evento enviado a GA antiguo (_gaq)', { category, action, label, value });
        return true;
      }
      
      // Si no hay ningún método de Analytics disponible
      else {
        logError('No se detectó ninguna implementación de Google Analytics');
        log('Evento que se habría enviado', { category, action, label, value });
        return false;
      }
    } catch (e) {
      logError('Error al enviar evento', e);
      return false;
    }
  }

  // Esperamos a que el DOM esté completamente cargado
  function iniciarTracking() {
    log('Inicializando sistema de seguimiento...');
    
    // DIAGNÓSTICO: Verificar qué implementación de GA está disponible
    log('Diagnóstico de implementaciones de Google Analytics:', {
      'GA4 (gtag)': typeof gtag === 'function',
      'GTM (dataLayer)': typeof dataLayer !== 'undefined',
      'UA (ga)': typeof ga === 'function',
      'GA Antiguo (_gaq)': typeof _gaq !== 'undefined'
    });

    // DIAGNÓSTICO: Verificar elementos rastreables
    const enlaces = document.querySelectorAll('a');
    const formularios = document.querySelectorAll('form');
    const botones = document.querySelectorAll('button, input[type="button"], input[type="submit"]');
    
    log('Elementos rastreables encontrados:', {
      'Enlaces': enlaces.length,
      'Formularios': formularios.length,
      'Botones': botones.length
    });

    // IMPLEMENTACIÓN: Rastreo de clics en enlaces
    try {
      enlaces.forEach(function(link) {
        link.addEventListener('click', function(e) {
          const href = this.getAttribute('href');
          const linkText = this.innerText || this.textContent || '[sin texto]';
          
          sendEvent('Enlaces', 'click', linkText, href);
        });
      });
      log('Rastreo de enlaces configurado correctamente');
    } catch (e) {
      logError('Error al configurar rastreo de enlaces', e);
    }

    // IMPLEMENTACIÓN: Rastreo de envíos de formularios
    try {
      formularios.forEach(function(form) {
        form.addEventListener('submit', function(e) {
          const formId = this.id || this.getAttribute('name') || 'formulario-sin-id';
          
          sendEvent('Formularios', 'submit', formId);
        });
      });
      log('Rastreo de formularios configurado correctamente');
    } catch (e) {
      logError('Error al configurar rastreo de formularios', e);
    }

    // IMPLEMENTACIÓN: Rastreo de clics en botones
    try {
      botones.forEach(function(button) {
        button.addEventListener('click', function(e) {
          const buttonText = this.innerText || this.value || this.id || 'botón-sin-texto';
          
          sendEvent('Botones', 'click', buttonText);
        });
      });
      log('Rastreo de botones configurado correctamente');
    } catch (e) {
      logError('Error al configurar rastreo de botones', e);
    }

    log('Sistema de seguimiento inicializado y listo para usar');
  }

  // Función para esperar a que el DOM esté listo
  function esperarDOM() {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', iniciarTracking);
      log('Esperando a que el DOM termine de cargar...');
    } else {
      iniciarTracking();
    }
  }

  // Función para hacer un diagnóstico manual de la página
  window.diagnosticoTracking = function() {
    log('------------- DIAGNÓSTICO MANUAL -------------');
    
    // Verificar implementaciones de GA
    log('Implementaciones de Google Analytics:', {
      'GA4 (gtag)': typeof gtag === 'function',
      'GTM (dataLayer)': typeof dataLayer !== 'undefined',
      'UA (ga)': typeof ga === 'function',
      'GA Antiguo (_gaq)': typeof _gaq !== 'undefined'
    });
    
    // Análisis de elementos
    const enlaces = document.querySelectorAll('a');
    const formularios = document.querySelectorAll('form');
    const botones = document.querySelectorAll('button, input[type="button"], input[type="submit"]');
    
    log('Elementos rastreables:', {
      'Enlaces': enlaces.length,
      'Formularios': formularios.length,
      'Botones': botones.length
    });
    
    // Mostrar ejemplos de enlaces
    if (enlaces.length > 0) {
      log('Primeros 3 enlaces:');
      for (let i = 0; i < Math.min(3, enlaces.length); i++) {
        console.log(`${i+1}. "${enlaces[i].innerText.trim() || '[Sin texto]'}" -> ${enlaces[i].href}`);
      }
    }
    
    // Verificar si podemos hacer una prueba
    log('Realiza un clic en algún elemento de la página para probar si los eventos se registran correctamente');
    
    return {
      implementacionesGA: {
        gtag: typeof gtag === 'function',
        dataLayer: typeof dataLayer !== 'undefined',
        ga: typeof ga === 'function',
        _gaq: typeof _gaq !== 'undefined'
      },
      elementosRastreables: {
        enlaces: enlaces.length,
        formularios: formularios.length,
        botones: botones.length
      },
      navegador: navigator.userAgent,
      url: window.location.href
    };
  };

  // Evento de prueba manual
  window.probarEvento = function(categoria, accion, etiqueta, valor) {
    log('Enviando evento de prueba manual');
    return sendEvent(
      categoria || 'Prueba', 
      accion || 'test', 
      etiqueta || 'evento-manual', 
      valor || 'test-value'
    );
  };

  // Iniciar rastreo
  esperarDOM();
  
  log('Script de seguimiento instalado correctamente. Usa window.diagnosticoTracking() para ejecutar un diagnóstico manual.');
})();