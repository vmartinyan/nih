<?php

/*
Widget Name: Livemesh Clients
Description: Display list of your clients in a multi-column grid.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/

class LVCA_Clients {

    protected $_per_line;

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_clients', array($this, 'shortcode_func'));

        add_shortcode('lvca_single_client', array($this, 'child_shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

        add_action('init', array($this, 'map_child_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_style('lvca-clients', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);

    }

    public function shortcode_func($atts, $content = null, $tag) {

        $per_line = $bar_color = $track_color = '';

        extract(shortcode_atts(array(
            'per_line' => '4',

        ), $atts));

        $this->_per_line = $per_line;

        ob_start();

        ?>

        <div class="lvca-clients lvca-container">

            <?php

            do_shortcode($content);

            ?>

        </div>

        <?php

        $output = ob_get_clean();

        return $output;
    }

    public function child_shortcode_func($atts, $content = null, $tag) {

        $client_name = $client_image = $client_url = '';
        extract(shortcode_atts(array(
            'client_name' => '',
            'client_url' => false,
            'client_image' => ''

        ), $atts));

        $column_style = lvca_get_column_class(intval($this->_per_line));

        ?>

        <div class="lvca-client <?php echo $column_style; ?> lvca-zero-margin">

            <?php echo wp_get_attachment_image($client_image, 'full', false, array('class' => 'lvca-image full', 'alt' => $client_name)); ?>

            <div class="lvca-client-name">

                <?php if (!empty($client_url) && function_exists('vc_build_link')): ?>

                    <?php $client_url = vc_build_link($client_url); ?>

                    <a href="<?php echo esc_url($client_url['url']); ?>" title="<?php echo esc_html($client_url['title']); ?>" target="<?php echo $client_url['target']; ?>"><?php echo esc_html($client_name); ?></a>

                <?php else: ?>

                    <?php echo esc_html($client_name); ?>

                <?php endif; ?>

            </div>

            <div class="lvca-image-overlay"></div>

        </div>

    <?php
    }

    function map_vc_element() {
        if (function_exists("vc_map")) {

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Livemesh Clients", "livemesh-vc-addons"),
                "base" => "lvca_clients",
                "as_parent" => array('only' => 'lvca_single_client'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                "content_element" => true,
                "show_settings_on_create" => true,
                "category" => __("Livemesh VC Addons", "livemesh-vc-addons"),
                "is_container" => true,
                'description' => __('Display clients in a multi-column grid.', 'livemesh-vc-addons'),
                "js_view" => 'VcColumnView',
                "icon" => 'icon-lvca-clients',
                "params" => array(

                    array(
                        "type" => "lvca_number",
                        "param_name" => "per_line",
                        "value" => 4,
                        "min" => 1,
                        "max" => 6,
                        "suffix" => '',
                        "heading" => __("Clients per row", "livemesh-vc-addons"),
                        "description" => __("The number of columns to display per row of the clients", "livemesh-vc-addons")
                    ),
                ),
            ));


        }
    }


    function map_child_vc_element() {
        if (function_exists("vc_map")) {
            vc_map(array(
                    "name" => __("Livemesh Client", "my-text-domain"),
                    "base" => "lvca_single_client",
                    "content_element" => true,
                    "as_child" => array('only' => 'lvca_clients'), // Use only|except attributes to limit parent (separate multiple values with comma)
                    "icon" => 'icon-lvca-client',
                    "params" => array(
                        // add params same as with any other content element
                        array(
                            'type' => 'textfield',
                            'param_name' => 'client_name',
                            "admin_label" => true,
                            'heading' => __('Name', 'livemesh-vc-addons'),
                            'description' => __('Name of the client/customer.', 'livemesh-vc-addons'),
                        ),
                        
                        array(
                            'type' => 'vc_link',
                            'param_name' => 'client_url',
                            'heading' => __('Client URL', 'livemesh-vc-addons'),
                            'description' => __('The website of the client/customer.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'attach_image',
                            'param_name' => 'client_image',
                            'heading' => __('Client Logo.', 'livemesh-vc-addons'),
                            'description' => __('The logo image for the client/customer.', 'livemesh-vc-addons'),
                        ),

                    )
                )

            );

        }
    }

}

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_lvca_clients extends WPBakeryShortCodesContainer {
    }
}
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_single_client extends WPBakeryShortCode {
    }
}