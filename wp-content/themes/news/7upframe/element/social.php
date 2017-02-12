<?php
/**
 * @version    1.0
 * @package    Aqualoa
 * @author     7up Team <7uptheme.com>
 * @copyright  Copyright (C) 2015 7uptheme. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.7uptheme.com
 */
if(!function_exists('sv_vc_social'))
{
    function sv_vc_social($attr, $content = false)
    {
        $html = $icon_html = '';
        extract(shortcode_atts(array(
            'style'         => 'social-footer',
            'list'          => '',
            'align'         => 'text-left',
        ),$attr));
		parse_str( urldecode( $list ), $data);
        if(is_array($data)){
            foreach ($data as $key => $value) {
                $url = '#';
                if(isset($value['url'])) $url = $value['url'];
                $icon_html .= '<a class="social-'.$key.'" href="'.esc_url($url).'"><i class="fa '.$value['social'].'"></i></a>';
            }
        }
        $html .=    '<div class="'.$style.' '.$align.'">';                        
        $html .=        $icon_html;   
        $html .=    '</div>';   
		return  $html;
    }
}

stp_reg_shortcode('sv_social','sv_vc_social');


vc_map( array(
    "name"      => esc_html__("SV Social", 'news'),
    "base"      => "sv_social",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Style', 'news' ),
            'param_name'  => 'style',
            'value'       => array(
                esc_html__( 'Style 1', 'news' )   => 'social-footer',
                esc_html__( 'Social footer 3', 'news' )   => 'social-footer3',
                esc_html__( 'Style 2', 'news' )   => 'event-social-footer',
                esc_html__( 'Background color social', 'news' )   => 'social-footer-shop',
                esc_html__( 'Social footer 6', 'news' )   => 'social-footer-shop social-footer6',
                esc_html__( 'Social header 6', 'news' )   => 'social-header6',
                esc_html__( 'Social header 7', 'news' )   => 'social-header-7',
                )
        ),
        array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Align', 'news' ),
			'value' => array(
				esc_html__( 'Align Left', 'news' ) => 'text-left',
				esc_html__( 'Align Center', 'news' ) => 'text-center',
				esc_html__( 'Align Right', 'news' ) => 'text-right',
			),
			'param_name' => 'align',
			'description' => esc_html__( 'Select social layout', 'news' ),
		),
		array(
            "type" => "add_social",
            "heading" => esc_html__("Add Social List",'news'),
            "param_name" => "list",
        )
    )
));