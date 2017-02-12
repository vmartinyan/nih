jQuery(function ($) {

    $('.lvca-piecharts').waypoint(function (direction) {

        $(this).find('.lvca-piechart .lvca-percentage').each(function () {

            var track_color = $(this).data('track-color');
            var bar_color = $(this).data('bar-color');

            $(this).easyPieChart({
                animate: 2000,
                lineWidth: 5,
                barColor: bar_color,
                trackColor: track_color,
                scaleColor: false,
                lineCap: 'square',
                size: 220

            });

        });

    }, { offset: $.waypoints('viewportHeight') - 100,
        triggerOnce: true});


});