<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 13/08/15
 * Time: 10:20 AM
 */

if(!class_exists('SV_PluginsImporter'))
{
    class SV_PluginsImporter
    {
        static $_dir;
        static $_url;
        static $_import_path;
        static $_package='data';
        static $_import_page='admin.php?page=svp_importer';
        static $_import_url='';
        static function init()
        {
            self::$_dir=plugin_dir_path(__FILE__);
            self::$_url=plugin_dir_url(__FILE__);
            self::$_import_path=get_template_directory().'/data-import';
            self::$_import_url=get_template_directory_uri().'/data-import';


            if(isset($_REQUEST['package']) and $_REQUEST['package']){
                self::$_package=$_REQUEST['package'];
            }



            add_action('admin_menu',array(__CLASS__,'_add_sub_menu'),50);
            add_action('admin_enqueue_scripts',array(__CLASS__,'_add_import_js'));

        }

        static function load_lib()
        {

            if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true); // we are loading importers
            if ( ! class_exists( 'WP_Importer' ) ) { // if main importer class doesn't exist
                $wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
                include $wp_importer;
            }
            if ( ! class_exists('WP_Import') ) { // if WP importer doesn't exist
                $wp_import = self::$_dir. '/wordpress-importer.php';
                if(file_exists($wp_import))
                    include $wp_import;
            }
        }

        static function _add_import_js()
        {
            $screen=get_current_screen();
            if($screen->base=='theme-option_page_svp_importer'){
                wp_enqueue_script('svp_importer_js',self::$_url.'/js/import.js');

                wp_localize_script('jquery','svp_importer',array(
                    'admin_url'=>admin_url(),
                    'loading_src'=>self::$_url.'images/loading.gif'
                ));
            }
        }
        static function _add_sub_menu()
        {

            add_submenu_page(apply_filters( 'ot_theme_options_menu_slug', 'ot-theme-options' ),__('Import Demo Content',STP_TEXTDOMAIN),__('Import Demo Content',STP_TEXTDOMAIN),'manage_options','svp_importer',array(__CLASS__,'_show_import_page'));


        }
        static function _show_import_page()
        {
            $file=locate_template('st_templates/import.php');

            if(!$file){
                $file=self::$_dir.'/views/import.php';
            }

            if(file_exists($file)){
                include $file;
            }

        }
        static function wie_import_data( $data ) {
            global $wp_registered_sidebars;
            // Have valid data?
            // If no data or could not decode
            if ( empty( $data ) || ! is_object( $data ) ) {
                return;
                // wp_die(
                //     __( 'Import data could not be read. Please try a different file.', 'widget-importer-exporter' ),
                //     '',
                //     array( 'back_link' => true )
                // );
            }
            // Hook before import
            do_action( 'wie_before_import' );
            $data = apply_filters( 'wie_import_data', $data );
            // Get all available widgets site supports
            $available_widgets =self::wie_available_widgets();
            // Get all existing widget instances
            $widget_instances = array();
            foreach ( $available_widgets as $widget_data ) {
                $widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
            }
            // Begin results
            $results = array();
            // Loop import data's sidebars
            foreach ( $data as $sidebar_id => $widgets ) {
                // Skip inactive widgets
                // (should not be in export file)
                if ( 'wp_inactive_widgets' == $sidebar_id ) {
                    continue;
                }
                // Check if sidebar is available on this site
                // Otherwise add widgets to inactive, and say so
                if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
                    self::remove_all_widgets_from_sidebar($sidebar_id);
                    $sidebar_available = true;
                    $use_sidebar_id = $sidebar_id;
                    $sidebar_message_type = 'success';
                    $sidebar_message = '';
                } else {
                    $sidebar_available = false;
                    $use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
                    $sidebar_message_type = 'error';
                    $sidebar_message = __( 'Sidebar does not exist in theme (using Inactive)', 'widget-importer-exporter' );
                }
                // Result for sidebar
                $results[$sidebar_id]['name'] = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
                $results[$sidebar_id]['message_type'] = $sidebar_message_type;
                $results[$sidebar_id]['message'] = $sidebar_message;
                $results[$sidebar_id]['widgets'] = array();
                // Loop widgets
                foreach ( $widgets as $widget_instance_id => $widget ) {
                    $fail = false;
                    // Get id_base (remove -# from end) and instance ID number
                    $id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
                    $instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );
                    // Does site support this widget?
                    if ( ! $fail && ! isset( $available_widgets[$id_base] ) ) {
                        $fail = true;
                        $widget_message_type = 'error';
                        $widget_message = __( 'Site does not support widget', 'widget-importer-exporter' ); // explain why widget not imported
                    }
                    // Filter to modify settings before import
                    // Do before identical check because changes may make it identical to end result (such as URL replacements)
                    $widget = apply_filters( 'wie_widget_settings', $widget );
                    // Does widget with identical settings already exist in same sidebar?
                    if ( ! $fail && isset( $widget_instances[$id_base] ) ) {
                        // Get existing widgets in this sidebar
                        $sidebars_widgets = get_option( 'sidebars_widgets' );
                        $sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go
                        // Loop widgets with ID base
                        $single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
                        foreach ( $single_widget_instances as $check_id => $check_widget ) {
                            // Is widget in same sidebar and has identical settings?
                            if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {
                                $fail = true;
                                $widget_message_type = 'warning';
                                $widget_message = __( 'Widget already exists', 'widget-importer-exporter' ); // explain why widget not imported
                                break;
                            }

                        }
                    }
                    // No failure
                    if ( ! $fail ) {
                        // Add widget instance
                        $single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
                        $single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
                        $single_widget_instances[] = (array) $widget; // add it
                        // Get the key it was given
                        end( $single_widget_instances );
                        $new_instance_id_number = key( $single_widget_instances );
                        // If key is 0, make it 1
                        // When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
                        if ( '0' === strval( $new_instance_id_number ) ) {
                            $new_instance_id_number = 1;
                            $single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
                            unset( $single_widget_instances[0] );
                        }
                        // Move _multiwidget to end of array for uniformity
                        if ( isset( $single_widget_instances['_multiwidget'] ) ) {
                            $multiwidget = $single_widget_instances['_multiwidget'];
                            unset( $single_widget_instances['_multiwidget'] );
                            $single_widget_instances['_multiwidget'] = $multiwidget;
                        }
                        // Update option with new widget
                        update_option( 'widget_' . $id_base, $single_widget_instances );
                        // Assign widget instance to sidebar
                        $sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
                        $new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
                        $sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
                        update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data
                        // Success message
                        if ( $sidebar_available ) {
                            $widget_message_type = 'success';
                            $widget_message = __( 'Imported', 'widget-importer-exporter' );
                        } else {
                            $widget_message_type = 'warning';
                            $widget_message = __( 'Imported to Inactive', 'widget-importer-exporter' );
                        }
                    }
                    // Result for widget instance
                    $results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
                    $results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = (isset($widget->title) and  $widget->title) ? $widget->title : __( 'No Title', 'widget-importer-exporter' ); // show "No Title" if widget instance is untitled
                    $results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
                    $results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;
                }
            }
            // Hook after import
            do_action( 'wie_after_import' );
            // Return results
            return apply_filters( 'wie_import_results', $results );
        }
        static function wie_available_widgets() {
            global $wp_registered_widget_controls;
            $widget_controls = $wp_registered_widget_controls;
            $available_widgets = array();
            foreach ( $widget_controls as $widget ) {
                if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes
                    $available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
                    $available_widgets[$widget['id_base']]['name'] = $widget['name'];
                }

            }
            return apply_filters( 'wie_available_widgets', $available_widgets );
        }
        static function remove_all_widgets_from_sidebar($sidebar_id)
        {
            $old_sidebar=get_option('sidebars_widgets',array());
            if(isset($old_sidebar[$sidebar_id]))
            {
                $old_sidebar[$sidebar_id]=array();
            }

            update_option('sidebars_widgets',$old_sidebar);
        }
    }

    SV_PluginsImporter::init();
}

