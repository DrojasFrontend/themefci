jQuery(document).ready(function ($) {

  /* Clickeable */
  $('.clickeable').on('click', function () {
    const enlace = $(this).find('a');
    if (enlace.length) {
      enlace[0].click();
    }
  }).css('cursor', 'pointer');

  /* Tabs */
  $('.tab').click(function () {
    $('.tab').removeClass('active');
    $('.tab-content').removeClass('active');

    $(this).addClass('active');

    var tabId = $(this).attr('id');
    var contentId = tabId.replace('tab', 'content');
    $('#' + contentId).addClass('active');
  });

  /* Banner slider */
  const swiperBanner = new Swiper('.swiperBanner', {
    slidesPerView: 1,
    spaceBetween: 0,
    pagination: {
      el: '.swiper-pagination-banner',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next-banner',
      prevEl: '.swiper-button-prev-banner',
      clickable: true,
    },
  });

  /* Swiper tarjetas grandes */
  const swiperTarjetasGrandes = new Swiper('.swiperTarjetasGrandes', {
    slidesPerView: 1.1,
    spaceBetween: 18,
    pagination: {
      el: '.swiper-pagination-tarjeta',
      clickable: true,
    },
    breakpoints: {
      992: {
        slidesPerView: 2,
        allowTouchMove: false,
        spaceBetween: 24,
      }
    }
  });

  const swiperAlianzas = new Swiper('.swiperAlianzas', {
    slidesPerView: 1.1,
    spaceBetween: 18,
    speed: 500,
    loop: true,
    pagination: {
      el: '.swiper-pagination-alianza',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
      clickable: true,
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
        allowTouchMove: false,
        spaceBetween: 18,
      },
      992: {
        slidesPerView: 3,
        allowTouchMove: false,
        spaceBetween: 18,
      },
      1024: {
        slidesPerView: 4,
        allowTouchMove: false,
        spaceBetween: 18,
      },
      1200: {
        slidesPerView: 6,
        allowTouchMove: false,
        spaceBetween: 18,
      },
      1440: {
        slidesPerView: 8,
        allowTouchMove: false,
        spaceBetween: 18,
      }
    }
  });

  /* Tabs con scroll automático */
  $('#customTabs button').on('click', function () {
    const $button = $(this);
    setTimeout(function () {
      $button[0].scrollIntoView({
        behavior: 'smooth',
        block: 'nearest',
        inline: 'center'
      });
    }, 50);
  });

  /* Modal de contacto */
  $('a[href="#modal-formulario"]').on('click', function (e) {
    e.preventDefault();
    $('[data-modal-formulario]').fadeIn().removeClass('d-none');
    $('body').addClass('overflow-hidden');
  })

  $('a[href="#mostrar-formulario"]').on('click', function (e) {
    e.preventDefault();
    $('[data-seccion-inicial]').slideUp();
    $('[data-seccion-formulario]').fadeIn().removeClass('d-none');
    $('body').addClass('overflow-hidden');
  })

  $('[data-modal-formulario-salir]').on('click', function (e) {
    $('[data-modal-formulario]').fadeOut();
    $('body').removeClass('overflow-hidden');
  })

  /* Formulario de asociación de usuarios */
  if (!$(".step-progress-bar .progress-fill").length) {
    $(".step-progress-bar").prepend('<div class="progress-fill"></div>');
  }

  $(".step").each(function () {
    var stepNum = $(this).data("step");
    var labelText = "";

    switch (stepNum) {
      case 1:
        labelText = "Datos personales";
        break;
      case 2:
        labelText = "Datos de contacto";
        break;
      case 3:
        labelText = "Finalización";
        break;
      default:
        labelText = "Paso " + stepNum;
    }

    if (!$(this).find('.step-label').length) {
      $(this).append('<div class="step-label">' + labelText + '</div>');
    }
  });

  updateProgressBar(1);

  $(".form-step").not(".active").hide();

  scrollActiveStepIntoView();

  $(".next-step").click(function () {
    var currentStep = $(this).closest(".form-step");
    var nextStepNum = $(this).data("next");
    var nextStep = $("#formulario-" + nextStepNum);

    var isValid = validateStep(currentStep);

    if (isValid) {
      showLoader(nextStepNum);

      setTimeout(function () {
        currentStep.removeClass("active").hide();
        nextStep.addClass("active").show();

        $(".step").removeClass("active");
        $(".step[data-step='" + nextStepNum + "']").addClass("active");
        $(".step[data-step='" + nextStepNum + "']").prevAll(".step").addClass("completed");

        updateProgressBar(nextStepNum);

        scrollActiveStepIntoView();

        hideLoader();
      }, 800);
    }
  });

  $(".wpcf7-form button:contains('Regresar'), .wpcf7-form button:has(img[src*='left-arrow'])").click(function () {
    var currentStepNum = $(this).closest(".form-step").data("step") ||
      $(".step.active").data("step");

    if (!currentStepNum) {
      currentStepNum = 2;
    }

    var prevStepNum = currentStepNum - 1;
    if (prevStepNum < 1) prevStepNum = 1;

    var currentStep = $(this).closest(".form-step");
    var prevStep = $("#formulario-" + prevStepNum);

    $(this).addClass("prev-step").attr("data-prev", prevStepNum);

    showLoader(prevStepNum);

    setTimeout(function () {
      if (currentStep.length) {
        currentStep.removeClass("active").hide();
      } else {
        $(".form-step.active").removeClass("active").hide();
      }

      if (prevStep.length) {
        prevStep.addClass("active").show();
      } else {
        $("#formulario-1").addClass("active").show();
      }

      $(".step").removeClass("active");
      $(".step[data-step='" + prevStepNum + "']").addClass("active");
      $(".step[data-step='" + prevStepNum + "']").nextAll(".step").removeClass("completed");

      updateProgressBar(prevStepNum);

      scrollActiveStepIntoView();

      hideLoader();
    }, 800);
  });

  $(window).resize(function () {
    var currentStep = $(".step.active").data("step") || 1;
    updateProgressBar(currentStep);
    scrollActiveStepIntoView();
  });

  function showLoader(stepNum) {
    var totalSteps = $(".step").length;
    $(".loader-text").text("Cargando paso " + stepNum + " de " + totalSteps + "...");
    $(".step-loader").css("display", "flex");
  }

  function hideLoader() {
    $(".step-loader").css("display", "none");
  }

  function updateProgressBar(currentStep) {
    var totalSteps = $(".step").length;
    var progressPercentage;

    switch (currentStep) {
      case 1:
        progressPercentage = 0;
        break;
      case 2:
        progressPercentage = 50;
        break;
      case 3:
        progressPercentage = 100;
        break;
      default:
        progressPercentage = ((currentStep - 1) / (totalSteps - 1)) * 100;
    }

    if (window.innerWidth < 1024) {
      if (progressPercentage === 100) {
        $(".progress-fill").css("width", "calc(100% + 80px)");
      } else {
        $(".progress-fill").css("width", progressPercentage + "%");
      }
    } else {
      $(".progress-fill").css("height", progressPercentage + "%");
    }
  }

  function validateStep(step) {
    var isValid = true;

    step.find('input[aria-required="true"], textarea[aria-required="true"], select[aria-required="true"]').each(function () {
      if ($(this).val() === '') {
        isValid = false;
        $(this).addClass('wpcf7-not-valid');

        if (!$(this).next('.wpcf7-not-valid-tip').length) {
          $(this).after('<span class="wpcf7-not-valid-tip">Este campo es obligatorio.</span>');
        }
      } else {
        $(this).removeClass('wpcf7-not-valid');
        $(this).next('.wpcf7-not-valid-tip').remove();
      }
    });

    step.find('input[type="email"]').each(function () {
      var email = $(this).val();
      if (email !== '' && !isValidEmail(email)) {
        isValid = false;
        $(this).addClass('wpcf7-not-valid');
        if (!$(this).next('.wpcf7-not-valid-tip').length) {
          $(this).after('<span class="wpcf7-not-valid-tip">Por favor, introduce una dirección de correo válida.</span>');
        }
      }
    });

    step.find('input[type="tel"]').each(function () {
      var phone = $(this).val();
      if (phone !== '' && !isValidPhone(phone)) {
        isValid = false;
        $(this).addClass('wpcf7-not-valid');
        if (!$(this).next('.wpcf7-not-valid-tip').length) {
          $(this).after('<span class="wpcf7-not-valid-tip">Por favor, introduce un número de teléfono válido.</span>');
        }
      }
    });

    return isValid;
  }

  function isValidEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }

  function isValidPhone(phone) {
    var regex = /^[0-9]{9,}$/;
    return regex.test(phone.replace(/\s+/g, '').replace(/[()-]/g, ''));
  }

  function scrollActiveStepIntoView() {
    var activeStep = $(".step-progress-bar .step.active");
    if (activeStep.length) {
      setTimeout(function () {
        activeStep[0].scrollIntoView({
          behavior: 'smooth',
          block: 'nearest',
          inline: 'center'
        });
      }, 50);
    }
  }
  /* Fin Formulario de asociación de usuarios */

  // Verificar si existe el elemento wpcf7 antes de agregar el event listener
  var wpcf7Elm = document.querySelector('.wpcf7');

  if (wpcf7Elm) {
    wpcf7Elm.addEventListener('wpcf7submit', function (event) {
      $('[data-seccion-formulario]').slideUp();
      $('[data-formulario-gracias]').fadeIn().removeClass('d-none');
    }, false);
  }

  /* Laboratorio Clínico */
  if ($('.customSecionLaboratorioClinico').length) {
    // Variables
    const inputBuscar = $('#buscar-laboratorio-clinico');
    const botonBuscar = $('#boton-buscar');
    const letrasButtons = $('.letra-btn');
    const contenedorResultados = $('#resultados-laboratorios');
    let timeoutId;

    function ajustarAlturasListas() {
      let alturaVentana = window.innerHeight;
      let alturaMaxima = 0;

      if (window.innerWidth < 768) {
        alturaMaxima = 200; // Altura más pequeña para móviles
      } else {
        alturaMaxima = alturaVentana * 0.6;
      }
    }

    // Función para realizar la búsqueda AJAX
    function buscarLaboratorios(query = '', letra = '') {
      if (contenedorResultados.length > 0) {
        contenedorResultados.html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Cargando...</span></div></div>');
      } else {
        // Si el contenedor no existe, crearlo
        $('.customSecionLaboratorioClinico').after('<div id="resultados-laboratorios" class="customContainer mt-48 mb-48"><div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Cargando...</span></div></div></div>');
      }

      $.ajax({
        url: ajax_object.ajax_url,
        type: 'POST',
        data: {
          action: 'buscar_laboratorios_clinicos',
          query: query,
          letra: letra
        },
        success: function (response) {
          $('#resultados-laboratorios').html(response);

          ajustarAlturasListas();

          // Añadir evento para mostrar detalles al hacer clic
          $('.customSecionLaboratorioClinico__item').on('click', function () {
            // Destacar el elemento seleccionado
            $('.customSecionLaboratorioClinico__item').removeClass('activo');
            $(this).addClass('activo');
            
            // Obtener el ID del laboratorio seleccionado
            const labId = $(this).attr('data-lab-id');
            
            // Ocultar todos los paneles de detalles y el placeholder
            $('#detalle-placeholder').hide();
            $('[id^="lab-detalle-"]').hide();
            
            // Mostrar el panel de detalles correspondiente
            $('#lab-detalle-' + labId).show();
            
            // En dispositivos móviles, hacer scroll hasta el detalle
            if (window.innerWidth < 768) {
              $('html, body').animate({
                scrollTop: $('#lab-detalle-' + labId).offset().top - 20
              }, 300);
            }
          });

          if ($('.customSecionLaboratorioClinico__item').length === 1) {
            $('.customSecionLaboratorioClinico__item').first().trigger('click');
          }
        },
        error: function (error) {
          console.error('Error en la búsqueda:', error);
          $('#resultados-laboratorios').html('<p>Ha ocurrido un error. Por favor intenta nuevamente.</p>');
        }
      });
    }

    inputBuscar.on('keyup', function () {
      clearTimeout(timeoutId);
      const query = $(this).val();

      timeoutId = setTimeout(function () {
        if (query.length >= 2) {
          buscarLaboratorios(query, '');
        }
      }, 500);
    });

    botonBuscar.on('click', function () {
      const query = inputBuscar.val();
      if (query.length >= 2) {
        buscarLaboratorios(query, '');
      }
    });

    letrasButtons.on('click', function () {
      const letra = $(this).data('letra');
      inputBuscar.val('');
      letrasButtons.removeClass('active');
      $(this).addClass('active');
      buscarLaboratorios('', letra);
    });

    $(window).on('resize', ajustarAlturasListas);

    ajustarAlturasListas();
  }
});

