<?php

/*
Widget Name: Livemesh Services
Description: Capture services in a multi-column grid.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/

class LVCA_Services {

    protected $_per_line;

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_services', array($this, 'shortcode_func'));

        add_shortcode('lvca_service_item', array($this, 'child_shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

        add_action('init', array($this, 'map_child_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_style('lvca-services', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);

    }

    public function shortcode_func($atts, $content = null, $tag) {

        $per_line = $style = '';

        extract(shortcode_atts(array(
            'per_line' => 3,
            'style' => 'style1',

        ), $atts));

        $this->_per_line = $per_line;

        ob_start();

        ?>

        <div class="lvca-services lvca-<?php echo $style; ?> lvca-container">

            <?php

            do_shortcode($content);

            ?>

        </div>

        <?php

        $output = ob_get_clean();

        return $output;
    }

    public function child_shortcode_func($atts, $content = null, $tag) {

        $title = $excerpt = $icon_image = $icon_type = $icon_family = '';
        extract(shortcode_atts(array(
            'icon_type' => 'icon',
            'icon_image' => '',
            'icon_family' => 'fontawesome',
            "icon_fontawesome" => '',
            "icon_openiconic" => '',
            "icon_typicons" => '',
            "icon_entypo" => '',
            "icon_linecons" => '',
            'title' => '',
            'excerpt' => ''

        ), $atts));

        $column_style = lvca_get_column_class(intval($this->_per_line));

        $icon_type = esc_html($icon_type);

        if ($icon_type == 'icon' && !empty(${'icon_' . $icon_family}) && function_exists('vc_icon_element_fonts_enqueue'))
            vc_icon_element_fonts_enqueue($icon_family); ?>

        <div class="lvca-service-wrapper <?php echo $column_style; ?>">

            <div class="lvca-service">

                <?php if ($icon_type == 'icon_image') : ?>

                    <div class="lvca-image-wrapper">

                        <?php echo wp_get_attachment_image($icon_image, 'full', false, array('class' => 'lvca-image full')); ?>

                    </div>

                <?php else : ?>

                    <?php if (!empty(${'icon_' . $icon_family})): ?>

                        <div class="lvca-icon-wrapper">

                            <?php echo lvca_get_icon(${'icon_' . $icon_family}); ?>

                        </div>

                    <?php endif; ?>

                <?php endif; ?>

                <div class="lvca-service-text">

                    <h3 class="lvca-title"><?php echo esc_html($title) ?></h3>

                    <?php if (!empty($content)): ?>

                        <div class="lvca-service-details"><?php echo wp_kses_post($content); ?></div>

                    <?php else: ?>

                        <div class="lvca-service-details"><?php echo wp_kses_post($excerpt); ?></div>

                    <?php endif; ?>

                </div>

            </div>

        </div>

        <?php
    }

    function map_vc_element() {
        if (function_exists("vc_map")) {

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Livemesh Services", "livemesh-vc-addons"),
                "base" => "lvca_services",
                "as_parent" => array('only' => 'lvca_service_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                "content_element" => true,
                "show_settings_on_create" => true,
                "category" => __("Livemesh VC Addons", "livemesh-vc-addons"),
                "is_container" => true,
                'description' => __('Display services in a column grid.', 'livemesh-vc-addons'),
                "js_view" => 'VcColumnView',
                "icon" => 'icon-lvca-services',
                "params" => array(
                    // add params same as with any other content element
                    array(
                        "type" => "dropdown",
                        "param_name" => "style",
                        "heading" => __("Choose Style", "livemesh-vc-addons"),
                        "description" => __("Choose the particular style of services you need", "livemesh-vc-addons"),
                        'value' => array(
                            __('Style 1', 'livemesh-vc-addons') => 'style1',
                            __('Style 2', 'livemesh-vc-addons') => 'style2',
                            __('Style 3', 'livemesh-vc-addons') => 'style3',
                        ),
                        'std' => 'style1',
                    ),
                    array(
                        "type" => "lvca_number",
                        "param_name" => "per_line",
                        "value" => 3,
                        "min" => 1,
                        "max" => 5,
                        "suffix" => '',
                        "heading" => __("Columns per row", "livemesh-vc-addons"),
                        "description" => __("The number of columns to display per row of the services", "livemesh-vc-addons")
                    ),
                ),
            ));


        }
    }


    function map_child_vc_element() {
        if (function_exists("vc_map")) {
            vc_map(array(
                    "name" => __("Livemesh Service", "my-text-domain"),
                    "base" => "lvca_service_item",
                    "content_element" => true,
                    "as_child" => array('only' => 'lvca_services'), // Use only|except attributes to limit parent (separate multiple values with comma)
                    "icon" => 'icon-lvca-service',
                    "params" => array(
                        // add params same as with any other content element
                        array(
                            'type' => 'textfield',
                            'param_name' => 'title',
                            "admin_label" => true,
                            'heading' => __('Title', 'livemesh-vc-addons'),
                            'description' => __('Title of the service.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'dropdown',
                            'param_name' => 'icon_type',
                            'heading' => __('Choose Icon Type', 'livemesh-vc-addons'),
                            'std' => 'icon',
                            'value' => array(
                                __('Icon', 'livemesh-vc-addons') => 'icon',
                                __('Icon Image', 'livemesh-vc-addons') => 'icon_image',
                            )
                        ),

                        array(
                            'type' => 'attach_image',
                            'param_name' => 'icon_image',
                            'heading' => __('Service Image.', 'livemesh-vc-addons'),
                            "dependency" => array('element' => "icon_type", 'value' => 'icon_image'),
                        ),

                        array(
                            'type' => 'dropdown',
                            'heading' => __('Icon library', 'livemesh-vc-addons'),
                            'value' => array(
                                __('Font Awesome', 'livemesh-vc-addons') => 'fontawesome',
                                __('Open Iconic', 'livemesh-vc-addons') => 'openiconic',
                                __('Typicons', 'livemesh-vc-addons') => 'typicons',
                                __('Entypo', 'livemesh-vc-addons') => 'entypo',
                                __('Linecons', 'livemesh-vc-addons') => 'linecons',
                            ),
                            'std' => 'fontawesome',
                            'param_name' => 'icon_family',
                            'description' => __('Select icon library.', 'livemesh-vc-addons'),
                            "dependency" => array('element' => "icon_type", 'value' => 'icon'),
                        ),
                        array(
                            'type' => 'iconpicker',
                            'heading' => __('Icon', 'livemesh-vc-addons'),
                            'param_name' => 'icon_fontawesome',
                            'value' => 'fa fa-info-circle',
                            'settings' => array(
                                'emptyIcon' => false,
                                // default true, display an "EMPTY" icon?
                                'iconsPerPage' => 4000,
                                // default 100, how many icons per/page to display
                            ),
                            'dependency' => array(
                                'element' => 'icon_family',
                                'value' => 'fontawesome',
                            ),
                            'description' => __('Select icon from library.', 'livemesh-vc-addons'),
                        ),
                        array(
                            'type' => 'iconpicker',
                            'heading' => __('Icon', 'livemesh-vc-addons'),
                            'param_name' => 'icon_openiconic',
                            'settings' => array(
                                'emptyIcon' => false,
                                // default true, display an "EMPTY" icon?
                                'type' => 'openiconic',
                                'iconsPerPage' => 4000,
                                // default 100, how many icons per/page to display
                            ),
                            'dependency' => array(
                                'element' => 'icon_family',
                                'value' => 'openiconic',
                            ),
                            'description' => __('Select icon from library.', 'livemesh-vc-addons'),
                        ),
                        array(
                            'type' => 'iconpicker',
                            'heading' => __('Icon', 'livemesh-vc-addons'),
                            'param_name' => 'icon_typicons',
                            'settings' => array(
                                'emptyIcon' => false,
                                // default true, display an "EMPTY" icon?
                                'type' => 'typicons',
                                'iconsPerPage' => 4000,
                                // default 100, how many icons per/page to display
                            ),
                            'dependency' => array(
                                'element' => 'icon_family',
                                'value' => 'typicons',
                            ),
                            'description' => __('Select icon from library.', 'livemesh-vc-addons'),
                        ),
                        array(
                            'type' => 'iconpicker',
                            'heading' => __('Icon', 'livemesh-vc-addons'),
                            'param_name' => 'icon_entypo',
                            'settings' => array(
                                'emptyIcon' => false,
                                // default true, display an "EMPTY" icon?
                                'type' => 'entypo',
                                'iconsPerPage' => 4000,
                                // default 100, how many icons per/page to display
                            ),
                            'dependency' => array(
                                'element' => 'icon_family',
                                'value' => 'entypo',
                            ),
                        ),
                        array(
                            'type' => 'iconpicker',
                            'heading' => __('Icon', 'livemesh-vc-addons'),
                            'param_name' => 'icon_linecons',
                            'settings' => array(
                                'emptyIcon' => false,
                                // default true, display an "EMPTY" icon?
                                'type' => 'linecons',
                                'iconsPerPage' => 4000,
                                // default 100, how many icons per/page to display
                            ),
                            'dependency' => array(
                                'element' => 'icon_family',
                                'value' => 'linecons',
                            ),
                            'description' => __('Select icon from library.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textarea_html',
                            'param_name' => 'content',
                            'heading' => __('Service description', 'livemesh-vc-addons'),
                            'description' => __('Provide a short description for the service', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textarea',
                            'param_name' => 'excerpt',
                            'heading' => __('Short description (field will be removed in future - move text to Service description)', 'livemesh-vc-addons'),
                            'description' => __('Provide a short description for the service ', 'livemesh-vc-addons'),
                            'group' => __('Deprecated' , 'livemesh-vc-addons')
                        ),

                    )
                )

            );

        }
    }

}

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_lvca_services extends WPBakeryShortCodesContainer {
    }
}
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_service_item extends WPBakeryShortCode {
    }
}