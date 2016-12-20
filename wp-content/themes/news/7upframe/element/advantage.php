<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_advantage'))
{
    function sv_vc_advantage($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'        => 'adv-info1',
            'image'        => '',
            'link'         => '',
        ),$attr));
        switch ($style) {
            case 'event-adv':
                $html .=    '<div class="event-adv">
                                <div class="event-adv-thumb">
                                    <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                </div>
                                <div class="event-adv-info">
                                    '.wpb_js_remove_wpautop($content, true).'
                                </div>
                            </div>';
                break;
                
            case 'trending-adv':
                $html .=    '<div class="trending-adv">
                                <div class="trending-adv-thumb">
                                    <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                </div>
                                <div class="trending-adv-info">
                                    '.wpb_js_remove_wpautop($content, true).'
                                </div>
                            </div>';
                break;

            case 'top-adv':
                $html .=    '<div class="top-adv">
                                <div class="top-adv-thumb">
                                    <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                </div>
                                <div class="top-adv-info">
                                    '.wpb_js_remove_wpautop($content, true).'
                                </div>
                                <a href="#" class="close-top-adv">x</a>
                            </div>';
                break;

            default:
                $html .=    '<div class="item-banner-adv">
                                <a href="'.esc_url($link).'" class="banner-adv-link">
                                    '.wp_get_attachment_image($image,'full').'
                                </a>
                                <div class="banner-adv-info '.$style.'">
                                    '.wpb_js_remove_wpautop($content, true).'
                                </div>
                            </div>';
                break;
        }
        return $html;
    }
}

stp_reg_shortcode('sv_advantage','sv_vc_advantage');

vc_map( array(
    "name"      => esc_html__("SV Advantage", 'news'),
    "base"      => "sv_advantage",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style",'news'),
            "param_name" => "style",
            "value"     => array(
                esc_html__("Style 1","news") => 'adv-info1',
                esc_html__("Style 2","news") => 'adv-info2',
                esc_html__("Style 3(close button)","news") => 'top-adv',
                esc_html__("Style 4(trending)","news") => 'trending-adv',
                esc_html__("Style 5(event)","news") => 'event-adv',
                )
        ),
        array(
            "type" => "attach_image",
            "heading" => esc_html__("Image",'news'),
            "param_name" => "image",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Link Adv",'news'),
            "param_name" => "link",
        ),
        array(
            "type" => "textarea_html",
            "holder" => "div",
            "heading" => esc_html__("Content",'news'),
            "param_name" => "content",
        ),
    )
));