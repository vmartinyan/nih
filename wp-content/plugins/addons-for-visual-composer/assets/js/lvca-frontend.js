/**
 * Reviews JS
 */
if (typeof (jQuery) != 'undefined') {

    jQuery.noConflict(); // Reverts '$' variable back to other JS libraries

    (function ($) {
        "use strict";

        $(function () {


            var LVCA_Frontend = {

                init: function () {
                    this.carousel();
                },

                isMobile: function () {
                    "use strict";
                    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                        return true;
                    }
                    return false;
                },

                vendor_prefix: function () {

                    var prefix;

                    function prefix() {
                        var styles = window.getComputedStyle(document.documentElement, '');
                        prefix = (Array.prototype.slice.call(styles).join('').match(/-(moz|webkit|ms)-/) || (styles.OLink === '' && ['', 'o']))[1];

                        return prefix;
                    }

                    prefix();

                    return prefix;
                },

                carousel: function () {

                    if ($().slick === undefined) {
                        return;
                    }

                    var carousel_elements = $('.lvca-carousel, .lvca-posts-carousel');

                    carousel_elements.each(function () {

                        var carousel_elem = $(this);

                        var arrows = carousel_elem.data('arrows') ? true : false;

                        var dots = carousel_elem.data('dots') ? true : false;

                        var autoplay = carousel_elem.data('autoplay') ? true : false;

                        var autoplay_speed = carousel_elem.data('autoplay_speed') || 3000;

                        var animation_speed = carousel_elem.data('animation_speed') || 300;

                        var fade = carousel_elem.data('fade') ? true : false;

                        var pause_on_hover = carousel_elem.data('pause_on_hover') ? true : false;

                        var display_columns = carousel_elem.data('display_columns') || 4;

                        var scroll_columns = carousel_elem.data('scroll_columns') || 4;

                        var tablet_width = carousel_elem.data('tablet_width') || 800;

                        var tablet_display_columns = carousel_elem.data('tablet_display_columns') || 2;

                        var tablet_scroll_columns = carousel_elem.data('tablet_scroll_columns') || 2;

                        var mobile_width = carousel_elem.data('mobile_width') || 480;

                        var mobile_display_columns = carousel_elem.data('mobile_display_columns') || 1;

                        var mobile_scroll_columns = carousel_elem.data('mobile_scroll_columns') || 1;

                        carousel_elem.slick({
                            arrows: arrows,
                            dots: dots,
                            infinite: true,
                            autoplay: autoplay,
                            autoplaySpeed: autoplay_speed,
                            speed: animation_speed,
                            fade: false,
                            pauseOnHover: pause_on_hover,
                            slidesToShow: display_columns,
                            slidesToScroll: scroll_columns,
                            responsive: [
                                {
                                    breakpoint: tablet_width,
                                    settings: {
                                        slidesToShow: tablet_display_columns,
                                        slidesToScroll: tablet_scroll_columns
                                    }
                                },
                                {
                                    breakpoint: mobile_width,
                                    settings: {
                                        slidesToShow: mobile_display_columns,
                                        slidesToScroll: mobile_scroll_columns
                                    }
                                }
                            ]
                        });
                    });
                }

            }

            LVCA_Frontend.init();

        });

    }(jQuery));

}