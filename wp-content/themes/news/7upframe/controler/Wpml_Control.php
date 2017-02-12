<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 13/08/15
 * Time: 10:20 AM
 */

if(defined('ICL_SITEPRESS_VERSION') && defined('ICL_LANGUAGE_CODE')){
    if (!function_exists('sv_copy_default_theme_option')){
        function sv_copy_default_theme_option($option_name){
            global $sitepress;
            $options = get_option($option_name);
            $wpml_lang = icl_get_languages('skip_missing=0&orderby=custom');
            $default_lang = $sitepress->get_default_language();
            if(is_array($wpml_lang) && !empty($wpml_lang))
            {
                foreach ($wpml_lang as $lang) {
                    $lang_option = get_option($option_name.'_'.$lang['language_code']);
                    if($lang_option==''){
                        update_option($option_name.'_'.$lang['language_code'],$options);
                    }
                }
            }    
        }
    }    
    add_action('sv_copy_theme_option','sv_copy_default_theme_option',10,1);
    do_action('sv_copy_theme_option', 'option_tree' );
    if (!function_exists('sv_get_option_by_lang')){
        add_filter('ot_options_id','sv_get_option_by_lang',10,1);
        function sv_get_option_by_lang($option){
            return $option_key = $option.'_'.ICL_LANGUAGE_CODE;
        }
    }
    if (!function_exists('sv_lang_bar')){
        function sv_lang_bar(){
            $wpml_lang = icl_get_languages('skip_missing=0&orderby=custom');
            if(is_array($wpml_lang) && !empty($wpml_lang)){
                $output = '<div class="tp-navbar-text">';
                $output .= '<ul class="language-bar">';
                foreach ($wpml_lang as $lang) {
                    $output .= '<li><a href="'.esc_url($lang['url']).'"><img src="'.esc_url($lang['country_flag_url']).'" alt="'.$lang['native_name'].'"></a></li>';
                }
                $output .= '</ul>';
                $output .= '</div>';
                print $output;
            }
        }
    }
}
?>