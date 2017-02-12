<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 1/02/16
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_image_single'))
{
    function sv_vc_image_single($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'image'      => '',
            'caption'      => '',
            'link'      => '',
        ),$attr));
        if(!empty($image)){
            if(empty($caption)){
                $html .=    '<div class="item-post-adv">
                                <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                            </div>';
            }
            else{
                $html .=    '<div class="banner-single-post">
                                <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                <h3>'.$caption.'</h3>
                            </div>';
            }
        }
        return $html;
    }
}

stp_reg_shortcode('sv_image_single','sv_vc_image_single');

vc_map( array(
    "name"      => esc_html__("SV Image Single", 'news'),
    "base"      => "sv_image_single",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "attach_image",
            "heading" => esc_html__("Image",'news'),
            "param_name" => "image",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Caption",'news'),
            "param_name" => "caption",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Link Image",'news'),
            "param_name" => "link",
        )
    )
));