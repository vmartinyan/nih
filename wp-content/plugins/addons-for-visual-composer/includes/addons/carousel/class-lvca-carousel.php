<?php

/*
Widget Name: Livemesh Carousel
Description: Display a list of custom HTML content as a carousel.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/


class LVCA_Carousel {

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_carousel', array($this, 'shortcode_func'));

        add_shortcode('lvca_carousel_item', array($this, 'child_shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

        add_action('init', array($this, 'map_child_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_script('lvca-slick-carousel', LVCA_PLUGIN_URL . 'assets/js/slick' . LVCA_BUNDLE_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_style('lvca-slick', LVCA_PLUGIN_URL . 'assets/css/slick.css', array(), LVCA_VERSION);

        wp_enqueue_style('lvca-carousel', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);

    }

    public function shortcode_func($atts, $content = null, $tag) {

        $defaults = lvca_get_default_atts_carousel();

        $settings = shortcode_atts($defaults, $atts);

        $uniqueid = uniqid();

        ob_start();

        ?>

        <div id="lvca-carousel-<?php echo $uniqueid; ?>" class="lvca-carousel lvca-container"<?php foreach ($settings as $key => $val) {
            if (!empty($val)) {
                echo ' data-' . $key . '="' . esc_attr($val) . '"';
            }
        } ?>>

            <?php

            do_shortcode($content);

            ?>
        </div>
        <style type="text/css">
            #lvca-carousel-<?php echo $uniqueid; ?>.lvca-carousel .lvca-carousel-item {
                padding: <?php echo $settings['gutter']; ?>px;
                }

            @media screen and (max-width: <?php echo $settings['tablet_width']; ?>) {
                #lvca-carousel-<?php echo $uniqueid; ?>.lvca-carousel .lvca-carousel-item {
                    padding: <?php echo $settings['tablet_gutter']; ?>px;
                    }
                }

            @media screen and (max-width: <?php echo $settings['mobile_width']; ?>) {
                #lvca-carousel-<?php echo $uniqueid; ?>.lvca-carousel .lvca-carousel-item {
                    padding: <?php echo $settings['mobile_gutter']; ?>px;
                    }
                }
        </style>
        <?php

        $output = ob_get_clean();

        return $output;
    }

    public function child_shortcode_func($atts, $content = null, $tag) {

        if (function_exists('wpb_js_remove_wpautop'))
            $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

        ?>
        <div class="lvca-carousel-item">

            <?php echo do_shortcode(wp_kses_post($content)); ?>

        </div><!--.lvca-carousel-item -->

    <?php
    }

    function map_vc_element() {
        if (function_exists("vc_map")) {

            $carousel_params = lvca_get_vc_map_carousel_options();

            $carousel_params = array_merge($carousel_params, lvca_get_vc_map_carousel_display_options());

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Livemesh Carousel", "livemesh-vc-addons"),
                "base" => "lvca_carousel",
                "as_parent" => array('only' => 'lvca_carousel_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                "content_element" => true,
                "show_settings_on_create" => true,
                "category" => __("Livemesh VC Addons", "livemesh-vc-addons"),
                "is_container" => true,
                'description' => __('Display a carousel of html elements.', 'livemesh-vc-addons'),
                "js_view" => 'VcColumnView',
                "icon" => 'icon-lvca-carousel',
                "params" => $carousel_params
            ));


        }
    }


    function map_child_vc_element() {
        if (function_exists("vc_map")) {

            vc_map(array(
                    "name" => __("Livemesh Carousel", "livemesh-vc-addons"),
                    "base" => "lvca_carousel_item",
                    "content_element" => true,
                    "as_child" => array('only' => 'lvca_carousel'), // Use only|except attributes to limit parent (separate multiple values with comma)
                    "icon" => 'icon-lvca-carousel-item',
                    "category" => __('Carousel', 'livemesh-vc-addons'),
                    "params" => array(
                        array(
                            'type' => 'textfield',
                            'param_name' => 'name',
                            'heading' => __('Name', 'livemesh-vc-addons'),
                            'description' => __('The title to identify the HTML element. Will not be output to the frontend.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textarea_html',
                            'param_name' => 'content',
                            'heading' => __('HTML element', 'livemesh-vc-addons'),
                            'description' => __('The HTML content for the carousel item. Custom CSS for presentation of the HTML elements should be entered by the user in Settings->Custom CSS panel in VC or in the theme files.', 'livemesh-vc-addons'),
                        ),
                    )

                )
            );

        }
    }

}

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_lvca_carousel extends WPBakeryShortCodesContainer {
    }
}
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_carousel_item extends WPBakeryShortCode {
    }
}