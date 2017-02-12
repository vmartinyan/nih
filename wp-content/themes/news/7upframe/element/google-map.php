<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_map'))
{
    function sv_vc_map($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'         =>'',
            'market'        =>'',
            'zoom'          =>'16',
            'location'      =>'',
            'control'       =>'yes',
            'scrollwheel'   =>'yes',
            'disable_ui'    =>'no',
            'draggable'     =>'yes',
            'width'     =>'100%',
            'height'     =>'500px'
        ),$attr));
        parse_str( urldecode( $location ), $locations);
        $location_text = '';
        foreach ($locations as $values) {
            $location_text .= '|';
            foreach ($values as $value) {
                $location_text .= $value.',';
            }
        }
        $img = array();$img[0]='';
        if($market != '') {
            $img = wp_get_attachment_image_src($market,"full");
        }
        $map_css = 'width:'.$width.';height:'.$height.';max-width-100%;';
        $html .= '<div class="clearfix"></div><div id="st-map" class="'.SV_Assets::build_css($map_css).'" data-location="'.$location_text.'" data-market="'.$img[0].'" data-zoom="'.$zoom.'" data-style="'.$style.'" data-control="'.$control.'" data-scrollwheel="'.$scrollwheel.'" data-disable_ui="'.$disable_ui.'" data-draggable="'.$draggable.'"></div>';
        return $html;
    }
}

stp_reg_shortcode('sv_map','sv_vc_map');

vc_map( array(
    "name"      => esc_html__("SV GoogleMap", 'news'),
    "base"      => "sv_map",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "dropdown",
            "holder" => "div",
            "heading" => esc_html__("Map Style",'news'),
            "param_name" => "style",
            'value' => array(
                esc_html__('Default','news') => '',
                esc_html__('Grayscale','news') => 'grayscale',
                esc_html__('Blue','news') => 'blue',
                esc_html__('Dark','news') => 'dark',
                esc_html__('Pink','news') => 'pink',
                esc_html__('Light','news') => 'light',
                esc_html__('Blueessence','news') => 'blueessence',
                esc_html__('Bentley','news') => 'bentley',
                esc_html__('Retro','news') => 'retro',
                esc_html__('Cobalt','news') => 'cobalt',
                esc_html__('Brownie','news') => 'brownie'
            ),
        ),
        array(
            "type" => "add_location_map",
            "heading" => esc_html__( "Add Map Location", 'news' ),
            "param_name" => "location",
            "description" => esc_html__( "Click Add more button to add location.", 'news' )
        ),
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__( "Map Zoom", 'news' ),
            "param_name" => "zoom",
            "description" => esc_html__( "Enter zoom for map. Default is 16", 'news' ),
        ),
        array(
            'type' => 'attach_image',
            "holder" => "div",
            'heading' => esc_html__( 'Marker Image', 'news' ),
            'param_name' => 'market',
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Map Width', 'news' ),
            'param_name' => 'width',
            "description" => esc_html__( "This is value to set width for map. Unit % or px. Example: 100%,500px. Default is 100%", 'news' )
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Map Height', 'news' ),
            'param_name' => 'height',
            "description" => esc_html__( "This is value to set height for map. Unit % or px. Example: 100%,500px. Default is 500px", 'news' )
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("MapTypeControl",'news'),
            "param_name" => "control",
            'value' => array(
                esc_html__('Yes','news') => 'yes',
                esc_html__('No','news') => 'no',
                ),
            'edit_field_class'=>'vc_col-sm-6 vc_column'
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Scrollwheel",'news'),
            "param_name" => "scrollwheel",
            'value' => array(
                esc_html__('Yes','news') => 'yes',
                esc_html__('No','news') => 'no',
                ),
            'edit_field_class'=>'vc_col-sm-6 vc_column'
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("DisableDefaultUI",'news'),
            "param_name" => "disable_ui",
            'value' => array(
                esc_html__('No','news') => 'no',
                esc_html__('Yes','news') => 'yes',
                ),
            'edit_field_class'=>'vc_col-sm-6 vc_column'
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Draggable",'news'),
            "param_name" => "draggable",
            'value' => array(
                esc_html__('Yes','news') => 'yes',
                esc_html__('No','news') => 'no',
                ),
            'edit_field_class'=>'vc_col-sm-6 vc_column'
        )
    )
));