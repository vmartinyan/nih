<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 15/12/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_title'))
{
    function sv_vc_title($attr)
    {
        $html = $mr_class = $view_html = '';
        extract(shortcode_atts(array(
            'title'         => '',
            'view_link'     => '',
            'margin_right'  => '',
        ),$attr));
        $view_link = vc_build_link( $view_link );        
        if(!empty($margin_right)) $mr_class = SV_Assets::build_css('right:'.$margin_right.'px !important;');
        if(!empty($view_link['url']) && !empty($view_link['title'])){
            $view_html =    '<a href="'.esc_url($view_link['url']).'" class="readmore '.$mr_class.'">'.$view_link['title'].' <span class="lnr lnr-chevron-right"></span></a>';
        }
        $html .=    '<div class="title-box">
                        <h2>'.$title.'</h2>
                        '.$view_html.'
                    </div>';
        return $html;
    }
}

stp_reg_shortcode('sv_title','sv_vc_title');

vc_map( array(
    "name"      => esc_html__("SV Title", 'news'),
    "base"      => "sv_title",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Title",'news'),
            "param_name" => "title",
        ),
        array(
            'heading'     => esc_html__( 'View link', 'news' ),
            'type'        => 'vc_link',
            'param_name'  => 'view_link',
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Margin right view link",'news'),
            "param_name" => "margin_right",
            'description'   => esc_html__( 'Unit(px). Example -20', 'news' ),
        ),
    )
));