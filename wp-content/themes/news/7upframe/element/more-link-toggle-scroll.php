<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 25/01/16
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_more_link_scroll'))
{
    function sv_vc_more_link_scroll($attr , $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'label'      => 'more',
            'title'      => '',
        ),$attr));
        $html .=    '<div class="extra-menu event-extra-menu">
                        <a href="#" class="btn-extra-menu">'.$label.' <span class="lnr lnr-menu"></span></a>
                    </div>
                    <div class="extra-menu-dropdown event-extra-menu-dropdown">
                        <div class="inner-extra-menu-dropdown">
                            <h2>'.$title.'</h2>
                            <div class="control-menu-slider">
                                <a href="#" class="prev"><span class="lnr lnr-chevron-down-circle"></span></a>
                                <a href="#" class="next"><span class="lnr lnr-chevron-up-circle"></span></a>
                            </div>
                            <div class="vertical-menu-slider">
                                '.wpb_js_remove_wpautop($content, true).'
                            </div>
                        </div> 
                    </div>';
        return $html;
    }
}

stp_reg_shortcode('sv_more_link_scroll','sv_vc_more_link_scroll');

vc_map( array(
    "name"      => esc_html__("SV More Link Scroll", 'news'),
    "base"      => "sv_more_link_scroll",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Label",'news'),
            "param_name" => "label",
        ),
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Title",'news'),
            "param_name" => "title",
        ),
        array(
            "type" => "textarea_html",
            "holder" => "div",
            "heading" => esc_html__("Content",'news'),
            "param_name" => "content",
            'description' => esc_html__( 'Note: This element only run with content is ul list format.', 'news' ),
        ),
    )
));