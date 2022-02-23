// JQUERY
function windowLoad() {
    // show the icon when the page is unloaded
    $(window).on('beforeunload', function (event) {
        $(".se-pre-con").fadeIn("fast");
        $("body").addClass("preload");
    });

// hide the icon when the page is fully loaded
    $(window).on('load', function (event) {
        $(".se-pre-con").fadeOut("fast");
        $("body").removeClass("preload");
    });

    $(document).ready(function(){
        $(".se-pre-con").fadeOut("fast");
        $("body").removeClass("preload");
    })
}


$(function() {

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
    }

    // Enable Tool Tips
    $('[data-toggle="tooltip"]').tooltip();


    // ************************************************************************************************ \\
// == ON SCROLL ==================================================================================== \\
// ************************************************************************************************** \\
    function scroller(){

        // == Change Header on scroll ==
        var header = $(".header-primary");
        var mobileMenu = $("#mobile-menu-slide");


        // ******* SCROLL ************\\
        $(window).on('scroll',function () {

            // == Change Header on scroll ==
            scroll = $(window).scrollTop();
            // set scroll amount (px)
            if (scroll >= 20) {
                header.addClass("header-secondary");// if scroll is further than #px change class
                mobileMenu.addClass("mobile-menu-secondary");// if scroll is further than #px change class
                // splashBox.css("z-index", -100);
            } else {
                header.removeClass("header-secondary"); // if not (is at top) change class back
                mobileMenu.removeClass("mobile-menu-secondary"); // if not (is at top) change class back
            }

        });

        // == Change Header on scroll ==
        var scroll = $(window).scrollTop();
        if (scroll >= 20) {
            header.addClass("header-secondary");// if scroll is further than #px change class
            mobileMenu.addClass("mobile-menu-secondary");// if scroll is further than #px change class
        } else {
            header.removeClass("header-secondary"); // if not (is at top) change class back
            mobileMenu.removeClass("mobile-menu-secondary"); // if not (is at top) change class back
        }
    }

    // ************************************************************************************************ \\
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
            var window_bottom_position = (window_top_position + window_height);

            if($animation_elements){
                $.each($animation_elements, function () {
                    var $element = $(this);
                    var element_height = $element.outerHeight();
                    var element_top_position = $element.offset().top;
                    var element_bottom_position = (element_top_position + element_height);

                    //check to see if this current container is within viewport
                    if ((element_bottom_position >= window_top_position) &&
                        (element_top_position <= window_bottom_position)) {
                        $element.addClass('in-view');
                    }
                });
            }
            if($force_in_view){
                $.each($force_in_view, function () {
                    $(this).addClass('in-view');
                });
            }
        }

        $(window).on('load', function () {
            setTimeout(function(){
                $window.on('scroll resize', check_if_in_view);
                $window.trigger('scroll');
            }, 50)
        });
    }

    // ************************************************************************************************ \\
// == MOBILE MENU  ================================================================= \\
// ************************************************************************************************** \\

    function mobileMenu(){
        var mobileMenuBtn = $("#nav-btn");
        var mobileMenu = $("#mobile-menu-slide");

        mobileMenuBtn.on('click', function() {
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
