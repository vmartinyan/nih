<?php
/**
 * Plugin Name: Addons for Visual Composer
 * Plugin URI: http://portfoliotheme.org/visual-composer-addons
 * Description: A collection of premium quality addons or extensions for use in Visual Composer page builder. Visual composer must be installed and activated.
 * Author: Livemesh
 * Author URI: http://portfoliotheme.org/
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 * Version: 1.4
 * Text Domain: livemesh-vc-addons
 * Domain Path: languages
 *
 * Addons for Visual Composer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Addons for Visual Composer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Addons for Visual Composer. If not, see <http://www.gnu.org/licenses/>.
 *
 */

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

define('LVCA_BUNDLE_JS_SUFFIX', '.min');

if (!class_exists('Livemesh_VC_Addons')) :

    /**
     * Main Livemesh_VC_Addons Class
     *
     */
    final class Livemesh_VC_Addons {

        /** Singleton *************************************************************/

        private static $instance;

        /**
         * Main Livemesh_VC_Addons Instance
         *
         * Insures that only one instance of Livemesh_VC_Addons exists in memory at any one
         * time. Also prevents needing to define globals all over the place.
         */
        public static function instance() {
            if (!isset(self::$instance) && !(self::$instance instanceof Livemesh_VC_Addons)) {

                self::$instance = new Livemesh_VC_Addons;

                self::$instance->setup_constants();

                add_action('plugins_loaded', array(self::$instance, 'load_plugin_textdomain'));

                add_action('plugins_loaded', array(self::$instance, 'includes'));

                add_action('plugins_loaded', array(self::$instance, 'setup'));

                self::$instance->hooks();

            }
            return self::$instance;
        }

        /**
         * Throw error on object clone
         *
         * The whole idea of the singleton design pattern is that there is a single
         * object therefore, we don't want the object to be cloned.
         */
        public function __clone() {
            // Cloning instances of the class is forbidden
            _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'livemesh-vc-addons'), '1.6');
        }

        /**
         * Disable unserializing of the class
         *
         */
        public function __wakeup() {
            // Unserializing instances of the class is forbidden
            _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'livemesh-vc-addons'), '1.6');
        }

        /**
         * Setup plugin constants
         *
         */
        private function setup_constants() {

            // Plugin version
            if (!defined('LVCA_VERSION')) {
                define('LVCA_VERSION', '1.4');
            }

            // Plugin Folder Path
            if (!defined('LVCA_PLUGIN_DIR')) {
                define('LVCA_PLUGIN_DIR', plugin_dir_path(__FILE__));
            }

            // Plugin Folder Path
            if (!defined('LVCA_ADDONS_DIR')) {
                define('LVCA_ADDONS_DIR', plugin_dir_path(__FILE__) . 'includes/addons/');
            }

            // Plugin Folder URL
            if (!defined('LVCA_PLUGIN_URL')) {
                define('LVCA_PLUGIN_URL', plugin_dir_url(__FILE__));
            }

            // Plugin Root File
            if (!defined('LVCA_PLUGIN_FILE')) {
                define('LVCA_PLUGIN_FILE', __FILE__);
            }
        }

        /**
         * Include required files
         *
         */
        public function includes() {

            require_once LVCA_PLUGIN_DIR . 'includes/helper-functions.php';
            require_once LVCA_PLUGIN_DIR . 'includes/mapper-functions.php';

            require_once LVCA_ADDONS_DIR . 'accordion/class-lvca-accordion.php';
            require_once LVCA_ADDONS_DIR . 'carousel/class-lvca-carousel.php';
            require_once LVCA_ADDONS_DIR . 'clients/class-lvca-clients.php';
            require_once LVCA_ADDONS_DIR . 'heading/class-lvca-heading.php';
            require_once LVCA_ADDONS_DIR . 'spacer/class-lvca-spacer.php';
            require_once LVCA_ADDONS_DIR . 'odometers/class-lvca-odometers.php';
            require_once LVCA_ADDONS_DIR . 'piecharts/class-lvca-piecharts.php';
            require_once LVCA_ADDONS_DIR . 'portfolio/class-lvca-portfolio.php';
            require_once LVCA_ADDONS_DIR . 'posts-carousel/class-lvca-posts-carousel.php';
            require_once LVCA_ADDONS_DIR . 'pricing-table/class-lvca-pricing-table.php';
            require_once LVCA_ADDONS_DIR . 'services/class-lvca-services.php';
            require_once LVCA_ADDONS_DIR . 'stats-bar/class-lvca-stats-bar.php';
            require_once LVCA_ADDONS_DIR . 'tabs/class-lvca-tabs.php';
            require_once LVCA_ADDONS_DIR . 'team/class-lvca-team.php';
            require_once LVCA_ADDONS_DIR . 'testimonials/class-lvca-testimonials.php';
            require_once LVCA_ADDONS_DIR . 'testimonials-slider/class-lvca-testimonials-slider.php';


            require_once LVCA_PLUGIN_DIR . 'includes/params/number/class-lvca-number-param.php';

        }

        /* Setup all addons with their shortcodes and VC Mappings */
        public function setup() {

            /* Custom VC Elements */
            new LVCA_Accordion();
            new LVCA_Carousel();
            new LVCA_Clients();
            new LVCA_Heading();
            new LVCA_Spacer();
            new LVCA_Odometers();
            new LVCA_Piecharts();
            new LVCA_Portfolio();
            new LVCA_Posts_Carousel();
            new LVCA_Pricing_Table();
            new LVCA_Services();
            new LVCA_Stats_Bars();
            new LVCA_Tabs();
            new LVCA_Team();
            new LVCA_Testimonials();
            new LVCA_Testimonials_Slider();

            /* Custom VC Param Types */
            new LVCA_Number_Param();

        }

        /**
         * Load Plugin Text Domain
         *
         * Looks for the plugin translation files in certain directories and loads
         * them to allow the plugin to be localised
         */
        public function load_plugin_textdomain() {

            $lang_dir = apply_filters('lvca_vc_addons_lang_dir', trailingslashit(LVCA_PLUGIN_DIR . 'languages'));

            // Traditional WordPress plugin locale filter
            $locale = apply_filters('plugin_locale', get_locale(), 'livemesh-vc-addons');
            $mofile = sprintf('%1$s-%2$s.mo', 'livemesh-vc-addons', $locale);

            // Setup paths to current locale file
            $mofile_local = $lang_dir . $mofile;

            if (file_exists($mofile_local)) {
                // Look in the /wp-content/plugins/livemesh-vc-addons/languages/ folder
                load_textdomain('livemesh-vc-addons', $mofile_local);
            }
            else {
                // Load the default language files
                load_plugin_textdomain('livemesh-vc-addons', false, $lang_dir);
            }

            return false;
        }

        /**
         * Setup the default hooks and actions
         */
        private function hooks() {

            add_action('admin_enqueue_scripts', array($this, 'load_admin_scripts'), 100);

            add_action('wp_enqueue_scripts', array($this, 'load_frontend_scripts'), 100);

            add_action('init', array($this, 'modify_existing_mappings'), 100);

            // Filter to replace default css class names for vc_row shortcode and vc_column
            add_filter('vc_shortcodes_css_class', array($this, 'custom_css_classes_for_vc_row'), 10, 3);

        }


        /**
         * Load Frontend Scripts/Styles
         *
         */
        public function load_frontend_scripts() {


            wp_register_style('lvca-frontend-styles', LVCA_PLUGIN_URL . 'assets/css/lvca-frontend.css', array(), LVCA_VERSION);
            wp_enqueue_style('lvca-frontend-styles');

            wp_register_style('lvca-icomoon-styles', LVCA_PLUGIN_URL . 'assets/css/icomoon.css', array(), LVCA_VERSION);
            wp_enqueue_style('lvca-icomoon-styles');

            wp_register_script('lvca-frontend-scripts', LVCA_PLUGIN_URL . 'assets/js/lvca-frontend' . LVCA_BUNDLE_JS_SUFFIX . '.js', array(), LVCA_VERSION, true);
            wp_enqueue_script('lvca-frontend-scripts');

        }

        /**
         * Load Admin Scripts/Styles
         *
         */
        public function load_admin_scripts() {

            wp_register_style('lvca-admin-styles', LVCA_PLUGIN_URL . 'assets/css/lvca-admin.css', array(), LVCA_VERSION);
            wp_enqueue_style('lvca-admin-styles');

            wp_register_script('lvca-admin-scripts', LVCA_PLUGIN_URL . 'assets/js/lvca-admin' . LVCA_BUNDLE_JS_SUFFIX . '.js', array(), LVCA_VERSION, true);
            wp_enqueue_script('lvca-admin-scripts');

            wp_enqueue_script('jquery-ui-datepicker');
        }

        /**
         * Load Admin Scripts/Styles
         *
         */
        function modify_existing_mappings() {
            $attributes = array(
                'type' => 'checkbox',
                'heading' => "Dark Background?",
                'param_name' => 'lvca_dark_bg',
                "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                'description' => __("Indicate if this row has a dark background color. Dark color scheme will be applied for all elements in this row.", "livemesh-vc-addons")
            );

            if (function_exists('vc_add_param')) {
                vc_add_param('vc_row', $attributes);
                vc_add_param('vc_row_inner', $attributes);
            }
        }

        /**
         * Load Admin Scripts/Styles
         * Take care of situations where themes do not pass the atts value to the filter
         */
        function custom_css_classes_for_vc_row($class_string, $tag, $atts = null) {

            if (!empty($atts)) {
                if ($tag == 'vc_row' || $tag == 'vc_row_inner') {
                    if (isset($atts['lvca_dark_bg']) && ($atts['lvca_dark_bg'] == 'true'))
                        $class_string .= ' lvca-dark-bg';
                }
            }
            return $class_string;
        }

    }

endif; // End if class_exists check


/**
 * The main function responsible for returning the one true Livemesh_VC_Addons
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $lvca = LVCA(); ?>
 */
function LVCA() {
    return Livemesh_VC_Addons::instance();
}

// Get LVCA Running
LVCA();