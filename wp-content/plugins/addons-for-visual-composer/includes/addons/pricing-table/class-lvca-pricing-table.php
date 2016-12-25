<?php

/*
Widget Name: Livemesh Pricing Table
Description: Display pricing plans in a multi-column grid.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/

class LVCA_Pricing_Table {

    protected $_per_line;

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_pricing_item', array($this, 'pricing_item_shortcode'));

        add_shortcode('lvca_pricing_table', array($this, 'shortcode_func'));

        add_shortcode('lvca_pricing_plan', array($this, 'child_shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

        add_action('init', array($this, 'map_child_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_style('lvca-pricing-table', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);

    }

    /* Should be used as child of lvca_pricing_table/lvca_pricing_plan shortcodes for right output buffering */
    public function pricing_item_shortcode($atts, $content = null, $tag) {

        $title = $value = '';

        extract(shortcode_atts(array(
            'title' => '',
            'value' => ''

        ), $atts));

       ?>

        <div class="lvca-pricing-item">

            <div class="lvca-title">

                <?php echo htmlspecialchars_decode(wp_kses_post($title)); ?>

            </div>

            <div class="lvca-value-wrap">

                <div class="lvca-value">

                    <?php echo htmlspecialchars_decode(wp_kses_post($value)); ?>

                </div>

            </div>

        </div>

        <?php
    }

    public function shortcode_func($atts, $content = null, $tag) {

        $per_line = $style = '';

        extract(shortcode_atts(array(
            'per_line' => '4',

        ), $atts));

        $this->_per_line = $per_line;

        ob_start();

        ?>

        <div class="lvca-pricing-table lvca-container">

            <?php

            do_shortcode($content);

            ?>

        </div>

        <?php

        $output = ob_get_clean();

        return $output;
    }

    public function child_shortcode_func($atts, $content = null, $tag) {

        $pricing_title = $tagline = $price_tag = $highlight = $button_text = $button_url = $button_new_window = $pricing_img = '';
        extract(shortcode_atts(array(
            'pricing_title' => '',
            'tagline' => '',
            'price_tag' => '',
            "highlight" => '',
            "button_text" => '',
            "button_url" => '#',
            "button_new_window" => '',
            "pricing_img" => '',

        ), $atts));

        $column_style = lvca_get_column_class(intval($this->_per_line));

        $price_tag = htmlspecialchars_decode(wp_kses_post($price_tag));

        if (function_exists('vc_build_link')) {
            $pricing_url = vc_build_link($button_url);
            $pricing_button = '<a class="lvca-button" href="' . $pricing_url['url'] . '" title="' . $pricing_url['title'] . '" target="' . $pricing_url['target'] . '">' . $button_text . '</a>';
        }
        else {
            $pricing_button = '<a class="lvca-button" href="' . $button_url . '" title="' . $pricing_title . '" target="_blank">' . $button_text . '</a>';
        }

        ?>

        <div
            class="lvca-pricing-plan <?php echo(!empty($highlight) ? ' lvca-highlight' : ''); ?> <?php echo $column_style; ?>">

            <div class="lvca-top-header">

                <?php if (!empty($tagline))
                    echo '<p class="lvca-tagline center">' . $tagline . '</p>'; ?>

                <h3 class="lvca-center"><?php echo $pricing_title; ?></h3>

                <?php

                if (!empty($pricing_img)) :
                    echo wp_get_attachment_image($pricing_img, 'full', false, array('class' => 'lvca-image full', 'alt' => $pricing_title));
                endif;

                ?>

            </div>

            <h4 class="lvca-plan-price lvca-plan-header lvca-center">

                <span class="lvca-text">

                    <?php echo wp_kses_post($price_tag); ?>

                </span>

            </h4>

            <div class="lvca-plan-details">

                <?php

                echo do_shortcode($content);

                ?>

            </div>
            <!-- .lvca-plan-details -->

            <div class="lvca-purchase">

                <?php echo $pricing_button; ?>

            </div>

        </div>
        <!-- .lvca-pricing-plan -->

    <?php
    }

    function map_vc_element() {
        if (function_exists("vc_map")) {

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Livemesh Pricing Table", "livemesh-vc-addons"),
                "base" => "lvca_pricing_table",
                "as_parent" => array('only' => 'lvca_pricing_plan'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                "content_element" => true,
                "show_settings_on_create" => true,
                "category" => __("Livemesh VC Addons", "livemesh-vc-addons"),
                "is_container" => true,
                'description' => __('Display pricing table in a multi-column grid.', 'livemesh-vc-addons'),
                "js_view" => 'VcColumnView',
                "icon" => 'icon-lvca-pricing-table',
                "params" => array(
                    // add params same as with any other content element
                    array(
                        "type" => "lvca_number",
                        "param_name" => "per_line",
                        "value" => 3,
                        "min" => 1,
                        "max" => 5,
                        "suffix" => '',
                        "heading" => __("Pricing Plans per row", "livemesh-vc-addons"),
                        "description" => __("The number of pricing plans to display per row of the pricing table", "livemesh-vc-addons")
                    ),
                ),
            ));


        }
    }


    function map_child_vc_element() {
        if (function_exists("vc_map")) {
            vc_map(array(
                    "name" => __("Livemesh Pricing Plan", "my-text-domain"),
                    "base" => "lvca_pricing_plan",
                    "content_element" => true,
                    "as_child" => array('only' => 'lvca_pricing_table'), // Use only|except attributes to limit parent (separate multiple values with comma)
                    "icon" => 'icon-lvca-pricing',
                    "params" => array(
                        // add params same as with any other content element
                        array(
                            'type' => 'textfield',
                            'param_name' => 'pricing_title',
                            'heading' => __('Pricing Plan Title', 'livemesh-vc-addons'),
                            'description' => __('The title for the pricing plan', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'tagline',
                            'heading' => __('Tagline Text', 'livemesh-vc-addons'),
                            'description' => __('Provide any subtitle or taglines like "Most Popular", "Best Value", "Best Selling", "Most Flexible" etc. that you would like to use for this pricing plan.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'attach_image',
                            'param_name' => 'pricing_img',
                            'heading' => __('Pricing Image', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'price_tag',
                            'heading' => __('Price Tag', 'livemesh-vc-addons'),
                            'description' => __('Enter the price tag for the pricing plan. HTML is accepted.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'checkbox',
                            'param_name' => 'highlight',
                            'heading' => __('Highlight Pricing Plan', 'livemesh-vc-addons'),
                            'description' => __('Specify if you want to highlight the pricing plan.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textarea_html',
                            'param_name' => 'content',
                            'heading' => __('Pricing Plan Details', 'livemesh-vc-addons'),
                            'description' => __('Enter the content for the pricing plan that include information about individual features of the pricing plan. For prebuilt styling, enter shortcodes content like - [lvca_pricing_item title="Storage Space" value="50 GB"] [lvca_pricing_item title="Video Uploads" value="50"][lvca_pricing_item title="Portfolio Items" value="20"]', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'button_text',
                            'heading' => __('Text for Pricing Link/Button', 'livemesh-vc-addons'),
                            'description' => __('Provide the text for the link or the button shown for this pricing plan.', 'livemesh-vc-addons'),
                            'group' => 'Pricing Link'
                        ),

                        array(
                            'type' => 'vc_link',
                            'param_name' => 'button_url',
                            'heading' => __('URL for the Pricing link/button', 'livemesh-vc-addons'),
                            'description' => __('Provide the target URL for the link or the button shown for this pricing plan.', 'livemesh-vc-addons'),
                            'group' => 'Pricing Link'
                        ),

                        array(
                            'type' => 'checkbox',
                            'param_name' => 'button_new_window',
                            'heading' => __('Open Button URL in a new window', 'livemesh-vc-addons'),
                            'group' => 'Pricing Link'
                        ),

                    )
                )

            );

        }
    }

}

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_lvca_pricing_table extends WPBakeryShortCodesContainer {
    }
}
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_pricing_plan extends WPBakeryShortCode {
    }
}