<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 22/01/16
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_speaker'))
{
    function sv_vc_speaker($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'image'      => '',
            'name'       => '',
            'info'       => '',
            'link'       => '',
            'social'     => '',
        ),$attr));
        if(!empty($image)){
            parse_str( urldecode( $social ), $data);
            $html .=    '<div class="item-speaker text-center">
                            '.wp_get_attachment_image($image,'full').'
                            <div class="info-item-speaker">
                                <h3><a href="'.esc_url($link).'">'.$name.'</a></h3>
                                <h4>'.$info.'</h4>
                                <div class="social-speaker">';
            if(is_array($data)){
                foreach ($data as $key => $value) {
                    $url = '#';
                    if(isset($value['url'])) $url = $value['url'];
                    $html .=        '<a href="'.esc_url($url).'"><i class="fa '.$value['social'].'"></i></a>';
                }
            }
             $html .=           '</div>
                            </div>
                        </div>';
        }
        return $html;
    }
}

stp_reg_shortcode('sv_speaker','sv_vc_speaker');

vc_map( array(
    "name"      => esc_html__("SV Speaker", 'news'),
    "base"      => "sv_speaker",
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
            "heading" => esc_html__("Name",'news'),
            "param_name" => "name",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Info",'news'),
            "param_name" => "info",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Link detail",'news'),
            "param_name" => "link",
        ),
        array(
            "type" => "add_social",
            "heading" => esc_html__("Social",'news'),
            "param_name" => "social",            
        )
    )
));