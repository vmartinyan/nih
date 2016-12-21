<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 31/08/15
 * Time: 10:00 AM
 */
/************************************Main Carousel*************************************/
if(!function_exists('sv_vc_slide_carousel'))
{
    function sv_vc_slide_carousel($attr, $content = false)
    {
        $html = $css_class = '';
        extract(shortcode_atts(array(
            'item'      => '1',
            'speed'     => '',
            'style'     => '',
            'title'     => '',
            'itemres'   => '',
            'nav_slider'=> 'nav-hidden',
            'auto_height'=> '',
            'animation' => '',
            'custom_css' => '',
        ),$attr));
        if(!empty($custom_css)) $css_class = vc_shortcode_custom_css_class( $custom_css );
        switch ($style) {
            case 'title-topic-slider':
                $html .=    '<div class="hot-topic-slider"><div class="title-topic-slider">
                                <label>'.$title.'</label>';
                $html .=        '<div class="sv-slider '.$css_class.'" data-item="'.$item.'" data-speed="'.$speed.'" data-itemres="'.$itemres.'" data-animation="'.$animation.'" data-nav="content-owl-speaker" data-auto_height="'.$auto_height.'">';
                $html .=            wpb_js_remove_wpautop($content, false);
                $html .=        '</div>';
                $html .=    '</div></div>';
                break;
                break;

            case 'hot-topic-wrap':
                $html .=    '<div class="hot-topics">
                                <div class="row">
                                    <div class="col-md-8 col-sm-10 col-sx-12 col-md-offset-2 col-sm-offset-1">
                                        <div class="hot-topics-slider">
                                            <label class="title-hot-topics">'.$title.'</label>';
                $html .=                    '<div class="sv-slider '.$css_class.'" data-item="'.$item.'" data-speed="'.$speed.'" data-itemres="'.$itemres.'" data-animation="'.$animation.'" data-nav="content-owl-speaker" data-auto_height="'.$auto_height.'">';
                $html .=                        wpb_js_remove_wpautop($content, false);
                $html .=                    '</div>';
                $html .=                '</div>
                                    </div>
                                </div>
                            </div>';
                break;

            case 'speaker-wrap3':
                $html .=    '<div class="latest-new-box include-speak">
                                <h2>'.$title.'</h2>';
                $html .=        '<div class="sv-slider '.$css_class.'" data-item="'.$item.'" data-speed="'.$speed.'" data-itemres="'.$itemres.'" data-animation="'.$animation.'" data-nav="content-owl-speaker" data-auto_height="'.$auto_height.'">';
                $html .=            wpb_js_remove_wpautop($content, false);
                $html .=        '</div>';
                $html .=    '</div>';
                break;

            case 'speaker-wrap2':
                $html .=    '<div class="content-owl-speaker">
                                <h2>'.$title.'</h2>';
                $html .=        '<div class="sv-slider '.$css_class.'" data-item="'.$item.'" data-speed="'.$speed.'" data-itemres="'.$itemres.'" data-animation="'.$animation.'" data-nav="content-owl-speaker" data-auto_height="'.$auto_height.'">';
                $html .=            wpb_js_remove_wpautop($content, false);
                $html .=        '</div>';
                $html .=    '</div>';
                break;

            case 'speaker-wrap':
                $html .=    '<div class="expert-comment">
                                <div class="intro-expert-comment">
                                    <h2>'.$title.'</h2>
                                </div>
                                <div class="info-expert">';
                $html .=            '<div class="sv-slider '.$css_class.'" data-item="'.$item.'" data-speed="'.$speed.'" data-itemres="'.$itemres.'" data-animation="'.$animation.'" data-nav="info-expert" data-auto_height="'.$auto_height.'">';
                $html .=                wpb_js_remove_wpautop($content, false);
                $html .=            '</div>';
                $html .=        '</div>
                            </div>';
                break;
            
            default:
                $html .=    '<div class="wrap-slider '.$nav_slider.'">';
                $html .=        '<div class="sv-slider '.$css_class.'" data-item="'.$item.'" data-speed="'.$speed.'" data-itemres="'.$itemres.'" data-animation="'.$animation.'" data-nav="'.$nav_slider.'" data-auto_height="'.$auto_height.'">';
                $html .=            wpb_js_remove_wpautop($content, false);
                $html .=        '</div>';
                $html .=    '</div>';
                break;
        }        
        return $html;
    }
}
stp_reg_shortcode('slide_carousel','sv_vc_slide_carousel');
vc_map(
    array(
        'name'     => esc_html__( 'Carousel Slider', 'news' ),
        'base'     => 'slide_carousel',
        'category' => esc_html__( '7Up-theme', 'news' ),
        'icon'     => 'icon-st',
        'as_parent' => array( 'only' => 'vc_column_text,slide_banner_item,sv_slide_member_item,slide_banner_social_item,slide_adv_item,slide_speaker_item,slide_speaker_item2,slide_speaker_item3,hot_topic_item' ),
        'content_element' => true,
        'js_view' => 'VcColumnView',
        'params'   => array(
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Style', 'news' ),
                'param_name'  => 'style',
                'value'       => array(
                    esc_html__( 'Default', 'news' )             => '',
                    esc_html__( 'Speaker Wrap', 'news' )        => 'speaker-wrap',
                    esc_html__( 'Speaker Wrap 2', 'news' )      => 'speaker-wrap2',
                    esc_html__( 'Speaker Wrap 3', 'news' )      => 'speaker-wrap3',
                    esc_html__( 'Topic Wrap', 'news' )          => 'hot-topic-wrap',
                    esc_html__( 'Topic title', 'news' )        => 'title-topic-slider',
                    )
            ),
            array(
                'heading'     => esc_html__( 'Title', 'news' ),
                'type'        => 'textfield',
                'param_name'  => 'title',
                'dependency'  => array(
                    'element'   => 'style',
                    'value'   => array('speaker-wrap','speaker-wrap2','speaker-wrap3','hot-topic-wrap','title-topic-slider'),
                    )
            ),
            array(
                'heading'     => esc_html__( 'Item slider display', 'news' ),
                'type'        => 'textfield',
                'description' => esc_html__( 'Enter number of item. Default is 1.', 'news' ),
                'param_name'  => 'item',
            ),
            array(
                'heading'     => esc_html__( 'Speed', 'news' ),
                'type'        => 'textfield',
                'description' => esc_html__( 'Enter time slider go to next item. Unit (ms). Example 5000. If empty this field autoPlay is false.', 'news' ),
                'param_name'  => 'speed',
            ),
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Navigation style', 'news' ),
                'param_name'  => 'nav_slider',
                'value'       => array(
                    esc_html__( 'Hidden', 'news' )   => 'nav-hidden',
                    esc_html__( 'Default', 'news' )   => 'default',
                    esc_html__( 'Banner navigation', 'news' )   => 'home-paginav',
                    esc_html__( 'Arrow top right', 'news' )   => 'home-direct-nav',
                    esc_html__( 'Arrow circle', 'news' )   => 'event-banner-slider',
                    esc_html__( 'Arrow banner shop', 'news' )   => 'banner-shop-slider',
                    esc_html__( 'Banner home 6 style', 'news' )   => 'banner-slider6',
                    esc_html__( 'Advantage style', 'news' )   => 'adv-slider',
                    )
            ),
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Auto Height', 'news' ),
                'param_name'  => 'auto_height',
                'value'       => array(
                    esc_html__( 'No', 'news' )   => '',
                    esc_html__( 'Yes', 'news' )   => 'yes',
                    )
            ),
            array(
                'heading'     => esc_html__( 'Custom Item', 'news' ),
                'type'        => 'textfield',
                'description' => esc_html__( 'Enter custom item for each window 360px,480px,768px,992px. Default is auto. Example: "2,3,4,5"', 'news' ),
                'param_name'  => 'itemres',
            ),
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Animation', 'news' ),
                'param_name'  => 'animation',
                'value'       => array(
                    esc_html__( 'None', 'news' )        => '',
                    esc_html__( 'Fade', 'news' )        => 'fade',
                    esc_html__( 'BackSlide', 'news' )   => 'backSlide',
                    esc_html__( 'GoDown', 'news' )      => 'goDown',
                    esc_html__( 'FadeUp', 'news' )      => 'fadeUp',
                    )
            ),
            array(
                "type"          => "css_editor",
                "heading"       => esc_html__("Custom Block",'news'),
                "param_name"    => "custom_css",
                'group'         => esc_html__('Advanced','news')
            )
        )
    )
);

/*******************************************END MAIN*****************************************/


/**************************************BEGIN ITEM************************************/
//Banner item Frontend
if(!function_exists('sv_vc_slide_banner_item'))
{
    function sv_vc_slide_banner_item($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'     => '',
            'image'     => '',
            'link'      => '',
        ),$attr));
        if(!empty($image)){
            switch ($style) {
                case 'style-2':
                    $html .=    '<div class="item">
                                    <div class="event-banner-thumb">
                                        <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                    </div>
                                    <div class="event-banner-info">
                                        '.wpb_js_remove_wpautop($content, true).'
                                    </div>
                                </div>';
                    break;
                
                default:
                    $html .=    '<div class="item">
                            <div class="thumb-slider">
                                <a href="'.esc_url($link).'" class="link-thumb-slider">
                                    '.wp_get_attachment_image($image,'full').'
                                </a>
                            </div>
                            <div class="info-slider">
                                '.wpb_js_remove_wpautop($content, true).'
                            </div>
                        </div>';
                    break;
            }               
        }
        return $html;
    }
}
stp_reg_shortcode('slide_banner_item','sv_vc_slide_banner_item');

// Banner item
vc_map(
    array(
        'name'     => esc_html__( 'Banner Item', 'news' ),
        'base'     => 'slide_banner_item',
        'icon'     => 'icon-st',
        'content_element' => true,
        'as_child' => array('only' => 'slide_carousel'),
        'params'   => array(
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Style', 'news' ),
                'param_name'  => 'style',
                'value'       => array(
                    esc_html__( 'Style 1', 'news' )   => '',
                    esc_html__( 'Style 2', 'news' )   => 'style-2',
                    )
            ),
            array(
                'type'        => 'attach_image',
                'heading'     => esc_html__( 'Image', 'news' ),
                'param_name'  => 'image',
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Link Banner', 'news' ),
                'param_name'  => 'link',
            ),
            array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_html__("Content",'news'),
                "param_name" => "content",
            ),
            array(
                    "type"          => "css_editor",
                    "heading"       => esc_html__("Custom Block",'news'),
                    "param_name"    => "custom_css",
                    'group'         => esc_html__('Advanced','news')
                )
        )
    )
);

/**************************************END ITEM************************************/

/**************************************BEGIN ITEM************************************/
//Banner item Frontend
if(!function_exists('sv_vc_slide_adv_item'))
{
    function sv_vc_slide_adv_item($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'     => 'adv-info1',
            'image'     => '',
            'link'      => '',
        ),$attr));
        if(!empty($image)){            
            $html .=    '<div class="item">
                            <div class="item-adv-slider">
                                <div class="adv-slider-thumb">
                                    <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                </div>
                                <div class="adv-slider-info '.$style.'">
                                    '.wpb_js_remove_wpautop($content, true).'
                                </div>
                            </div>
                        </div>';
        }
        return $html;
    }
}
stp_reg_shortcode('slide_adv_item','sv_vc_slide_adv_item');

// Banner item
vc_map(
    array(
        'name'     => esc_html__( 'Advantage Item', 'news' ),
        'base'     => 'slide_adv_item',
        'icon'     => 'icon-st',
        'content_element' => true,
        'as_child' => array('only' => 'slide_carousel'),
        'params'   => array(
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Style', 'news' ),
                'param_name'  => 'style',
                'value'       => array(
                    esc_html__( 'Style 1', 'news' )   => 'adv-info1',
                    esc_html__( 'Style 2', 'news' )   => 'adv-info2',
                    esc_html__( 'Style 3', 'news' )   => 'adv-info3',
                    esc_html__( 'Style 4', 'news' )   => 'adv-info4',
                    esc_html__( 'Style 5', 'news' )   => 'adv-info5',
                    )
            ),
            array(
                'type'        => 'attach_image',
                'heading'     => esc_html__( 'Image', 'news' ),
                'param_name'  => 'image',
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Link Banner', 'news' ),
                'param_name'  => 'link',
            ),
            array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_html__("Content",'news'),
                "param_name" => "content",
            )
        )
    )
);

/**************************************END ITEM************************************/

/**************************************BEGIN ITEM************************************/
//Banner item Frontend
if(!function_exists('sv_vc_slide_banner_icon_item'))
{
    function sv_vc_slide_banner_icon_item($attr, $content = false)
    {
        $html = $social_html = '';
        extract(shortcode_atts(array(
            'style'     => 'header-style',
            'image'     => '',
            'link'      => '',
            'list'      => '',
        ),$attr));
        if(!empty($image)){
            parse_str( urldecode( $list ), $data);
            if(is_array($data)){
                foreach ($data as $key => $value) {
                    $url = '#';
                    if(isset($value['url'])) $url = $value['url'];
                    $social_html .=  '<a href="'.esc_url($url).'"><i class="fa '.$value['social'].'"></i></a>';
                }
            }   
            switch ($style) {
                case 'footer-style':
                    $html .=    '<div class="item">
                                    <div class="item-page-layout">
                                        <div class="page-layout-thumb">
                                            <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                        </div>
                                        <div class="page-layout-info">
                                            '.wpb_js_remove_wpautop($content, true).'
                                            <div class="social-page-layout">';
                    $html .=                    $social_html;
                    $html .=                '</div>
                                        </div>
                                    </div>
                                </div>';
                    break;
                
                default:
                    $html .=    '<div class="item">
                                    <div class="item-banner-slider">
                                        <div class="item-banner-thumb">
                                            <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                        </div>
                                        <div class="item-banner-info">
                                            '.wpb_js_remove_wpautop($content, true).'
                                            <div class="social-banner-slider">';
                    $html .=                    $social_html;                            
                    $html .=                '</div>
                                        </div>
                                    </div>
                                </div>';
                    break;
            }               
        }
        return $html;
    }
}
stp_reg_shortcode('slide_banner_social_item','sv_vc_slide_banner_icon_item');

// Banner item
vc_map(
    array(
        'name'     => esc_html__( 'Banner Social Item', 'news' ),
        'base'     => 'slide_banner_social_item',
        'icon'     => 'icon-st',
        'content_element' => true,
        'as_child' => array('only' => 'slide_carousel'),
        'params'   => array(
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Style', 'news' ),
                'param_name'  => 'style',
                'value'       => array(
                    esc_html__( 'Header style', 'news' )   => 'header-style',
                    esc_html__( 'Footer style', 'news' )   => 'footer-style',
                    )
            ),
            array(
                'type'        => 'attach_image',
                'heading'     => esc_html__( 'Image', 'news' ),
                'param_name'  => 'image',
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Link Banner', 'news' ),
                'param_name'  => 'link',
            ),
            array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_html__("Content",'news'),
                "param_name" => "content",
            ),
            array(
                "type" => "add_social",
                "heading" => esc_html__("Add Social List",'news'),
                "param_name" => "list",
            )
        )
    )
);

/**************************************END ITEM************************************/

/**************************************BEGIN ITEM************************************/
//Banner item Frontend
if(!function_exists('sv_vc_slide_speaker_item'))
{
    function sv_vc_slide_speaker_item($attr, $content = false)
    {
        $html = $social_html = '';
        extract(shortcode_atts(array(
            'image'     => '',
            'title'     => '',
            'link'      => '',
            'list'      => '',
        ),$attr));
        if(!empty($image)){
            parse_str( urldecode( $list ), $data);
            if(is_array($data)){
                foreach ($data as $key => $value) {
                    $url = '#';
                    if(isset($value['url'])) $url = $value['url'];
                    $social_html .=  '<a href="'.esc_url($url).'"><i class="fa '.$value['social'].'"></i></a>';
                }
            }
            $html .=    '<div class="item">
                            <div class="item-expert">
                                <a href="'.esc_url($link).'" class="expert-avatar">'.wp_get_attachment_image($image,array(96,96)).'</a>
                                <p class="content-expert-comment">'.$title.'</p>
                                <div class="social-expert-comment">';
            $html .=                $social_html;                            
            $html .=            '</div>
                            </div>
                        </div>';
        }
        return $html;
    }
}
stp_reg_shortcode('slide_speaker_item','sv_vc_slide_speaker_item');

// Banner item
vc_map(
    array(
        'name'     => esc_html__( 'Speaker Item', 'news' ),
        'base'     => 'slide_speaker_item',
        'icon'     => 'icon-st',
        'content_element' => true,
        'as_child' => array('only' => 'slide_carousel'),
        'params'   => array(
            array(
                'type'        => 'attach_image',
                'heading'     => esc_html__( 'Avatar', 'news' ),
                'param_name'  => 'image',
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Title', 'news' ),
                'param_name'  => 'title',
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Link', 'news' ),
                'param_name'  => 'link',
            ),
            array(
                "type" => "add_social",
                "heading" => esc_html__("Add Social List",'news'),
                "param_name" => "list",
            )
        )
    )
);

/**************************************END ITEM************************************/

/**************************************BEGIN ITEM************************************/
//Banner item Frontend
if(!function_exists('sv_vc_slide_speaker_item2'))
{
    function sv_vc_slide_speaker_item2($attr, $content = false)
    {
        $html = $social_html = '';
        extract(shortcode_atts(array(
            'style'     => 'speaker-green',
            'image'     => '',
            'title'     => '',
            'link'      => '',
        ),$attr));
        if(!empty($image)){            
            $html .=    '<div class="item item-speaker2">
                            <div class="item-owl-speaker '.$style.'">
                                <div class="owl-speaker-thumb">
                                    <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                </div>
                                <div class="owl-speaker-info">
                                    <h3><a href="'.esc_url($link).'">'.$title.'</a></h3>
                                    '.wpb_js_remove_wpautop($content, true).'
                                    <a href="'.esc_url($link).'" class="readmore"><span>'.esc_html__("read more","news").'</span></a>
                                </div>
                            </div>
                        </div>';
        }
        return $html;
    }
}
stp_reg_shortcode('slide_speaker_item2','sv_vc_slide_speaker_item2');

// Banner item
vc_map(
    array(
        'name'     => esc_html__( 'Speaker Item 2', 'news' ),
        'base'     => 'slide_speaker_item2',
        'icon'     => 'icon-st',
        'content_element' => true,
        'as_child' => array('only' => 'slide_carousel'),
        'params'   => array(
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Style', 'news' ),
                'param_name'  => 'style',
                'value'       => array(
                    esc_html__( 'Green', 'news' )   => 'speaker-green',
                    esc_html__( 'Red', 'news' )   => 'speaker-red',
                    esc_html__( 'Blue', 'news' )   => 'speaker-blue',
                    esc_html__( 'Orange', 'news' )   => 'speaker-orange',
                    )
            ),
            array(
                'type'        => 'attach_image',
                'heading'     => esc_html__( 'Avatar', 'news' ),
                'param_name'  => 'image',
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Title', 'news' ),
                'param_name'  => 'title',
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Link', 'news' ),
                'param_name'  => 'link',
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

/**************************************BEGIN ITEM************************************/
//Banner item Frontend
if(!function_exists('sv_vc_slide_speaker_item3'))
{
    function sv_vc_slide_speaker_item3($attr, $content = false)
    {
        $html = $social_html = '';
        extract(shortcode_atts(array(
            'image'     => '',
            'name'     => '',
            'link'      => '',
            'pos'      => '',
            'des'      => '',
        ),$attr));
        if(!empty($image)){
            $html .=    '<div class="item">
                            <div class="item-include-speak">
                                <div class="include-speak-thumb">
                                    <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                </div>
                                <p class="desc"><span class="desc-special">&rdquo;</span>'.$des.'<span class="desc-special">&rdquo;</span></p>
                                <div class="include-speak-info">
                                    <h3><a href="'.esc_url($link).'">'.$name.'</a></h3>
                                    <span>'.$pos.'</span>
                                </div>
                            </div>
                        </div>';
        }
        return $html;
    }
}
stp_reg_shortcode('slide_speaker_item3','sv_vc_slide_speaker_item3');

// Banner item
vc_map(
    array(
        'name'     => esc_html__( 'Speaker Item 3', 'news' ),
        'base'     => 'slide_speaker_item3',
        'icon'     => 'icon-st',
        'content_element' => true,
        'as_child' => array('only' => 'slide_carousel'),
        'params'   => array(
            array(
                'type'        => 'attach_image',
                'heading'     => esc_html__( 'Avatar', 'news' ),
                'param_name'  => 'image',
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Name', 'news' ),
                'param_name'  => 'name',
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Position', 'news' ),
                'param_name'  => 'pos',
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Link', 'news' ),
                'param_name'  => 'link',
            ),
            array(
                "type" => "textarea",
                "holder" => "div",
                "heading" => esc_html__("Description",'news'),
                "param_name" => "des",
            ),
        )
    )
);

/**************************************END ITEM************************************/

/**************************************BEGIN ITEM************************************/
//Banner item Frontend
if(!function_exists('sv_vc_hot_topic_item'))
{
    function sv_vc_hot_topic_item($attr, $content = false)
    {
        $html = $social_html = '';
        extract(shortcode_atts(array(
            'des'     => '',
            'link'      => '',
        ),$attr));
        $html .=    '<div class="item-hot-topics">
                        <a href="'.esc_url($link).'"><p>'.$des.'</p></a>
                    </div>';
        return $html;
    }
}
stp_reg_shortcode('hot_topic_item','sv_vc_hot_topic_item');

// Banner item
vc_map(
    array(
        'name'     => esc_html__( 'Topic Item', 'news' ),
        'base'     => 'hot_topic_item',
        'icon'     => 'icon-st',
        'content_element' => true,
        'as_child' => array('only' => 'slide_carousel'),
        'params'   => array(            
            array(
                "type" => "textarea",
                "holder" => "div",
                "heading" => esc_html__("Description",'news'),
                "param_name" => "des",
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Link', 'news' ),
                'param_name'  => 'link',
            ),
        )
    )
);

/**************************************END ITEM************************************/

/**************************************BEGIN ITEM************************************/
//Banner item Frontend
if(!function_exists('sv_vc_slide_member_item'))
{
    function sv_vc_slide_member_item($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'avatar'        => '',
            'name'          => '',
            'position'      => '',
            'link'      => '',
            'phone'           => '',
            'email'         => '',
            'social'         => '',
        ),$attr));
        $html .=    '<div class="item">
                        <div class="item-team-slider">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">';
        $html .=                    '<div class="team-slider-thumb">
                                        <a href="'.esc_url($link).'">'.wp_get_attachment_image($avatar,'full').'</a>
                                    </div>
                                    <ul class="team-slider-info">
                                        <li class="tel-info"><a href="'.esc_url($link).'"> '.esc_html__("Tel:","news").' '.$phone.'</a></li>
                                        <li class="email-info"><a href="'.esc_url($link).'"> '.esc_html__("Email:","news").' '.$email.'</a></li>
                                    </ul>';
        
        parse_str( urldecode( $social ), $data);
        if(is_array($data)){
            $html .=                '<ul class="team-social">';
            $i = 1;
            foreach ($data as $key => $value) {
                $url = '#';
                $el_class = 'fb-team';
                if($i == 2) $el_class = 'tw-team';
                if($i == 3) $el_class = 'li-team';
                if($i == 4) $el_class = 'pi-team';
                if(isset($value['url'])) $url = $value['url'];
                $html .= '<li><a href="'.esc_url($url).'" class="'.$el_class.'"><i class="fa '.$value['social'].'"></i></a></li>';
                $i++;
                if($i > 4 ) $i = 1;
            }
            $html .=                '</ul>';
        } 
        $html .=                '</div>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <div class="team-slider-content">
                                        <span>'.$name.'</span>
                                        <h3>'.$position.'</h3>
                                        '.wpb_js_remove_wpautop($content, true).'
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
        return $html;
    }
}
stp_reg_shortcode('sv_slide_member_item','sv_vc_slide_member_item');

// Banner item
vc_map(
    array(
        'name'     => esc_html__( 'Member Item', 'news' ),
        'base'     => 'sv_slide_member_item',
        'icon'     => 'icon-st',
        'content_element' => true,
        'as_child' => array('only' => 'slide_carousel'),
        'params'   => array(
            array(
                'type'        => 'attach_image',
                'heading'     => esc_html__( 'Avatar', 'news' ),
                'param_name'  => 'avatar',
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Name', 'news' ),
                'param_name'  => 'name',
                'edit_field_class'=>'vc_col-sm-6 vc_column',
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Position', 'news' ),
                'param_name'  => 'position',
                'edit_field_class'=>'vc_col-sm-6 vc_column',
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Phone', 'news' ),
                'param_name'  => 'phone',
                'edit_field_class'=>'vc_col-sm-6 vc_column',
            ),
             array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Email', 'news' ),
                'param_name'  => 'email',
                'edit_field_class'=>'vc_col-sm-6 vc_column',
            ),
              array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Link Member', 'news' ),
                'param_name'  => 'link',
            ),
            array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_html__("Content",'news'),
                "param_name" => "content",
            ),
            array(
                "type" => "add_social",
                "heading" => esc_html__("Add Social List",'news'),
                "param_name" => "social",
            )
        )
    )
);

/**************************************END ITEM************************************/


//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Slide_Carousel extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Slide_Banner_Item extends WPBakeryShortCode {}
    class WPBakeryShortCode_Slide_Member_Item extends WPBakeryShortCode {}
    class WPBakeryShortCode_Slide_Speaker_Item extends WPBakeryShortCode {}
    class WPBakeryShortCode_Slide_Speaker_Item2 extends WPBakeryShortCode {}
    class WPBakeryShortCode_Slide_Speaker_Item3 extends WPBakeryShortCode {}
    class WPBakeryShortCode_Hot_Topic_Item extends WPBakeryShortCode {}
}