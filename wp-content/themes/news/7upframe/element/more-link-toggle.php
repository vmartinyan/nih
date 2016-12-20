<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 23/01/16
 * Time: 10:00 AM
 */
/************************************Main Carousel*************************************/
if(!function_exists('sv_vc_more_link'))
{
    function sv_vc_more_link($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'label' => ''
        ),$attr));
        $html .=    '<div class="extra-content">
                        <div class="extra-menu">
                            <a href="#" class="btn-extra-menu">'.$label.' <span class="lnr lnr-chevron-down"></span></span></a>
                            <div class="extra-menu-dropdown">
                                <div class="row">';        
        $html .=                    wpb_js_remove_wpautop($content, false);
        $html .=                '</div>';
        $html .=            '</div>
                        </div>
                    </div>';
        return $html;
    }
}
stp_reg_shortcode('sv_more_link','sv_vc_more_link');
vc_map(
    array(
        'name'     => esc_html__( 'SV More Link Toggle', 'news' ),
        'base'     => 'sv_more_link',
        'category' => esc_html__( '7Up-theme', 'news' ),
        'icon'     => 'icon-st',
        'as_parent' => array( 'only' => 'vc_column_text,sv_more_link_item' ),
        'content_element' => true,
        'js_view' => 'VcColumnView',
        'params'   => array(
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Label', 'news' ),
                'param_name'  => 'label',
            ),
        )
    )
);

/*******************************************END MAIN*****************************************/


/**************************************BEGIN ITEM************************************/
//Banner item Frontend
if(!function_exists('sv_vc_more_link_item'))
{
    function sv_vc_more_link_item($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'width'     => 'col-md-12 col-sm-12 col-xs-12',
        ),$attr));
        $html .=    '<div class="'.$width.'">
                        <div class="item-extra-menu">
                            '.wpb_js_remove_wpautop($content, true).'
                        </div>
                    </div>';
        return $html;
    }
}
stp_reg_shortcode('sv_more_link_item','sv_vc_more_link_item');

// Banner item
vc_map(
    array(
        'name'     => esc_html__( 'More Link Item', 'news' ),
        'base'     => 'sv_more_link_item',
        'icon'     => 'icon-st',
        'content_element' => true,
        'as_child' => array('only' => 'sv_more_link'),
        'params'   => array(
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Width', 'news' ),
                'param_name'  => 'width',
                'value'       => array(
                    esc_html__( '12 Column', 'news' )   => 'col-md-12 col-sm-12 col-xs-12',
                    esc_html__( '11 Column', 'news' )   => 'col-md-11 col-sm-11 col-xs-12',
                    esc_html__( '10 Column', 'news' )   => 'col-md-10 col-sm-10 col-xs-12',
                    esc_html__( '9 Column', 'news' )   => 'col-md-9 col-sm-9 col-xs-12',
                    esc_html__( '8 Column', 'news' )   => 'col-md-8 col-sm-8 col-xs-12',
                    esc_html__( '7 Column', 'news' )   => 'col-md-7 col-sm-7 col-xs-12',
                    esc_html__( '6 Column', 'news' )   => 'col-md-6 col-sm-6 col-xs-12',
                    esc_html__( '5 Column', 'news' )   => 'col-md-5 col-sm-5 col-xs-12',
                    esc_html__( '4 Column', 'news' )   => 'col-md-4 col-sm-6 col-xs-12',
                    esc_html__( '3 Column', 'news' )   => 'col-md-3 col-sm-6 col-xs-12',
                    esc_html__( '2 Column', 'news' )   => 'col-md-2 col-sm-4 col-xs-12',
                    esc_html__( '1 Column', 'news' )   => 'col-md-1 col-sm-3 col-xs-12',
                    )
            ),            
            array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_html__("Content",'news'),
                "param_name" => "content",
            ),
        )
    )
);

/**************************************END ITEM************************************/


//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_sv_more_link extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_sv_more_link_item extends WPBakeryShortCode {}
}