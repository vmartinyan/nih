<?php

/*
Widget Name: Livemesh Tabs
Description: Display tabbed content in variety of styles.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/


class LVCA_Tabs {

    protected $_tab_style;
    protected $_tab_elements;
    protected $_tab_panes;

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_tabs', array($this, 'shortcode_func'));

        add_shortcode('lvca_tab', array($this, 'child_shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

        add_action('init', array($this, 'map_child_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_script('lvca-tabs', plugin_dir_url(__FILE__) . 'js/tabs' . LVCA_BUNDLE_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_style('lvca-tabs', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);
    }

    public function shortcode_func($atts, $content = null, $tag) {

        $style = $mobile_width = $highlight_color = '';

        extract(shortcode_atts(array(
            'style' => 'style1',
            'mobile_width' => '767',
            'highlight_color' => '#f94213'
        ), $atts));

        // Imp: Helps to reset tabs collection when multiple tabs are present in the page
        $this->_tab_style = $style;
        $this->_tab_elements = array();
        $this->_tab_panes = array();

        $vertical_class = '';

        $vertical_styles = array('style7', 'style8', 'style9', 'style10');

        if (in_array($style, $vertical_styles, true)):

            $vertical_class = 'lvca-vertical';

        endif;

        do_shortcode($content); // let the child tabs get instantiated

        $uniqueid = uniqid();

        ob_start();

        ?>

        <div id="lvca-tabs-<?php echo $uniqueid; ?>"
             class="lvca-tabs <?php echo $vertical_class; ?> lvca-<?php echo esc_attr($style); ?>"
             data-mobile-width="<?php echo intval($mobile_width); ?>">

            <a href="#" class="lvca-tab-mobile-menu"><i class="lvca-icon-menu"></i>&nbsp;</a>

            <div class="lvca-tab-nav">

                <?php

                foreach ($this->_tab_elements as $tab_nav) :

                    echo $tab_nav;

                endforeach;

                ?>

            </div>

            <div class="lvca-tab-panes">

                <?php

                foreach ($this->_tab_panes as $tab_pane) :

                    echo $tab_pane;

                endforeach;

                ?>

            </div>

        </div>

        <?php $highlight_styles = array('style4', 'style6', 'style7', 'style8'); ?>

        <?php if (in_array($style, $highlight_styles, true)): ?>

            <style type="text/css">

                <?php if ($style == 'style4'): ?>

                #lvca-tabs-<?php echo $uniqueid; ?>.lvca-style4 .lvca-tab-nav .lvca-tab.lvca-active:before {
                    background: <?php echo $highlight_color; ?>;
                    }
                #lvca-tabs-<?php echo $uniqueid; ?>.lvca-style4.lvca-mobile-layout.lvca-mobile-open .lvca-tab.lvca-active {
                    border-left-color: <?php echo $highlight_color; ?>;
                    border-right-color: <?php echo $highlight_color; ?>;
                    }
                <?php elseif ($style == 'style6'): ?>

                #lvca-tabs-<?php echo $uniqueid; ?>.lvca-style6 .lvca-tab-nav .lvca-tab.lvca-active a {
                    border-color: <?php echo $highlight_color; ?>;
                    }
                <?php elseif ($style == 'style7'): ?>

                #lvca-tabs-<?php echo $uniqueid; ?>.lvca-style7 .lvca-tab-nav .lvca-tab.lvca-active a {
                    border-color: <?php echo $highlight_color; ?>;
                    }
                <?php elseif ($style == 'style8'): ?>

                #lvca-tabs-<?php echo $uniqueid; ?>.lvca-style8 .lvca-tab-nav .lvca-tab.lvca-active a {
                    border-left-color: <?php echo $highlight_color; ?>;
                    }
                <?php endif; ?>

            </style>

        <?php endif; ?>

        <?php

        $output = ob_get_clean();

        return $output;
    }

    public function child_shortcode_func($atts, $content = null, $tag) {

        $tab_title = $percentage = $icon_image = $icon_type = $icon_family = '';

        extract(shortcode_atts(array(
            'tab_title' => '',
            'icon_type' => 'none',
            'icon_image' => '',
            'icon_family' => 'fontawesome',
            "icon_fontawesome" => '',
            "icon_openiconic" => '',
            "icon_typicons" => '',
            "icon_entypo" => '',
            "icon_linecons" => '',

        ), $atts));

        $icon_type = esc_html($icon_type);

        if ($icon_type == 'icon' && !empty(${'icon_' . $icon_family}) && function_exists('vc_icon_element_fonts_enqueue'))
            vc_icon_element_fonts_enqueue($icon_family);

        $plain_styles = array('style2', 'style6', 'style7');

        if (in_array($this->_tab_style, $plain_styles, true)):

            $icon_type = 'none'; // do not display icons for plain styles even if chosen by the user

        endif;


        $tab_id = sanitize_title_with_dashes($tab_title) . '-' . uniqid();

        $tab_element = '<a href="#' . $tab_id . '">';

        if ($icon_type == 'icon_image') :

            $tab_element .= '<span class="lvca-image-wrapper">';

            $tab_element .= wp_get_attachment_image($icon_image, 'thumbnail', false, array('class' => 'lvca-image'));

            $tab_element .= '</span>';

        elseif ($icon_type == 'icon' && !empty(${'icon_' . $icon_family})) :

            $tab_element .= '<span class="lvca-icon-wrapper">';

            $tab_element .= lvca_get_icon(${'icon_' . $icon_family});

            $tab_element .= '</span>';

        endif;

        $tab_element .= '<span class="lvca-tab-title">';

        $tab_element .= esc_html($tab_title);

        $tab_element .= '</span>';

        $tab_element .= '</a>';

        $tab_nav = '<div class="lvca-tab">' . $tab_element . '</div>';

        $tab_content = '<div id="' . $tab_id . '" class="lvca-tab-pane">' . do_shortcode($content) . '</div>';

        $this->_tab_elements[] = $tab_nav;
        $this->_tab_panes[] = $tab_content;

    }

    function map_vc_element() {
        if (function_exists("vc_map")) {

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Livemesh Tabs", "livemesh-vc-addons"),
                "base" => "lvca_tabs",
                "as_parent" => array('only' => 'lvca_tab'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                "content_element" => true,
                "show_settings_on_create" => false,
                "category" => __("Livemesh VC Addons", "livemesh-vc-addons"),
                "is_container" => true,
                'description' => __('Display tabbed content in variety of styles.', 'livemesh-vc-addons'),
                "js_view" => 'VcColumnView',
                "icon" => 'icon-lvca-tabs',
                "params" => array(

                    array(
                        "type" => "dropdown",
                        "param_name" => "style",
                        "heading" => __("Choose Tab Style", "livemesh-vc-addons"),
                        "description" => __("Choose the particular style of tabs you need", "livemesh-vc-addons"),
                        'value' => array(
                            __('Style 1', 'livemesh-vc-addons') => 'style1',
                            __('Style 2', 'livemesh-vc-addons') => 'style2',
                            __('Style 3', 'livemesh-vc-addons') => 'style3',
                            __('Style 4', 'livemesh-vc-addons') => 'style4',
                            __('Style 5', 'livemesh-vc-addons') => 'style5',
                            __('Style 6', 'livemesh-vc-addons') => 'style6',
                            __('Vertical Style 1', 'livemesh-vc-addons') => 'style7',
                            __('Vertical Style 2', 'livemesh-vc-addons') => 'style8',
                            __('Vertical Style 3', 'livemesh-vc-addons') => 'style9',
                            __('Vertical Style 4', 'livemesh-vc-addons') => 'style10'
                        ),
                        'std' => 'style1',
                        "admin_label" => true,
                    ),

                    array(
                        'type' => 'colorpicker',
                        'param_name' => 'highlight_color',
                        'heading' => __('Tab Highlight color', 'livemesh-vc-addons'),
                        'value' => '#f94213',
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('style4', 'style6', 'style7', 'style8')
                        ),
                    ),

                    array(
                        "type" => "lvca_number",
                        "heading" => __("Mobile Resolution", "livemesh-vc-addons"),
                        "description" => __("The resolution to treat as a mobile resolution for invoking responsive tabs.", "livemesh-vc-addons"),
                        "param_name" => "mobile_width",
                        "value" => 600,
                        "min" => 320,
                        "max" => 1400,
                        "suffix" => "px",
                    ),

                ),
            ));


        }
    }

    function map_child_vc_element() {
        if (function_exists("vc_map")) {
            vc_map(array(
                    "name" => __("Livemesh Tab", "my-text-domain"),
                    "base" => "lvca_tab",
                    "content_element" => true,
                    "as_child" => array('only' => 'lvca_tabs'), // Use only|except attributes to limit parent (separate multiple values with comma)
                    "icon" => 'icon-lvca-tab',
                    "params" => array(
                        // add params same as with any other content element
                        array(
                            'type' => 'textfield',
                            'param_name' => 'tab_title',
                            "admin_label" => true,
                            'heading' => __('Tab Title', 'livemesh-vc-addons'),
                            'description' => __('The title for the tab shown as name for tab navigation.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'dropdown',
                            'param_name' => 'icon_type',
                            'heading' => __('Choose Tab Icon Type or None', 'livemesh-vc-addons'),
                            'heading' => __('Some styles may ignore icons chosen.', 'livemesh-vc-addons'),
                            'std' => 'none',
                            'value' => array(
                                __('None', 'livemesh-vc-addons') => 'none',
                                __('Icon', 'livemesh-vc-addons') => 'icon',
                                __('Icon Image', 'livemesh-vc-addons') => 'icon_image',
                            )
                        ),

                        array(
                            'type' => 'attach_image',
                            'param_name' => 'icon_image',
                            'heading' => __('Tab Image.', 'livemesh-vc-addons'),
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
                            'heading' => __('Tab Icon', 'livemesh-vc-addons'),
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
                            'heading' => __('Tab Content', 'livemesh-vc-addons'),
                            'description' => __('The content of the tab.', 'livemesh-vc-addons'),
                        ),

                    )
                )

            );

        }
    }

}

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_lvca_tabs extends WPBakeryShortCodesContainer {
    }
}
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_tab extends WPBakeryShortCode {
    }
}