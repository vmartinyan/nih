<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 08/10/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_post_list3'))
{
    function sv_vc_post_list3($attr)
    {
        $html = $icon_html = '';
        extract(shortcode_atts(array(
            'label'         => '',
            'title'         => '',
            'style'         => '',
            'type_post'     => '',
            'cats'          => '',
            'post_formats'  => '',
            'number'        => '10',
            'order'         => 'DESC',
            'order_by'      => '',
            'view_link'     => '',
        ),$attr));
        $args=array(
            'post_type'         => 'post',
            'posts_per_page'    => $number,
            'orderby'           => $order_by,
            'order'             => $order,
            'paged'             => 1,
        );
        if($order_by == 'post_views'){
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'post_views';
        }
        if($order_by == 'time_update'){
            $args['orderby'] = 'meta_value';
            $args['meta_key'] = 'time_update';
        }
        if($order_by == '_post_like_count'){
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = '_post_like_count';
        }
        if(!empty($cats)) {
            $custom_list = explode(",",$cats);
            $args['tax_query']['relation'] = 'AND';
            $args['tax_query'][]=array(
                'taxonomy'  => 'category',
                'field'     => 'slug',
                'terms'     => $custom_list
            );
        }
        if(!empty($post_formats)) {
            $formats_list = explode(",",$post_formats);            
            $args['tax_query']['relation'] = 'AND';
            $args['tax_query'][]=array(
                'taxonomy'  => 'post_format',
                'field'     => 'slug',
                'terms'     => $formats_list
            );
        }
        if(!empty($type_post)) {
            $type_list = explode(",",$type_post);
            if(in_array('trending-post',$type_list)){
                $args['meta_query']['relation'] = 'OR';
                $args['meta_query'][] = array(
                        'key'     => 'trending_post',
                        'value'   => 'on',
                        'compare' => '=',
                    );
            }
            if(in_array('featured-post',$type_list)){
                $args['meta_query']['relation'] = 'OR';
                $args['meta_query'][] = array(
                        'key'     => 'featured_post',
                        'value'   => 'on',
                        'compare' => '=',
                    );
            }
        }

        $query = new WP_Query($args);
        $count = 1;
        $count_query = $query->post_count;
        $view_html = $button_html = '';
        $view_link = vc_build_link( $view_link );
        if(!empty($icon)){
            if(strpos($icon,'lnr') !== false) $icon_html = '<span class="lnr '.$icon.'"></span>';
            else $icon_html =   '<i class="fa '.$icon.'"></i>';
        }
        switch ($style) {
            case 'post-grid2-home7':
                if(!empty($view_link['url']) && !empty($view_link['title'])){
                    $view_html =    '<a class="viewall" href="'.esc_url($view_link['url']).'">'.$view_link['title'].'</a>';
                }
                $html .=    '<div class="content-popular-bottom">
                                <h2>'.$title.'</h2>
                                <div class="row">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $icon_class = 'lnr-file-empty';
                        $format = get_post_format();
                        if($format == 'video') $icon_class = 'lnr-camera-video';
                        if($format == 'image' || $format == 'gallery') $icon_class = 'lnr-camera';
                $html .=    '<div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="item-popular-bottom">
                                    <div class="popular-bottom-thumb">
                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(230,150)).'</a>
                                        <span class="post-format"><span class="lnr '.$icon_class.'"></span></span>
                                    </div>
                                    <div class="popular-bottom-info">
                                        <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                        <ul>
                                            <li><span class="lnr lnr-clock"></span> '.human_time_diff( get_post_time('U'), current_time('timestamp') ) .' '.  esc_html__("ago","news").'</li>
                                            <li><span class="lnr lnr-bubble"></span> '.get_comments_number().'</li>
                                        </ul>
                                        <p>'.substr(get_the_excerpt(),0,100).'</p>
                                    </div>
                                </div>
                            </div>';
                    }
                }
                $html .=    '</div>'.$view_html.'</div>';
                break;

            case 'post-big-slider':
                if(!empty($view_link['url']) && !empty($view_link['title'])){
                    $view_html =    '<a class="view-all" href="'.esc_url($view_link['url']).'">'.$view_link['title'].'</a>';
                }
                $html .=    '<div class="content-photo-video-slider">
                                <div class="wrap-item">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                $html .=            '<div class="item">
                                        <div class="item-photo-video">
                                            <div class="photo-video-thumb">
                                                <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(1170,500)).'</a>
                                            </div>
                                            <div class="photo-video-info">
                                                <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                            </div>
                                        </div>
                                    </div>';
                    }
                }
                $html .=        '</div>';
                $html .=        $view_html;
                $html .=    '</div>';
                break;

            case 'post-grid-home7':
                $html .=    '<div class="content-most-popular-post">
                                <h2>'.$title.'</h2>
                                <div class="row">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $terms = wp_get_post_terms( get_the_id(), 'category');
                        $term_name = $term_link = $term_html = '';
                        if(is_array($terms) && !empty($terms)){
                            $term_name = $terms[0]->name;
                            $term_link = get_term_link( $terms[0]->term_id, 'category' );
                            $term_html = '<a href="'.esc_url($term_link).'" class="postcat">'.$term_name.'</a>';
                        }
                        $icon_class = 'lnr-file-empty';
                        $format = get_post_format();
                        if($format == 'video') $icon_class = 'lnr-camera-video';
                        if($format == 'image' || $format == 'gallery') $icon_class = 'lnr-camera';
                $html .=    '<div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="item-most-popular-post">
                                    <div class="most-popular-post-thumb">
                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(190,250)).'</a>
                                        <span class="post-format"><span class="lnr '.$icon_class.'"></span></span>
                                    </div>
                                    <div class="most-popular-post-info">
                                        '.$term_html.'
                                        <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                        <a href="'.esc_url(get_the_permalink()).'" class="readmore">'.esc_html__("read more","news").'</a>
                                    </div>
                                </div>
                            </div>';
                    }
                }
                $html .=        '</div>
                            </div>';
                break;

            case 'feature-slider-post':
                if(!empty($view_link['url']) && !empty($view_link['title'])){
                    $view_html =    '<a href="'.esc_url($view_link['url']).'">'.$view_link['title'].'</a>';
                }
                $html .=    '<div class="content-what-new-slider">
                                <div class="what-new-intro intro-bx-latest-post">
                                    <label>'.$label.'</label>
                                    <h2>'.$title.'</h2>
                                    '.$view_html.'
                                </div>
                                <div class="wrap-item">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $terms = wp_get_post_terms( get_the_id(), 'category');
                        $term_name = $term_link = $term_html = '';
                        if(is_array($terms) && !empty($terms)){
                            $term_name = $terms[0]->name;
                            $term_link = get_term_link( $terms[0]->term_id, 'category' );
                            $term_html = '<a href="'.esc_url($term_link).'" class="postcat">'.$term_name.'</a>';
                        }
                        $icon_class = 'lnr-file-empty';
                        $format = get_post_format();
                        if($format == 'video') $icon_class = 'lnr-camera-video';
                        if($format == 'image' || $format == 'gallery') $icon_class = 'lnr-camera';
                if($count % 3 == 1){
                    $html .=        '<div class="item">
                                        <div class="clearfix">';
                    $html .=                '<div class="what-new-left">
                                                <div class="item-what-new item-leading">
                                                    <div class="what-new-thumb">
                                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(600,500)).'</a>
                                                    </div>
                                                    <div class="what-new-info">
                                                        <span class="post-format"><span class="lnr '.$icon_class.'"></span></span>
                                                        '.$term_html.'
                                                        <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    </div>
                                                </div>
                                            </div>';
                }
                if($count % 3 == 2){
                    $html .=                '<div class="what-new-right">
                                                <div class="item-what-new">
                                                    <div class="what-new-thumb">
                                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(360,245)).'</a>
                                                    </div>
                                                    <div class="what-new-info">
                                                        <span class="post-format"><span class="lnr '.$icon_class.'"></span></span>
                                                        '.$term_html.'
                                                        <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    </div>
                                                </div>';
                }
                if($count % 3 == 0){
                    $html .=                    '<div class="item-what-new">
                                                    <div class="what-new-thumb">
                                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(360,245)).'</a>
                                                    </div>
                                                    <div class="what-new-info">
                                                        <span class="post-format"><span class="lnr '.$icon_class.'"></span></span>
                                                        '.$term_html.'
                                                        <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    </div>
                                                </div>
                                            </div>';
                }
                if($count % 3 == 0 || $count == $count_query){
                    $html .=            '</div>
                                    </div>';
                                }
                        $count++;
                    }
                }
                $html .=        '</div>
                            </div>';
                break;

            case 'bx-slider-post':
                if(!empty($view_link['url']) && !empty($view_link['title'])){
                    $view_html =    '<a href="'.esc_url($view_link['url']).'">'.$view_link['title'].'</a>';
                }
                $html .=    '<div class="inner-latest-post-bx-slider">
                                <div class="intro-bx-latest-post">
                                    <label>'.$label.'</label>
                                    <h2>'.$title.'</h2>
                                    '.$view_html.'
                                </div>
                                <div class="content-bx-latest-post">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $terms = wp_get_post_terms( get_the_id(), 'category');
                        $term_name = $term_link = $term_html = '';
                        if(is_array($terms) && !empty($terms)){
                            $term_name = $terms[0]->name;
                            $term_link = get_term_link( $terms[0]->term_id, 'category' );
                            $term_html = '<a href="'.esc_url($term_link).'" class="postcat">'.$term_name.'</a>';
                        }
                $html .=        '<div class="item-bx-latest-post">
                                    <div class="bx-latest-post-thumb">
                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(280,500)).'</a>
                                    </div>
                                    <div class="bx-latest-post-info">
                                        '.$term_html.'
                                        <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                        <ul>
                                            <li><span class="lnr lnr-clock"></span> '.human_time_diff( get_post_time('U'), current_time('timestamp') ) .' '.  esc_html__("ago","news").'</li>
                                            <li><span class="lnr lnr-bubble"></span> '.get_comments_number().'</li>
                                        </ul>
                                    </div>
                                </div>';
                    }
                }
                $html .=        '</div>
                            </div>';
                break;

            default:                
                $html .=    '<div class="inner-banner-gradient">
                                <div class="row">';
                $gradient_num = 1;
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $terms = wp_get_post_terms( get_the_id(), 'category');
                        $term_name = $term_link = $term_html = '';
                        if(is_array($terms) && !empty($terms)){
                            $term_name = $terms[0]->name;
                            $term_link = get_term_link( $terms[0]->term_id, 'category' );
                            $term_html = '<a href="'.esc_url($term_link).'" class="postcat">'.$term_name.'</a>';
                        }
                        if($count % 5 == 1){
                            $html .=    '<div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="item-banner-gradient gradient-leading gradient-green">
                                                <a href="'.esc_url(get_the_permalink()).'" class="gradient-arrow"><span class="lnr lnr-arrow-right"></span></a>
                                                <div class="banner-gradient-thumb">
                                                    <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(580,400)).'</a>
                                                </div>
                                                <div class="banner-gradient-info">
                                                    '.$term_html.'
                                                    <h3 class="post-title"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    <p class="desc">'.substr(get_the_excerpt(),0,80).' </p>
                                                </div>
                                            </div>
                                        </div>';
                        }
                        else{
                            if($count % 5 == 2 || $count % 5 == 4){
                                $html .=    '<div class="col-md-3 col-sm-6 col-xs-12">';
                            }
                            $html .=            '<div class="item-banner-gradient gradient-'.$gradient_num.'">
                                                    <a href="'.esc_url(get_the_permalink()).'" class="gradient-arrow"><span class="lnr lnr-arrow-right"></span></a>
                                                    <div class="banner-gradient-thumb">
                                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(285,195)).'</a>
                                                    </div>
                                                    <div class="banner-gradient-info">
                                                        '.$term_html.'
                                                        <h3 class="post-title"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                        <p class="desc">'.substr(get_the_excerpt(),0,70).' </p>
                                                    </div>
                                                </div>';
                            if($count % 5 == 3 || $count % 5 == 0 || $count == $count_query){
                                $html .=        '</div>';
                            }
                        }
                        $count++;
                        $gradient_num++;
                        if($gradient_num > 5) $gradient_num = 1;
                    }
                }

                $html .=        '</div>
                            </div>';
                break;
        }
        wp_reset_postdata();
        return $html;
    }
}

stp_reg_shortcode('sv_post_list3','sv_vc_post_list3');

vc_map( array(
    "name"      => esc_html__("SV Post List Home 7", 'news'),
    "base"      => "sv_post_list3",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(        
        array(
            "type" => "textfield",
            "heading" => esc_html__("Number post",'news'),
            "param_name" => "number",
            'description'   => esc_html__( 'Number of post display in this element. Default is 10.', 'news' ),
        ),
        array(
            "type"          => "dropdown",
            "holder"        => "div",
            "heading"       => esc_html__("Style Post",'news'),
            "param_name"    => "style",
            "value"         => array(
                esc_html__("Featured Post","news")        => '',
                esc_html__("BxSlider Post","news")        => 'bx-slider-post',
                esc_html__("Feature Slider Post","news")  => 'feature-slider-post',
                esc_html__("Grid Home 7","news")  => 'post-grid-home7',
                esc_html__("Grid 2 Home 7","news")  => 'post-grid2-home7',
                esc_html__("Post Big Slider","news")  => 'post-big-slider',
                ),
            'description'   => esc_html__( 'Choose style to display.', 'news' ),
            'edit_field_class'=>'vc_col-sm-12 vc_column'
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Label",'news'),
            "param_name" => "label",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Title",'news'),
            "param_name" => "title",
        ),
        array(
            "type"          => "checkbox",
            "heading"       => esc_html__("Type Post",'news'),
            "param_name"    => "type_post",
            "value"         => array(
                esc_html__("Default","news") => '',
                esc_html__("Trending Post","news") => 'trending-post',
                esc_html__("Featured Post","news") => 'featured-post',
                ),
            'description'   => esc_html__( 'Choose type of post to display. If empty is show all post.', 'news' ),
            'dependency'  =>  array(
                'element'   => 'style',
                'value'     => array('normal','feature','trending','special-slider')
                ),
        ),
        array(
            "type"          => "checkbox",
            "heading"       => esc_html__("Categories In show",'news'),
            "param_name"    => "cats",
            "value"         => sv_list_taxonomy('category', false),
            'description'   => esc_html__( 'Check list caterories to display. If empty is show all categories.', 'news' )
        ),
        array(
            "type"          => "checkbox",
            "heading"       => esc_html__("Post Format",'news'),
            "param_name"    => "post_formats",
            "value"         => array(
                esc_html__("Image","news")          => 'post-format-image',
                esc_html__("Video","news")          => 'post-format-video',
                esc_html__("Gallery","news")        => 'post-format-gallery',
                esc_html__("Audio","news")          => 'post-format-audio',
                esc_html__("Quote","news")          => 'post-format-quote',
                ),
            'description'   => esc_html__( 'Choose post format to display. If empty is show all post.', 'news' )
        ),
        array(
            "type"          => "dropdown",
            "heading"       => esc_html__("Order",'news'),
            "param_name"    => "order",
            "value"         => array(
                esc_html__('Desc','news') => 'DESC',
                esc_html__('Asc','news')  => 'ASC',
                ),
            'edit_field_class'=>'vc_col-sm-6 vc_column'
        ),
        array(
            "type"          => "dropdown",
            "heading"       => esc_html__("Order By",'news'),
            "param_name"    => "order_by",
            "value"         => sv_get_order_list(),
            'edit_field_class'=>'vc_col-sm-6 vc_column'
        ),
        array(
            'heading'     => esc_html__( 'View link', 'news' ),
            'type'        => 'vc_link',
            'param_name'  => 'view_link',
        ),
    )
));
