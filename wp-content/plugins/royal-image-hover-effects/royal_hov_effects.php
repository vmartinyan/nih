<?php
/*
Plugin Name: Royal Image Hover Effects
Plugin URI: http://codecans.com
Description: Royal Image Hover Effects is an impressive, lightweight, responsive Image hover effects. Fully powered by pure CSS3. 63+ Different Hover Effects Collections with choosing 3 styles. Apply Royal Image hover effects on your website without any CSS coding knowledge.
Author: codecans
Author URI: http://codecans.com
Version: 4.1.2
*/

//Loading CSS
function rd_css3_hov_style() {
	wp_enqueue_style( 'royal-layout', plugins_url( '/css/layout.css', __FILE__ ) );
	wp_enqueue_style( 'royal-main-style', plugins_url( '/css/main-style.css', __FILE__ ) );
	wp_enqueue_style( 'royal-style-effects', plugins_url( '/css/rd-style-effects.css', __FILE__ ) );
	wp_enqueue_style( 'royal-responsive-gird', plugins_url( '/css/main-responsive.css', __FILE__ ) );
	wp_enqueue_style( 'royal-font_awesome_style', esc_url_raw( 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' ), array(), null );
}
add_action( 'wp_enqueue_scripts', 'rd_css3_hov_style' );

// Added Admin Font Awesome
function royal_image_admin_enqueue_add_init() {
    if ( is_admin() ) {
		wp_enqueue_style( 'royal_image_master_font_fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', __FILE__ );
    }
}
add_action( 'admin_enqueue_scripts', 'royal_image_admin_enqueue_add_init' );


// added widgets filters
add_filter( 'widget_text', 'do_shortcode' );

// VAF Framework Loading
if ( ! class_exists( 'VP_rdcss3AutoLoader' ) ) {
	defined( 'VP_CSSHOVER_VERSION' ) or define( 'VP_CSSHOVER_VERSION', '2.0' );
	defined( 'VP_CSSHOVER_URL' ) or define( 'VP_CSSHOVER_URL', plugin_dir_url( __FILE__ ) );
	defined( 'VP_CSSHOVER_DIR' ) or define( 'VP_CSSHOVER_DIR', plugin_dir_path( __FILE__ ) );
	defined( 'VP_CSSHOVER_FILE' ) or define( 'VP_CSSHOVER_FILE', __FILE__ );
	
// Looding Bootstrap framework
	require 'lib/bootstrap.php';
	
//Include Custom Data Sources
	require_once 'admin/metabox/pick_data_eff.php';
}

// Register Custom Post type
function css3_custom_post_calling() {
	register_post_type( 'css3-rdhov', array(
		'labels'        => array(
			'name'          => __( 'Royal Hov Effects' ),
			'singular_name' => __( 'Hover Effect' ),
			'add_new_item'  => __( 'Add New Item' )
		),
		'public'        => true,
		'supports'      => array( 'title' ),
		'has_archive'   => true,
		'rewrite'       => array( 'slug' => 'hover-effects' ),
		'menu_icon'     => '',
		'menu_position' => 20,
	) );
}
add_action( 'init', 'css3_custom_post_calling' );

// custom post icon
require_once 'admin/metabox/customicon.php';
// Register Custom Texonomy
function css3_custom_post_tex_calling() {
	register_taxonomy(
		'css3hov_cat',
		'css3-rdhov',
		array(
			'hierarchical'      => true,
			'label'             => 'Royal hov Category',
			'query_var'         => true,
			'show_admin_column' => true,
			'rewrite'           => array(
				'slug'       => 'he-category',
				'with_front' => true
			)
		)
	);
}
add_action( 'init', 'css3_custom_post_tex_calling' );

// Loading Option Framework Main Metaboxes 
new VP_Metabox( array
(
	'id'       => 'rdmain-meta',
	'types'    => array( 'css3-rdhov' ),
	'title'    => __( 'Royal Hover Effects ', 'vp_textdomain' ),
	'priority' => 'high',
	'template' => VP_CSSHOVER_DIR . '/admin/metabox/custom-meta.php'
) );

// Loading Option Framework Right Side Metaboxes
new VP_Metabox( array
(
	'id'       => 'rightside-meta',
	'types'    => array( 'css3-rdhov' ),
	'title'    => __( 'Royal Shortcode Here', 'vp_textdomain' ),
	'priority' => 'high',
	'context'  => 'side',
	'template' => VP_CSSHOVER_DIR . '/admin/metabox/rightside.php'
) );

// all style shortcodes
require_once( VP_CSSHOVER_DIR . 'admin/css3-shortcode.php' );
