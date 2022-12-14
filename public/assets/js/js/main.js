(function ($) {
  "use strict";

  /* 1. Proloder */
  $(window).on("load", function () {
    $("#preloader-active")
      .delay(450)
      .fadeOut("slow");
    $("body")
      .delay(450)
      .css({
        overflow: "visible"
      });
  });

  /* 2. slick Nav  RFG */
  // mobile_menu
  var menu = $("ul#navigation");
  if (menu.length) {
    menu.slicknav({
      prependTo: ".mobile_menu",
      closedSymbol: "+",
      openedSymbol: "-"
    });
  }

  /* 4. MainSlider-1 */
  // h1-hero-active
  function mainSlider() {
    var BasicSlider = $(".slider-active");
    BasicSlider.on("init", function (e, slick) {
      var $firstAnimatingElements = $(".single-slider:first-child").find(
        "[data-animation]"
      );
      doAnimations($firstAnimatingElements);
    });
    BasicSlider.on("beforeChange", function (e, slick, currentSlide, nextSlide) {
      var $animatingElements = $(
        '.single-slider[data-slick-index="' + nextSlide + '"]'
      ).find("[data-animation]");
      doAnimations($animatingElements);
    });
    BasicSlider.slick({
      autoplay: true,
      autoplaySpeed: 3500,
      dots: false,
      fade: true,
      arrows: false,
      prevArrow: '<button type="button" class="slick-prev"><i class="ti-angle-left"></i></button>',
      nextArrow: '<button type="button" class="slick-next"><i class="ti-angle-right"></i></button>',
      responsive: [{
          breakpoint: 1024,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true
          }
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false
          }
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false
          }
        }
      ]
    });

    function doAnimations(elements) {
      var animationEndEvents =
        "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";
      elements.each(function () {
        var $this = $(this);
        var $animationDelay = $this.data("delay");
        var $animationType = "animated " + $this.data("animation");
        $this.css({
          "animation-delay": $animationDelay,
          "-webkit-animation-delay": $animationDelay
        });
        $this.addClass($animationType).one(animationEndEvents, function () {
          $this.removeClass($animationType);
        });
      });
    }
  }
  mainSlider();

  // Weekly-2 Acticve
  $(".weekly2-news-active").slick({
    dots: false,
    infinite: true,
    speed: 500,
    arrows: true,
    autoplay: true,
    loop: true,
    slidesToShow: 3,
    prevArrow: '<button type="button" class="slick-prev"><i class="ti-angle-left"></i></button>',
    nextArrow: '<button type="button" class="slick-next"><i class="ti-angle-right"></i></button>',
    slidesToScroll: 1,
    responsive: [{
        breakpoint: 1200,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 700,
        settings: {
          arrows: false,
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          arrows: false,
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });

  // Weekly-2 Acticve
  $(".weekly3-news-active").slick({
    dots: true,
    infinite: true,
    speed: 500,
    arrows: false,
    autoplay: true,
    loop: true,
    slidesToShow: 4,
    prevArrow: '<button type="button" class="slick-prev"><i class="ti-angle-left"></i></button>',
    nextArrow: '<button type="button" class="slick-next"><i class="ti-angle-right"></i></button>',
    slidesToScroll: 1,
    responsive: [{
        breakpoint: 1200,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 700,
        settings: {
          arrows: false,
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          arrows: false,
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });

  // recent-active
  $(".recent-active").slick({
    dots: false,
    infinite: true,
    speed: 600,
    arrows: false,
    slidesToShow: 3,
    slidesToScroll: 1,
    prevArrow: '<button type="button" class="slick-prev"> <span class="flaticon-arrow"></span></button>',
    nextArrow: '<button type="button" class="slick-next"> <span class="flaticon-arrow"><span></button>',

    initialSlide: 3,
    loop: true,
    responsive: [{
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });

  /* 5. Video area Active */
  $(".video-items-active").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    asNavFor: ".testmonial-nav"
  });
  $(".testmonial-nav").slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    asNavFor: ".video-items-active",
    dots: false,
    arrows: false,
    prevArrow: '<button type="button" class="slick-prev"><span class="ti-arrow-left"></<span></button>',
    nextArrow: '<button type="button" class="slick-next"><span class="ti-arrow-right"></span></button>',
    centerMode: true,
    focusOnSelect: true,
    centerPadding: 0,
    responsive: [{
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });

  /* 5. Gallery Active */
  var client_list = $(".completed-active");
  if (client_list.length) {
    client_list.owlCarousel({
      slidesToShow: 2,
      slidesToScroll: 1,
      loop: true,
      autoplay: true,
      speed: 3000,
      smartSpeed: 2000,
      nav: false,
      dots: false,
      margin: 15,

      autoplayHoverPause: true,
      responsive: {
        0: {
          items: 1
        },
        768: {
          items: 2
        },
        992: {
          items: 2
        },
        1200: {
          items: 3
        }
      }
    });
  }

  /* 6. Nice Selectorp  */
  var nice_Select = $("select");
  if (nice_Select.length) {
    nice_Select.niceSelect();
  }

  /* 7.  Custom Sticky Menu  */
  $(window).on("scroll", function () {
    var scroll = $(window).scrollTop();
    var logoMini = $("#logo-mini");

    if (scroll < 245) {
      logoMini.hide();
      $(".header-sticky ").removeClass("sticky-bar");
    } else {
      logoMini.show();
      $(".header-sticky").addClass("sticky-bar");
    }
  });

  /*   Show img flex  */
  $(window).on("scroll", function () {
    var scroll = $(window).scrollTop();
    if (scroll < 245) {
      $(".header-flex").removeClass("sticky-flex");
    } else {
      $(".header-flex").addClass("sticky-flex");
    }
  });

  $(window).on("scroll", function () {
    var scroll = $(window).scrollTop();
    if (scroll < 245) {
      $(".header-sticky").removeClass("sticky");
    } else {
      $(".header-sticky").addClass("sticky");
    }
  });

  /* 8. sildeBar scroll */
  $.scrollUp({
    scrollName: "scrollUp", // Element ID
    topDistance: "300", // Distance from top before showing element (px)
    topSpeed: 300, // Speed back to top (ms)
    animation: "fade", // Fade, slide, none
    animationInSpeed: 200, // Animation in speed (ms)
    animationOutSpeed: 200, // Animation out speed (ms)
    scrollText: '<i class="ti-arrow-up"></i>', // Text for element
    activeOverlay: false // Set CSS color to display scrollUp active point, e.g '#00FFFF'
  });

  /* 9. data-background */
  $("[data-background]").each(function () {
    $(this).css(
      "background-image",
      "url(" + $(this).attr("data-background") + ")"
    );
  });

  /* 10. WOW active */
  new WOW().init();

  /* 11. Datepicker */

  // 11. ---- Mailchimp js --------//
  // function mailChimp() {
  //     $('#mc_embed_signup').find('form').ajaxChimp();
  // }
  // mailChimp();

  // 12 Pop Up Img
  var popUp = $(".single_gallery_part, .img-pop-up");
  if (popUp.length) {
    popUp.magnificPopup({
      type: "image",
      gallery: {
        enabled: true
      }
    });
  }

  // Add class

  $(".sticky-logo").addClass("info-open");

  // Remove clas
  $(".close-icon").click(function () {
    $(".extra-inofo-bar").removeClass("info-open");
  });

  // Modal Activation
  $(".search-switch").on("click", function () {
    $(".search-model-box").fadeIn(400);
  });

  $(".search-close-btn").on("click", function () {
    $(".search-model-box").fadeOut(400, function () {
      $("#search-input").val("");
    });
  });

  $(".select2").select2({
    language: "pt-BR"
  });
  $(".select2-selection__arrow").html(
    '<i class="fas fa-search" style="font-size: 18pt; margin-top: 13px"></i>'
  );
  // $('.select2-container').css('display', 'table-cell');
  // $('.select2-selection__arrow').html('<i class="fas fa-search" style="font-size: 18pt; margin-top: 13px"></i>');
  // $('.select2-container--default .select2-selection--single .select2-selection__arrow')
  //     .css('height', '48px')
  //     .css('position', 'absolute')
  //     .css('top', '7px')
  //     .css('color', '#0032a0')
  //     .css('right', '8px')
  //     .css('background', 'white')
  //     .css('width', '50px')
  //     .css('padding', '0px 13px')
  //     .css('border-radius', '31px');

  // $('.select2-container--default .select2-selection--single .select2-selection__rendered').css('color', 'white');
  $(".select2-container--default")
    .eq(1)
    .hide();

  $(".select2").change(function () {
    window.location.href = $(".select2").val();
  });

  //tela de pesquisa
  $(".selecionar")
    .parent()
    .parent()
    .click(function () {
      window.location.href = $(this)
        .find(".selecionar")
        .eq(0)
        .attr("href");
    });

  //solicitar
  $(".solicitar").click(function (event) {
    event.preventDefault();

    let save = true;
    //campos requiridos
    $(".required").each(function () {
      if ($(this).val()) {
        $(this).removeClass("input-error");
      } else {
        save = false;
        $(this).addClass("input-error");
      }
    });

    if (grecaptcha.getResponse() == '') {
      $('#html_element').find('div').eq(0).css('border', 'solid 1px red');
      save = false;
    } else {
      $('#html_element').find('div').eq(0).css('border', 'none');
    }

    if (save) {
      $("#mail_form").submit();
    } else {
      let target_top =
        $(".input-error")
        .eq(0)
        .offset().top - 100;
      $("html, body").animate({
          scrollTop: target_top
        },
        0
      );
    }
  });

  $("#telefone").inputmask("(99) 9999-9999[9]");
})(jQuery);