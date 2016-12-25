<?php

/*
Widget Name: Livemesh Accordion
Description: Displays collapsible content panels to help display information when space is limited.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/


class LVCA_Accordion {

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_accordion', array($this, 'shortcode_func'));

        add_shortcode('lvca_panel', array($this, 'child_shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

        add_action('init', array($this, 'map_child_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_script('lvca-accordion', plugin_dir_url(__FILE__) . 'js/accordion' . LVCA_BUNDLE_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_style('lvca-accordion', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);
    }

    public function shortcode_func($atts, $content = null, $tag) {

        $style = $toggle = '';

        extract(shortcode_atts(array(
            'style' => 'style1',
            'toggle' => false
        ), $atts));

        ob_start();

        ?>

        <div class="lvca-accordion lvca-<?php echo $style; ?>" data-toggle="<?php echo ($toggle ? "true" : "false"); ?>">

            <?php

            do_shortcode($content);

            ?>

        </div>

        <?php

        $output = ob_get_clean();

        return $output;
    }

    public function child_shortcode_func($atts, $content = null, $tag) {

        $panel_title = $percentage = '';
        extract(shortcode_atts(array(
            'panel_title' => ''

        ), $atts));

        ?>

        <div class="lvca-panel">

            <div class="lvca-panel-title"><?php echo esc_html($panel_title); ?></div>

            <div class="lvca-panel-content"><?php echo do_shortcode($content) ?></div>

        </div>

        <?php
    }

    function map_vc_element() {
        if (function_exists("vc_map")) {

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Livemesh Accordion", "livemesh-vc-addons"),
                "base" => "lvca_accordion",
                "as_parent" => array('only' => 'lvca_panel'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                "content_element" => true,
                "show_settings_on_create" => false,
                "category" => __("Livemesh VC Addons", "livemesh-vc-addons"),
                "is_container" => true,
                'description' => __('Display collapsible content panels.', 'livemesh-vc-addons'),
                "js_view" => 'VcColumnView',
                "icon" => 'icon-lvca-accordion',
                "params" => array(


                    array(
                        "type" => "dropdown",
                        "param_name" => "style",
                        "heading" => __("Choose Accordion Style", "livemesh-vc-addons"),
                        "description" => __("Choose the particular style of accordion you need", "livemesh-vc-addons"),
                        'value' => array(
                            __('Style 1', 'livemesh-vc-addons') => 'style1',
                            __('Style 2', 'livemesh-vc-addons') => 'style2',
                            __('Style 3', 'livemesh-vc-addons') => 'style3',
                        ),
                        'std' => 'style1',
                    ),

                    array(
                        'type' => 'checkbox',
                        'param_name' => 'toggle',
                        'heading' => __('Allow to function like toggle?', 'livemesh-vc-addons'),
                        "description" => __("Check if multiple elements can be open at the same time.", "livemesh-vc-addons"),
                        "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    ),
                ),
            ));


        }
    }


    function map_child_vc_element() {
        if (function_exists("vc_map")) {
            vc_map(array(
                    "name" => __("Livemesh Panel", "my-text-domain"),
                    "base" => "lvca_panel",
                    "content_element" => true,
                    "as_child" => array('only' => 'lvca_accordion'), // Use only|except attributes to limit parent (separate multiple values with comma)
                    "icon" => 'icon-lvca-panel',
                    "params" => array(
                        // add params same as with any other content element
                        array(
                            'type' => 'textfield',
                            'param_name' => 'panel_title',
                            "admin_label" => true,
                            'heading' => __('Panel Title', 'livemesh-vc-addons'),
                            'description' => __('Title for the panel.', 'livemesh-vc-addons'),
                        ),
                        array(
                            'type' => 'textarea_html',
                            'param_name' => 'content',
                            'heading' => __('Panel Content', 'livemesh-vc-addons'),
                            'description' => __('The collapsible content of the panel in the accordion.', 'livemesh-vc-addons'),
                        ),

                    )
                )

            );

        }
    }

}

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_lvca_accordion extends WPBakeryShortCodesContainer {
    }
}
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_panel extends WPBakeryShortCode {
    }
}