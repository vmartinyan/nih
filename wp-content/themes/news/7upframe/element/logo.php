<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_logo'))
{
    function sv_vc_logo($attr)
    {
        $html = $logo = '';
        extract(shortcode_atts(array(
            'logo_img'      => '',
        ),$attr));
        if(!empty($logo_img)){
            $img = wp_get_attachment_image_src( $logo_img ,"full");
            $logo .= $img[0];
        }
        else{
            $logo .= sv_get_option('logo');
        }
        if(!empty($logo)){
            $html .=    '<div class="logo">
                            <a href="'.esc_url(get_home_url('/')).'">
                                <img src="'.esc_url($logo).'" alt="logo">
                            </a>
                        </div>';             
        }
        else{
            $html .=    '<div class="logo">
                            <a href="'.esc_url(home_url('/')).'" title="'.esc_attr__("logo","news").'">
                                <h1>'.get_bloginfo('name', 'display').'</h1>
                            </a>
                        </div>';
        }
        return $html;
    }
}

stp_reg_shortcode('sv_logo','sv_vc_logo');

vc_map( array(
    "name"      => esc_html__("SV Logo", 'news'),
    "base"      => "sv_logo",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "attach_image",
            "holder" => "div",
            "heading" => esc_html__("Logo image",'news'),
            "param_name" => "logo_img",
        )
    )
));