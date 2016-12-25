<?php

/*
Widget Name: Livemesh Heading
Description: Create heading for display on the top of a section.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/

class LVCA_Heading {

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_heading', array($this, 'shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_style('lvca-heading', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);

    }

    public function shortcode_func($atts, $content = null, $tag) {

        $heading = $style = $subtitle = $short_text = '';

        extract(shortcode_atts(array(

            'style' => 'style1',
            'heading' => '',
            'subtitle' => false,
            'short_text' => false

        ), $atts));

        ob_start();

        ?>

        <div class="lvca-heading lvca-<?php echo $style; ?>">

            <?php if ($style == 'style2' && !empty($subtitle)): ?>

                <div class="lvca-subtitle"><?php echo esc_html($subtitle); ?></div>

            <?php endif; ?>

            <h3 class="lvca-title"><?php echo wp_kses_post($heading); ?></h3>

            <?php if ($style != 'style3' && !empty($short_text)): ?>

                <p class="lvca-text"><?php echo wp_kses_post($short_text); ?></p>

            <?php endif; ?>

        </div>

        <?php

        $output = ob_get_clean();

        return $output;
    }

    function map_vc_element() {
        if (function_exists("vc_map")) {

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Livemesh Heading", "livemesh-vc-addons"),
                "base" => "lvca_heading",
                "content_element" => true,
                "show_settings_on_create" => true,
                "category" => __("Livemesh VC Addons", "livemesh-vc-addons"),
                'description' => __('Create heading for a section.', 'livemesh-vc-addons'),
                "icon" => 'icon-lvca-heading',
                "params" => array(
                    // add params same as with any other content element
                    array(
                        "type" => "dropdown",
                        "param_name" => "style",
                        "heading" => __("Choose Style", "livemesh-vc-addons"),
                        "description" => __("Choose the particular style of heading you need", "livemesh-vc-addons"),
                        'value' => array(
                            __('Style 1', 'livemesh-vc-addons') => 'style1',
                            __('Style 2', 'livemesh-vc-addons') => 'style2',
                            __('Style 3', 'livemesh-vc-addons') => 'style3',
                        ),
                        'std' => 'style1',
                    ),
                    array(
                        'type' => 'textfield',
                        'param_name' => 'heading',
                        "admin_label" => true,
                        'heading' => __('Title', 'livemesh-vc-addons'),
                        'description' => __('Title for the heading.', 'livemesh-vc-addons'),
                    ),
                    array(
                        'type' => 'textfield',
                        'param_name' => 'subtitle',
                        'heading' => __('Subheading or Subtitle', 'livemesh-vc-addons'),
                        'description' => __('A subtitle displayed above the title heading.', 'livemesh-vc-addons'),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => 'style2',
                        ),
                    ),
                    array(
                        'type' => 'textarea',
                        'param_name' => 'short_text',
                        'heading' => __('Short Text', 'livemesh-vc-addons'),
                        'description' => __('Short text generally displayed below the heading title.', 'livemesh-vc-addons'),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('style1' , 'style2'),
                        ),
                    ),
                ),
            ));


        }
    }

}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_heading extends WPBakeryShortCode {
    }
}