<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(!defined('ABSPATH')) return;
// Start 20/1/2016
if(!class_exists('SV_BaseController'))
{
    class SV_BaseController
    {
        static function _init()
        {
            //Default Framwork Hooked

            add_filter( 'wp_title', array(__CLASS__,'_wp_title'), 10, 2 );
            add_action( 'wp', array(__CLASS__,'_setup_author') );
            add_action( 'after_setup_theme', array(__CLASS__,'_after_setup_theme') );
            add_action('widgets_init',array(__CLASS__,'_add_sidebars'));

            add_filter( 'body_class',array(__CLASS__,'_add_body_class'));

            add_action('wp_enqueue_scripts',array(__CLASS__,'_add_scripts'));

            //Custom hooked
            add_filter('sv_get_sidebar',array(__CLASS__,'_blog_filter_sidebar'));
            
            add_action('wp_head',array(__CLASS__,'_show_custom_css'),100);

            add_action('admin_enqueue_scripts',array(__CLASS__,'_add_admin_scripts'));
            add_action('admin_footer',array(__CLASS__,'_init_admin_scripts'));

            add_filter( 'style_loader_src',array(__CLASS__,'_remove_enqueue_ver'), 10, 2 );
            add_filter( 'script_loader_src',array(__CLASS__,'_remove_enqueue_ver'), 10, 2 );
            
        }

        static function _add_scripts()
        {
            $css_url = get_template_directory_uri() . '/assets/css/';
            $js_url = get_template_directory_uri() . '/assets/js/';
            /*
             * Javascript
             * */
            if ( is_singular() && comments_open()){
            wp_enqueue_script( 'comment-reply' );
            }
            //Register JS
            wp_register_script('bootstrap',$js_url.'lib/bootstrap.min.js',array('jquery'),null,true);
            wp_register_script( 'google-map', "//maps.google.com/maps/api/js?key=AIzaSyBX2IiEBg-0lQKQQ6wk6sWRGQnWI7iogf0", array('jquery'), null, true );
            wp_register_script('sv-google-map',$js_url.'map.js',array('jquery'),null,true);
            wp_register_script('fancybox',$js_url.'lib/jquery.fancybox.js',array('jquery'),null,true);
            wp_register_script('fancybox-media',$js_url.'lib/jquery.fancybox-media.js',array('jquery'),null,true);
            wp_register_script('jquery-ui',$js_url.'lib/jquery-ui.js',array('jquery'),null,true);
            wp_register_script('carousel',$js_url.'lib/owl.carousel.js',array('jquery'),null,true);
            wp_register_script('hoverdir',$js_url.'lib/jquery.hoverdir.js',array('jquery'),null,true);
            wp_register_script('modernizr',$js_url.'lib/modernizr.custom.js',array('jquery'),null,true);
            wp_register_script('slick',$js_url.'lib/slick.js',array('jquery'),null,true);
            wp_register_script('jcarousellite',$js_url.'lib/jquery.jcarousellite.min.js',array('jquery'),null,true);
            wp_register_script('timeCircles',$js_url.'lib/TimeCircles.js',array('jquery'),null,true);
            wp_register_script('circles',$js_url.'lib/circles.js',array('jquery'),null,true);
            wp_register_script('bxslider',$js_url.'lib/jquery.bxslider.js',array('jquery'),null,true);
            wp_register_script('masonry',$js_url.'lib/masonry.pkgd.min.js',array('jquery'),null,true);
            wp_register_script('sv-theme-script',$js_url.'script.js',array('jquery'),null,true);
            //ENQUEUE JS
            if(class_exists("woocommerce")){
                global $woocommerce;
                wp_enqueue_script( 'wc-add-to-cart-variation', $woocommerce->plugin_url() . '/assets/js/frontend/add-to-cart-variation.min.js', array('jquery'), '1.6', true );
            }
            wp_enqueue_script('bootstrap');
            wp_enqueue_script('fancybox');
            wp_enqueue_script('fancybox-media');
            wp_enqueue_script('jquery-ui');
            wp_enqueue_script('carousel');
            wp_enqueue_script('jcarousellite');
            wp_enqueue_script('bxslider');
            wp_enqueue_script('timeCircles');
            wp_enqueue_script('google-map');
            wp_enqueue_script('sv-google-map');
            wp_enqueue_script('circles');
            wp_enqueue_script('slick');
            wp_enqueue_script('hoverdir');
            wp_enqueue_script('modernizr');
            wp_enqueue_script('masonry');
            wp_enqueue_script('sv-theme-script');
            wp_enqueue_script('sv-theme-ajax', $js_url.'ajax.js', array( 'jquery' ),null,true);
            wp_localize_script('sv-theme-ajax', 'ajax_process', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
            


            // CSS
            wp_enqueue_style('sv-open-sans','https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' );
            wp_enqueue_style('sv-questrial','https://fonts.googleapis.com/css?family=Oswald:400,700,300' );
            wp_enqueue_style('bootstrap',$css_url.'lib/bootstrap.min.css');
            wp_enqueue_style('sv-theme-unitest',$css_url.'theme-unitest.css');            
            wp_enqueue_style('bootstrap-theme',$css_url.'lib/bootstrap-theme.css');
            wp_enqueue_style('font-awesome',$css_url.'lib/font-awesome.min.css');
            wp_enqueue_style('font-linearicons',$css_url.'lib/font-linearicons.css');
            wp_enqueue_style('fancybox',$css_url.'lib/jquery.fancybox.css');
            wp_enqueue_style('jquery-ui',$css_url.'lib/jquery-ui.css');
            wp_enqueue_style('owl-carousel',$css_url.'lib/owl.carousel.css');
            wp_enqueue_style('owl-transitions',$css_url.'lib/owl.transitions.css');
            wp_enqueue_style('owl-theme',$css_url.'lib/owl.theme.css');
            wp_enqueue_style('slick',$css_url.'lib/slick.css');
            wp_enqueue_style('slick-theme',$css_url.'lib/slick-theme.css');
            wp_enqueue_style('sv-default',$css_url.'lib/theme.css');
            wp_enqueue_style('sv-theme-style',$css_url.'custom-style.css');
            wp_enqueue_style('sv-theme-responsive',$css_url.'lib/responsive.css');
            wp_enqueue_style('sv-theme-default',get_stylesheet_uri());

        }


        static function _show_custom_css()
        {
            $style=SV_Template::load_view('custom_css');?>

            <style id="sv_cutom_css">
                <?php print ($style);?>
            </style>

            <?php echo "\n";

        }

        static function _blog_filter_sidebar($sidebar)
        {
            if((!is_front_page() && is_home()) || (is_front_page() && is_home())){
                $pos=sv_get_option('sv_sidebar_position_blog');
                $sidebar_id=sv_get_option('sv_sidebar_blog');
            }
            else{
                if(is_single()){
                    $pos = sv_get_option('sv_sidebar_position_post');
                    $sidebar_id = sv_get_option('sv_sidebar_post');
                }
                else{
                    $pos = sv_get_option('sv_sidebar_position_page');
                    $sidebar_id = sv_get_option('sv_sidebar_page');
                }        
            }
            if(class_exists( 'WooCommerce' )){
                if(sv_is_woocommerce_page()){
                    $pos = sv_get_option('sv_sidebar_position_woo');
                    $sidebar_id = sv_get_option('sv_sidebar_woo');    
                }
            }
            if(is_archive() && !sv_is_woocommerce_page()){
                $pos = sv_get_option('sv_sidebar_position_page_archive');
                $sidebar_id = sv_get_option('sv_sidebar_page_archive');                
            }
            else{
                if(!is_home()){
                    $id = get_the_ID();
                    if(is_404()) $id = sv_get_option('sv_404_page');
                    if(is_front_page()) $id = (int)get_option('page_on_front');
                    if (class_exists('woocommerce')) {
                        if(is_shop()) $id = (int)get_option('woocommerce_shop_page_id');
                        if(is_cart()) $id = (int)get_option('woocommerce_cart_page_id');
                        if(is_checkout()) $id = (int)get_option('woocommerce_checkout_page_id');
                        if(is_account_page()) $id = (int)get_option('woocommerce_myaccount_page_id');
                    }
                    $sidebar_pos = get_post_meta($id,'sv_sidebar_position',true);
                    $id_side_post = get_post_meta($id,'sv_select_sidebar',true);
                    if(!empty($sidebar_pos)){
                        $pos = $sidebar_pos;
                        if(!empty($id_side_post)) $sidebar_id = $id_side_post;
                    }
                }
            }
            if(is_search()) {
                $sidebar_id = 'blog-sidebar';
                $pos = 'right';                
            }
            if($sidebar_id){
                $sidebar['id']=$sidebar_id;
            }

            if($pos){
                $sidebar['position']=$pos;
            }

            return $sidebar;
        }
        
        
        // -----------------------------------------------------
        // Default Hooked, Do not edit

        /**
         * Hook setup theme
         *
         *
         * */

        static function _after_setup_theme()
        {
            /*
             * Make theme available for translation.
             * Translations can be filed in the /languages/ directory.
             * If you're building a theme based on stframework, use a find and replace
             * to change LANGUAGE to the name of your theme in all the template files
             */

            // This theme uses wp_nav_menu() in one location.
            global $sv_config;
            $menus= $sv_config['nav_menu'];
            if(is_array($menus) and !empty($menus) )
            {
                register_nav_menus($menus);
            }


            add_theme_support( "title-tag" );
            add_theme_support('automatic-feed-links');
            add_theme_support('post-thumbnails');
            add_theme_support('html5',array(
                'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
            ));
            add_theme_support('post-formats',array(
                'image', 'video', 'gallery','audio','quote'
            ));
            add_theme_support('custom-header');
            add_theme_support('custom-background');
            add_theme_support('woocommerce');
        }

        /**
         * Add default sidebar to website
         *
         *
         * */
        static function _add_sidebars()
        {
            // From config file
            global $sv_config;
            $sidebars = $sv_config['sidebars'];
            if(is_array($sidebars) and !empty($sidebars) )
            {
                foreach($sidebars as $value){
                    register_sidebar($value);
                }
            }
            $add_sidebars = sv_get_option('sv_add_sidebar');
            if(is_array($add_sidebars) and !empty($add_sidebars) )
            {
                foreach($add_sidebars as $sidebar){
                    if(!empty($sidebar['title'])){
                        $id = strtolower(str_replace(' ', '-', $sidebar['title']));
                        $b_class = 'sidebar-blog-post';
                        $custom_add_sidebar = array(
                                'name' => $sidebar['title'],
                                'id' => $id,
                                'description' => esc_html__( 'SideBar created by add sidebar in theme options.', 'news'),
                                'before_title' => '<'.$sidebar['widget_title_heading'].' class="widget-title">',
                                'after_title' => '</'.$sidebar['widget_title_heading'].'>',
                                'before_widget' => '<div id="%1$s" class="'.$b_class.' widget %2$s">',
                                'after_widget'  => '</div>',
                            );
                        register_sidebar($custom_add_sidebar);
                        unset($custom_add_sidebar);
                    }
                }
            }

        }


        /**
         * Set up author data
         *
         * */
        static function _setup_author() {
            global $wp_query;

            if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
                $GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
            }
        }


        /**
         * Hook to wp_title
         *
         * */
        static function _wp_title($title,$sep)
        {
            return $title;
        }
        
        static function  _init_admin_scripts()
        {
            ?>
            <script>
                jQuery(document).ready(function($){
                    $('.sv_iconpicker').iconpicker();


                    //This for VC Elements
                    $(document).on('click','div.sv_iconpicker input[type=text]',function(){

                        if(!$(this).hasClass('st_icp_inited'))
                        {
                            $(this).iconpicker({
                                'container':'body'
                            });

                            $(this).addClass('st_icp_inited').data('iconpicker').show();
                        }
                    });
                    $(document).on('click','input.sv_iconpicker',function(){

                        if(!$(this).hasClass('st_icp_inited'))
                        {
                            $(this).iconpicker({
                                'container':'body'
                            });
                            $(this).parent().parent().attr('style','overflow:inherit !important');
                            $(this).addClass('st_icp_inited').data('iconpicker').show();
                        }
                    });
                });

            </script>

            <?php
        }

        static function _add_admin_scripts()
        {
            $admin_url = get_template_directory_uri().'/assets/admin/';
            wp_enqueue_media();
            wp_enqueue_script( 'sv-admin-js', $admin_url . '/js/admin.js', array( 'jquery' ),null,true );
            wp_enqueue_script('sv-iconpicker',$admin_url.'/js/fontawesome-iconpicker.js',array('jquery'),null,true);
            add_editor_style();
            wp_enqueue_style( 'font-awesome',$admin_url.'css/font-awesome.css');
            wp_enqueue_style( 'sv-custom-admin',$admin_url.'css/custom.css');
            wp_enqueue_style( 'sv-iconpicker',$admin_url.'css/fontawesome-iconpicker.min.css');
        }

        static function _remove_enqueue_ver($src)    {
            if (strpos($src, '?ver='))
                $src = remove_query_arg('ver', $src);
            return $src;
        }        

        static function _add_body_class($classes) {
            $body_class_el = '';
            $body_bg = sv_get_value_by_id('sv_bg_body');
            $body_font = sv_get_value_by_id('sv_font_body');
            $body_class_el .= ' '.sv_fill_css_background($body_bg);
            $body_class_el .= ' '.sv_get_class_typography($body_font);
            
            $classes[] = $body_class_el;
            return $classes;
        }

    }

    SV_BaseController::_init();
}
