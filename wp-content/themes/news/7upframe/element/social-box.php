<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_social_box'))
{
    function sv_vc_social_box($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'title1'      => '',
            'link1'       => '',
            'icon1'       => '',
            'title2'      => '',
            'link2'       => '',
            'icon2'       => '',
            'title3'      => '',
            'link3'       => '',
            'icon3'       => '',
            'title4'      => '',
            'link4'       => '',
            'icon4'       => '',
        ),$attr));
        $html .=    '<div class="clearfix">
                        <div class="social-sidebar social-left">
                            <a href="'.esc_url($link1).'" class="sc-fb"><i class="fa '.$icon1.'"></i> <span>'.$title1.'</span></a>
                            <a href="'.esc_url($link2).'" class="sc-pt"><i class="fa '.$icon2.'"></i> <span>'.$title2.'</span></a>
                        </div>
                        <div class="social-sidebar social-right">
                            <a href="'.esc_url($link3).'" class="sc-tw"><i class="fa '.$icon3.'"></i> <span>'.$title3.'</span></a>
                            <a href="'.esc_url($link4).'" class="sc-in"><i class="fa '.$icon4.'"></i> <span>'.$title4.' </span></a>
                        </div>
                    </div>';
        return $html;
    }
}

stp_reg_shortcode('sv_social_box','sv_vc_social_box');

vc_map( array(
    "name"      => esc_html__("SV Social Box", 'news'),
    "base"      => "sv_social_box",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Social name 1",'news'),
            "param_name" => "title1",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Social Link 1",'news'),
            "param_name" => "link1",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Social Icon 1",'news'),
            "param_name" => "icon1",
            'edit_field_class'=>'vc_col-sm-12 vc_column sv_iconpicker'
        ),
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Social name 2",'news'),
            "param_name" => "title2",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Social Link 2",'news'),
            "param_name" => "link2",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Social Icon 2",'news'),
            "param_name" => "icon2",
            'edit_field_class'=>'vc_col-sm-12 vc_column sv_iconpicker'
        ),
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Social name 3",'news'),
            "param_name" => "title3",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Social Link 3",'news'),
            "param_name" => "link3",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Social Icon 3",'news'),
            "param_name" => "icon3",
            'edit_field_class'=>'vc_col-sm-12 vc_column sv_iconpicker'
        ),
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Social name 4",'news'),
            "param_name" => "title4",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Social Link 4",'news'),
            "param_name" => "link4",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Social Icon 4",'news'),
            "param_name" => "icon4",
            'edit_field_class'=>'vc_col-sm-12 vc_column sv_iconpicker'
        ),
    )
));