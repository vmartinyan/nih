<?php
/**
 * news functions and definitions
 *
 * @version 1.0
 *
 * @date 12.08.2015
 */

load_theme_textdomain( 'news', get_template_directory() . '/languages' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
 
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}
require_once( trailingslashit( get_template_directory() ). '/7upframe/function/function.php' );
require_once( trailingslashit( get_template_directory() ). '/7upframe/config/config.php' );

// LOAD CLASS LIB

require_once( trailingslashit( get_template_directory() ). '/7upframe/class/asset.php' );
require_once( trailingslashit( get_template_directory() ). '/7upframe/class/class-tgm-plugin-activation.php' );
require_once( trailingslashit( get_template_directory() ). '/7upframe/class/importer.php' );
require_once( trailingslashit( get_template_directory() ). '/7upframe/class/mega_menu.php' );
require_once( trailingslashit( get_template_directory() ). '/7upframe/class/order-comment-field.php' );
require_once( trailingslashit( get_template_directory() ). '/7upframe/class/require-plugin.php' );
require_once( trailingslashit( get_template_directory() ). '/7upframe/class/temlate.php' );

// END LOAD

// LOAD CONTROLER LIB

require_once( trailingslashit( get_template_directory() ). '/7upframe/controler/BaseControl.php' );
require_once( trailingslashit( get_template_directory() ). '/7upframe/controler/Customize_Control.php' );
require_once( trailingslashit( get_template_directory() ). '/7upframe/controler/Metabox_Control.php' );
require_once( trailingslashit( get_template_directory() ). '/7upframe/controler/Option_Tree_Control.php' );
require_once( trailingslashit( get_template_directory() ). '/7upframe/controler/Visual_composer_Control.php' );
require_once( trailingslashit( get_template_directory() ). '/7upframe/controler/Walker_megamenu.php' );
require_once( trailingslashit( get_template_directory() ). '/7upframe/controler/Woocommerce_Control.php' );
require_once( trailingslashit( get_template_directory() ). '/7upframe/controler/Wpml_Control.php' );

// END LOAD

require_once( trailingslashit( get_template_directory() ). '/7upframe/index.php' );

//WPGlobus ACF
add_filter( 'wpglobus_multilingual_meta_keys', 'filter__wpglobus_multilingual_meta_keys' );

 function filter__wpglobus_multilingual_meta_keys( $multilingual_meta_keys ) {

        $multilingual_meta_keys['content1'] = true;

        return $multilingual_meta_keys;

}

 