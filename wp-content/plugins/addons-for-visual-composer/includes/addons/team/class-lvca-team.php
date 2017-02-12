<?php

/*
Widget Name: Livemesh Team Members
Description: Display a list of your team members optionally in a multi-column grid.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/


class LVCA_Team {

    protected $_per_line;
    protected $_style;

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_team', array($this, 'shortcode_func'));

        add_shortcode('lvca_team_member', array($this, 'child_shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

        add_action('init', array($this, 'map_child_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_style('lvca-team-members', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);

    }

    public function shortcode_func($atts, $content = null, $tag) {

        $per_line = $style = '';

        extract(shortcode_atts(array(
            'per_line' => '3',
            'style' => 'style1',

        ), $atts));

        $this->_per_line = $per_line;
        $this->_style = $style;

        ob_start();

        ?>

        <div class="lvca-team-members lvca-<?php echo $style; ?> lvca-container">

            <?php

            do_shortcode($content);

            ?>

        </div>

        <?php

        $output = ob_get_clean();

        return $output;
    }

    public function child_shortcode_func($atts, $content = null, $tag) {

        $member_name = $member_image = $member_details = $member_position = $member_email = '';
        extract(shortcode_atts(array(
            'member_name' => '',
            'member_image' => '',
            'member_details' => '',
            "member_position" => '',
            'member_email' => false,
            'facebook_url' => false,
            'twitter_url' => false,
            'flickr_url' => false,
            'youtube_url' => false,
            'linkedin_url' => false,
            'googleplus_url' => false,
            'vimeo_url' => false,
            'instagram_url' => false,
            'behance_url' => false,
            'pinterest_url' => false,
            'skype_url' => false,
            'dribbble_url' => false,

        ), $atts));

        $style = $this->_style;

        $column_style = '';

        if ($style == 'style1') {
            $column_style = lvca_get_column_class(intval($this->_per_line));
        }
        
        ?>

        <div class="lvca-team-member-wrapper <?php echo $column_style; ?>">

            <div class="lvca-team-member">

                <div class="lvca-image-wrapper">

                    <?php echo wp_get_attachment_image($member_image, 'full', false, array('class' => 'lvca-image full')); ?>

                    <?php if ($style == 'style1'): ?>

                        <?php include 'social-profile.php'; ?>

                    <?php endif; ?>

                </div>

                <div class="lvca-team-member-text">

                    <h3 class="lvca-title"><?php echo esc_html($member_name) ?></h3>

                    <div class="lvca-team-member-position">

                        <?php echo esc_html($member_position) ?>

                    </div>

                    <div class="lvca-team-member-details">

                        <?php echo wp_kses_post($member_details) ?>

                    </div>

                    <?php if ($style == 'style2'): ?>

                        <?php include 'social-profile.php'; ?>

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
                "name" => __("Livemesh Team", "livemesh-vc-addons"),
                "base" => "lvca_team",
                "as_parent" => array('only' => 'lvca_team_member'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                "content_element" => true,
                "show_settings_on_create" => true,
                "category" => __("Livemesh VC Addons", "livemesh-vc-addons"),
                "is_container" => true,
                'description' => __('Create team members.', 'livemesh-vc-addons'),
                "js_view" => 'VcColumnView',
                "icon" => 'icon-lvca-team',
                "params" => array(
                    // add params same as with any other content element
                    array(
                        "type" => "dropdown",
                        "param_name" => "style",
                        "heading" => __("Choose Style", "livemesh-vc-addons"),
                        "description" => __("Choose the particular style of team you need", "livemesh-vc-addons"),
                        'value' => array(
                            __('Style 1', 'livemesh-vc-addons') => 'style1',
                            __('Style 2', 'livemesh-vc-addons') => 'style2',
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
                        "description" => __("The number of team members to display per row of the team", "livemesh-vc-addons"),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => 'style1',
                        ),
                    ),
                ),
            ));


        }
    }


    function map_child_vc_element() {
        if (function_exists("vc_map")) {
            vc_map(array(
                    "name" => __("Livemesh Team Member", "my-text-domain"),
                    "base" => "lvca_team_member",
                    "content_element" => true,
                    "as_child" => array('only' => 'lvca_team'), // Use only|except attributes to limit parent (separate multiple values with comma)
                    "icon" => 'icon-lvca-team-member',
                    "category" => __('Team', 'livemesh-vc-addons'),
                    "params" => array(
                        // add params same as with any other content element
                        array(
                            'type' => 'textfield',
                            'param_name' => 'member_name',
                            "admin_label" => true,
                            'heading' => __('Team Member Name', 'livemesh-vc-addons'),
                            'description' => __('Name of the team member.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'attach_image',
                            'param_name' => 'member_image',
                            'heading' => __('Team Member Image.', 'livemesh-vc-addons'),
                        ),
                        array(
                            'type' => 'textfield',
                            'param_name' => 'member_position',
                            'heading' => __('Position', 'livemesh-vc-addons'),
                            'description' => __('Specify the position/title of the team member.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textarea',
                            'param_name' => 'member_details',
                            'heading' => __('Short details', 'livemesh-vc-addons'),
                            'description' => __('Provide a short writeup for the team member', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'member_email',
                            'group' => __('Social Profile', 'livemesh-vc-addons'),
                            'heading' => __('Email Address', 'livemesh-vc-addons'),
                            'description' => __('Enter the email address of the team member.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'facebook_url',
                            'group' => __('Social Profile', 'livemesh-vc-addons'),
                            'heading' => __('Facebook Page URL', 'livemesh-vc-addons'),
                            'description' => __('URL of the Facebook page of the team member.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'twitter_url',
                            'group' => __('Social Profile', 'livemesh-vc-addons'),
                            'heading' => __('Twitter Profile URL', 'livemesh-vc-addons'),
                            'description' => __('URL of the Twitter page of the team member.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'linkedin_url',
                            'group' => __('Social Profile', 'livemesh-vc-addons'),
                            'heading' => __('LinkedIn Page URL', 'livemesh-vc-addons'),
                            'description' => __('URL of the LinkedIn profile of the team member.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'pinterest_url',
                            'group' => __('Social Profile', 'livemesh-vc-addons'),
                            'heading' => __('Pinterest Page URL', 'livemesh-vc-addons'),
                            'description' => __('URL of the Pinterest page for the team member.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'dribbble_url',
                            'group' => __('Social Profile', 'livemesh-vc-addons'),
                            'heading' => __('Dribbble Profile URL', 'livemesh-vc-addons'),
                            'description' => __('URL of the Dribbble profile of the team member.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'google_plus_url',
                            'group' => __('Social Profile', 'livemesh-vc-addons'),
                            'heading' => __('GooglePlus Page URL', 'livemesh-vc-addons'),
                            'description' => __('URL of the Google Plus page of the team member.', 'livemesh-vc-addons'),
                        ),

                        array(
                            'type' => 'textfield',
                            'param_name' => 'instagram_url',
                            'group' => __('Social Profile', 'livemesh-vc-addons'),
                            'heading' => __('Instagram Page URL', 'livemesh-vc-addons'),
                            'description' => __('URL of the Instagram feed for the team member.', 'livemesh-vc-addons'),
                        ),
                    )
                )

            );

        }
    }

}

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_lvca_team extends WPBakeryShortCodesContainer {
    }
}
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_team_member extends WPBakeryShortCode {
    }
}