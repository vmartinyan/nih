jQuery(function ($) {


    var custom_css = '';
    $('.lvca-posts-carousel').each(function () {
        
        carousel_elem = $(this);
        
        var id_selector = '#' + carousel_elem.attr('id');

        var desktop_gutter = (typeof carousel_elem.data('gutter') !== 'undefined') ? carousel_elem.data('gutter') : 10;

        var tablet_gutter = (typeof carousel_elem.data('tablet_gutter') !== 'undefined') ? carousel_elem.data('tablet_gutter') : 10;

        var tablet_width = carousel_elem.data('tablet_width') || 800;

        var mobile_gutter = (typeof carousel_elem.data('mobile_gutter') !== 'undefined') ? carousel_elem.data('mobile_gutter') : 10;

        var mobile_width = carousel_elem.data('mobile_width') || 480;
        
        custom_css += id_selector + '.lvca-posts-carousel .lvca-posts-carousel-item { padding:' + desktop_gutter + 'px; }';
        
        custom_css += ' @media only screen and (max-width: ' + tablet_width + 'px) { ' + id_selector + '.lvca-posts-carousel .lvca-posts-carousel-item { padding:' + tablet_gutter + 'px; } } ';

        custom_css += ' @media only screen and (max-width: ' + mobile_width + 'px) { ' + id_selector + '.lvca-posts-carousel .lvca-posts-carousel-item { padding:' + mobile_gutter + 'px; } } ';

    });
    if (custom_css != '') {
        custom_css = '<style type="text/css">' + custom_css + '</style>';
        $('head').append(custom_css);
    }

});
