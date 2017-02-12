<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 01/02/16
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_piechart_skill'))
{
    function sv_vc_piechart_skill($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'value'      => '0',
            'title'      => '',
            'radius'      => '90',
            'width'      => '24',
            'color1'      => '#d3d3d3',
            'color2'      => '#ffdd00',
        ),$attr));
        $id = uniqid();
        $html .=    '<div class="item-skill">
                        <div class="chart-skill" id="chart-'.$id.'" data-value="'.$value.'" data-radius="'.$radius.'" data-width="'.$width.'" data-color1="'.$color1.'" data-color2="'.$color2.'"></div>
                        <h3>'.$title.'</h3>
                    </div>';
        return $html;
    }
}

stp_reg_shortcode('sv_piechart_skill','sv_vc_piechart_skill');

vc_map( array(
    "name"      => esc_html__("SV PieChart Skill", 'news'),
    "base"      => "sv_piechart_skill",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Value",'news'),
            "param_name" => "value",
        ),
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Title",'news'),
            "param_name" => "title",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Radius",'news'),
            "param_name" => "radius",
            'description' => esc_html__( 'Set Circle radius. Default is 90', 'news' ),
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Width",'news'),
            "param_name" => "width",
            'description' => esc_html__( 'Set Circle width. Default is 24', 'news' ),
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Color 1",'news'),
            "param_name" => "color1",
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Color 2",'news'),
            "param_name" => "color2",
        )
    )
));