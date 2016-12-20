<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 01/02/16
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_mission'))
{
    function sv_vc_mission($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'mission'      => '',
            'image'      => '',
        ),$attr));
        if(!empty($mission)){
            parse_str( urldecode( $mission ), $data);
            $html .=    '<div class="our-mission">
                            <div class="content-our-mission">
                                <div class="list-our-mission">
                                    <div class="row">';
                    if(is_array($data)){
                    foreach ($data as $key => $value) {
                        $html .=    '<div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="our-mission-box">
                                            <h2>'.$value['year'].'<sup>'.$value['percent'].'</sup></h2>
                                            <p>'.$value['description'].'</p>
                                        </div>
                                    </div>';
                    }
        }                       
            $html .=                '</div>
                                </div>
                            </div>';
            $html .=        wp_get_attachment_image($image,'full',0,array('class'=>'our-mission-thumb'));
            $html .=    '</div>';
        }
        return $html;
    }
}

stp_reg_shortcode('sv_mission','sv_vc_mission');

vc_map( array(
    "name"      => esc_html__("SV Mission", 'news'),
    "base"      => "sv_mission",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "attach_image",
            "holder" => "div",
            "heading" => esc_html__("Image",'news'),
            "param_name" => "image",
        ),
        array(
            "type" => "add_mission",
            "heading" => esc_html__("Add Mission List",'news'),
            "param_name" => "mission",
        )
    )
));