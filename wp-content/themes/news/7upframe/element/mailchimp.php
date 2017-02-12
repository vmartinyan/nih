<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 26/12/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_mailchimp'))
{
    function sv_vc_mailchimp($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'title'    => '',
            'des1'    => '',
            'des2'    => '',
            'form_id'    => '',
            'style'      => 'newsletter-box',
        ),$attr));
        $form_html = apply_filters('sv_remove_autofill',do_shortcode('[mc4wp_form id="'.$form_id.'"]'));
        switch ($style) {
            case 'newsletter4':
                $html .=    '<div class="'.$style.'">
                                <h2>'.$title.'</h2>
                                <p>'.$des1.'</p>
                                '.$form_html.'
                                <p>'.$des2.'</p>
                            </div>';
                break;
            
            default:
                $html .=    '<div class="'.$style.'">
                                <h2>'.$title.'</h2>
                                '.$form_html.'
                            </div>';
                break;
        }        
        return $html;
    }
}

stp_reg_shortcode('sv_mailchimp','sv_vc_mailchimp');

vc_map( array(
    "name"      => esc_html__("SV MailChimp", 'news'),
    "base"      => "sv_mailchimp",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style",'news'),
            "param_name" => "style",
            "value"     => array(
                esc_html__("Normal",'news')    => 'newsletter-box',
                esc_html__("Footer style",'news')    => 'newsletter-footer',
                esc_html__("Style home 7",'news')    => 'content-newsletter7',
                esc_html__("Style home 4",'news')    => 'newsletter4',
                )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Title",'news'),
            "param_name" => "title",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Description Before",'news'),
            "param_name" => "des1",
            "dependency"    => array(
                "element"   =>  'style',
                "value"   =>  'newsletter4',
                )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Description After",'news'),
            "param_name" => "des2",
            "dependency"    => array(
                "element"   =>  'style',
                "value"   =>  'newsletter4',
                )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Form ID",'news'),
            "param_name" => "form_id",
        )
    )
));