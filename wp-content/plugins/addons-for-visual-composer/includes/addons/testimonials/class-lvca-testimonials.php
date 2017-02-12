<?php

/*
Widget Name: Livemesh Testimonials
Description: Display testimonials from your clients/customers in a multi-column grid.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/


class LVCA_Testimonials {

    protected $_per_line;

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_testimonials', array($this, 'shortcode_func'));

        add_shortcode('lvca_testimonial', array($this, 'child_shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

        add_action('init', array($this, 'map_child_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_style('lvca-testimonials', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);

    }

    public function shortcode_func($atts, $content = null, $tag) {

        $per_line = '';

        extract(shortcode_atts(array(
            'per_line' => '3',

        ), $atts));

        $this->_per_line = $per_line;
        
        ob_start();

        ?>

        <div class="lvca-testimonials lvca-container">

            <?php

            do_shortcode($content);

            ?>

        </div>

        <?php

        $output = ob_get_clean();

        return $output;
    }

    public function child_shortcode_func($atts, $content = null, $tag) {

        $author = $credentials = $author_image = '';
        extract(shortcode_atts(array(
            'author' => '',
            'credentials' => '',
            'author_image' => ''

        ), $atts));


        $column_style = lvca_get_column_class(intval($this->_per_line));


        if (function_exists('wpb_js_remove_wpautop'))
            $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

        ?>

        <div class="lvca-testimonial <?php echo $column_style; ?>">

            <div class="lvca-testimonial-text">
                <?php echo wp_kses_post($content) ?>
            </div>

            <div class="lvca-testimonial-user">

                <div class="lvca-image-wrapper">
                    <?php echo wp_get_attachment_image($author_image, 'thumbnail', false, array('class' => 'lvca-image full')); ?>
                </div>

                <div class="lvca-text">
                    <h4 class="lvca-author-name"><?php echo esc_html($author) ?></h4>
                    <div class="lvca-author-credentials"><?php echo wp_kses_post($credentials); ?></div>
                </div>

            </div>

        </div>

    <?php
    }

    function map_vc_element() {
        if (function_exists("vc_map")) {

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Livemesh Testimonials", "livemesh-vc-addons"),
                "base" => "lvca_testimonials",
                "as_parent" => array('only' => 'lvca_testimonial'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                "content_element" => true,
                "show_settings_on_create" => true,
                "category" => __("Livemesh VC Addons", "livemesh-vc-addons"),
                "is_container" => true,
                'description' => __('Display testimonials in a multi-column grid.', 'livemesh-vc-addons'),
                "js_view" => 'VcColumnView',
                "icon" => 'icon-lvca-testimonials',
                "params" => array(
                    array(
                        "type" => "lvca_number",
                        "param_name" => "per_line",
                        "value" => 3,
                        "min" => 1,
                        "max" => 5,
                        "suffix" => '',
                        "heading" => __("Columns per row", "livemesh-vc-addons"),
                        "description" => __("The number of testimonials members to display per row of the testimonials", "livemesh-vc-addons")
                    ),
                ),
            ));


        }
    }


    function map_child_vc_element() {
        if (function_exists("vc_map")) {
            vc_map(array(
                    "name" => __("Livemesh Testimonial", "my-text-domain"),
                    "base" => "lvca_testimonial",
                    "content_element" => true,
                    "as_child" => array('only' => 'lvca_testimonials'), // Use only|except attributes to limit parent (separate multiple values with comma)
                    "icon" => 'icon-lvca-testimonial',
                    "category" => __('Testimonials', 'livemesh-vc-addons'),
                    "params" => array(
                        // add params same as with any other content element
                        array(
                            'type' => 'textfield',
                            'param_name' => 'author',
                            "admin_label" => true,
                            'heading' => __('Name', 'livemesh-vc-addons'),
                            'description' => __('The author of the testimonial', 'livemesh-vc-addons'),
                        ),
                        array(
                            'type' => 'textfield',
                            'param_name' => 'credentials',
                            'heading' => __('Author Details', 'livemesh-vc-addons'),
                            'description' => __('The details of the author like company name, position held, company URL etc.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'attach_image',
                            'param_name' => 'author_image',
                            'heading' => __('Author Image', 'livemesh-vc-addons'),
                        ),
                        array(
                            'type' => 'textarea_html',
                            'param_name' => 'content',
                            'heading' => __('Text', 'livemesh-vc-addons'),
                            'description' => __('What your client/customer has to say', 'livemesh-vc-addons'),
                        ),
                    )
                )

            );

        }
    }

}

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_lvca_testimonials extends WPBakeryShortCodesContainer {
    }
}
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_testimonial extends WPBakeryShortCode {
    }
}