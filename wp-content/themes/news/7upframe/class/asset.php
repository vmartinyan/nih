<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */

if(!class_exists('SV_Assets'))
{
    class SV_Assets
    {
        static $asset_url;

        static $inline_css;
        static $current_css_id;
        static $prefix_class="sv_";

        static function _init()
        {
            self::$current_css_id=time();
            add_action('wp_footer',array(__CLASS__,'_action_footer_css'));
        }

        static function build_css($string=false,$effect = false){
            self::$current_css_id++;
            self::$inline_css.="
                .".self::$prefix_class.self::$current_css_id.$effect."{
                    {$string}
                }
        ";
            return self::$prefix_class.self::$current_css_id;
        }

        static function add_css($string=false){
            self::$inline_css.=$string;

        }

        static function _action_footer_css(){
            $style = '<style id="sv_add_footer_css">'.self::$inline_css.'</style>';
            $string = trim(preg_replace('/\s\s+/', ' ', self::$inline_css));
            if(function_exists('s7upf_add_inline_style')){
                print s7upf_add_inline_style($string);
            }
        }
        
    }

    SV_Assets::_init();
}