/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/main.js":
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

// JQUERY
function windowLoad() {
  // show the icon when the page is unloaded
  $(window).on('beforeunload', function (event) {
    $(".se-pre-con").fadeIn("fast");
    $("body").addClass("preload");
  }); // hide the icon when the page is fully loaded

  $(window).on('load', function (event) {
    $(".se-pre-con").fadeOut("fast");
    $("body").removeClass("preload");
  });
  $(document).ready(function () {
    $(".se-pre-con").fadeOut("fast");
    $("body").removeClass("preload");
  });
}

$(function () {
  // ************************************************************************************************ \\
  // == Flash Controll =============================================================================== \\
  // ************************************************************************************************** \\
  // Fade out Flash alert message
  function fadeAlert() {
    $('div.alert').not('.alert-important').not('.message-container').delay(3000).fadeOut(350);
  }

  function triggerModal() {
    $('#flash-overlay-modal').modal();
  }

  function fadeFlash() {
    $(".flash-alert").fadeTo(2000, 1000).slideUp(1000, function () {
      $(".flash-alert").slideUp(1000);
    });
  } // Enable Tool Tips


  $('[data-toggle="tooltip"]').tooltip(); // ************************************************************************************************ \\
  // == ON SCROLL ==================================================================================== \\
  // ************************************************************************************************** \\

  function scroller() {
    // == Change Header on scroll ==
    var header = $(".header-primary");
    var mobileMenu = $("#mobile-menu-slide"); // ******* SCROLL ************\\

    $(window).on('scroll', function () {
      // == Change Header on scroll ==
      scroll = $(window).scrollTop(); // set scroll amount (px)

      if (scroll >= 20) {
        header.addClass("header-secondary"); // if scroll is further than #px change class

        mobileMenu.addClass("mobile-menu-secondary"); // if scroll is further than #px change class
        // splashBox.css("z-index", -100);
      } else {
        header.removeClass("header-secondary"); // if not (is at top) change class back

        mobileMenu.removeClass("mobile-menu-secondary"); // if not (is at top) change class back
      }
    }); // == Change Header on scroll ==

    var scroll = $(window).scrollTop();

    if (scroll >= 20) {
      header.addClass("header-secondary"); // if scroll is further than #px change class

      mobileMenu.addClass("mobile-menu-secondary"); // if scroll is further than #px change class
    } else {
      header.removeClass("header-secondary"); // if not (is at top) change class back

      mobileMenu.removeClass("mobile-menu-secondary"); // if not (is at top) change class back
    }
  } // ************************************************************************************************ \\
  // == ANIMATE ON SCROLL / SLIDE IN ================================================================= \\
  // ************************************************************************************************** \\
  // add class="animation-element"
  // animations classes avaliable:
  // .slide-left
  // .slide-right


  function animateOnScroll() {
    var $animation_elements = $('.animation-element');
    var $tab_animation_elements = $('.tab-animation-element');
    var $force_in_view = $('.force-in-view');
    var $window = $(window);

    function check_if_in_view() {
      var window_height = $window.height() - 200;
      var window_top_position = $window.scrollTop();
      var window_bottom_position = window_top_position + window_height;

      if ($animation_elements) {
        $.each($animation_elements, function () {
          var $element = $(this);
          var element_height = $element.outerHeight();
          var element_top_position = $element.offset().top;
          var element_bottom_position = element_top_position + element_height; //check to see if this current container is within viewport

          if (element_bottom_position >= window_top_position && element_top_position <= window_bottom_position) {
            $element.addClass('in-view');
          }
        });
      }

      if ($force_in_view) {
        $.each($force_in_view, function () {
          $(this).addClass('in-view');
        });
      }
    }

    $(window).on('load', function () {
      setTimeout(function () {
        $window.on('scroll resize', check_if_in_view);
        $window.trigger('scroll');
      }, 50);
    });
  } // ************************************************************************************************ \\
  // == MOBILE MENU  ================================================================= \\
  // ************************************************************************************************** \\


  function mobileMenu() {
    var mobileMenuBtn = $("#nav-btn");
    var mobileMenu = $("#mobile-menu-slide");
    mobileMenuBtn.on('click', function () {
      mobileMenu.toggleClass('open');
      mobileMenuBtn.toggleClass('is-active');
    });
  }

  windowLoad();
  fadeAlert();
  fadeFlash();
  triggerModal();
  scroller();
  animateOnScroll();
  mobileMenu();
});

/***/ }),

/***/ 2:
/*!************************************!*\
  !*** multi ./resources/js/main.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\laragon\www\vegano\resources\js\main.js */"./resources/js/main.js");


/***/ })

/******/ });