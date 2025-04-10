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


});

