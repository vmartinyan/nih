<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_event_form'))
{
    function sv_vc_event_form($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'title'      => '',
            'des'        => '',
            'form'       => '',
            'livechat'   => '',
            'avatar'   => '',
            'live_title'      => '',
            'live_link'        => '',
            'live_des'        => '',
        ),$attr));
        $contact = get_post($form);
        $html .=    '<div class="event-create-box">
                        <h2>'.$title.'</h2>
                        <p>'.$des.'</p>';
        if(!empty($form)) $html .=  do_shortcode('[contact-form-7 id="'.$contact->ID.'" title="'.$contact->post_title.'"]');                   
        $html .=        '<div class="event-live-chat">
                            <ul>';
        if(!empty($avatar)) $html .=    '<li><a href="'.esc_url($live_link).'" class="avatar-live-chat">'.wp_get_attachment_image($avatar,array(60,60)).'</a></li>';
        $html .=                '<li>
                                    <label>'.$live_title.'</label>
                                    <a href="'.esc_url($live_link).'">'.$live_des.'</a>
                                </li>
                            </ul>   
                        </div>
                    </div>';
        return $html;
    }
}

stp_reg_shortcode('sv_event_form','sv_vc_event_form');

vc_map( array(
    "name"      => esc_html__("SV Create Event", 'news'),
    "base"      => "sv_event_form",
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
            "type" => "textarea",
            "holder" => "div",
            "heading" => esc_html__("Description",'news'),
            "param_name" => "des",
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Choose Form",'news'),
            "param_name" => "form",
            "value"     => sv_get_list_ContactForm(),
        ),
        array(
            "type" => "checkbox",
            "heading" => esc_html__("Live Chat",'news'),
            "param_name" => "livechat",
        ),
        array(
            "type" => "attach_image",
            "heading" => esc_html__("Avatar",'news'),
            "param_name" => "avatar",
        ),
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Live Chat Title",'news'),
            "param_name" => "live_title",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Live Link",'news'),
            "param_name" => "live_link",
        ),
        array(
            "type" => "textarea",
            "holder" => "div",
            "heading" => esc_html__("Live Chat Description",'news'),
            "param_name" => "live_des",
        ),
    )
));