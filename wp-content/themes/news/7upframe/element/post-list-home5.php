<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 08/10/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_post_list6'))
{
    function sv_vc_post_list6($attr)
    {
        $html = $icon_html = '';
        extract(shortcode_atts(array(
            'title'         => '',
            'style'         => '',
            'image'         => '',
            'type_post'     => '',
            'cats'          => '',
            'post_formats'  => '',
            'number'        => '10',
            'order'         => 'DESC',
            'order_by'      => '',
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
        switch ($style) {
            case 'gallery-style':
                $ul_html = $bx_html = '';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $rid = rand(1,100);
                        $key = $count -1;
                        $ul_html .=    '<li>'.get_the_post_thumbnail(get_the_ID(),array(433,244)).'</li>';
                        $bx_html .=    '<a data-slide-index="'.$key.'" href="#">'.get_the_post_thumbnail(get_the_ID(),array(100,70)).'</a>';
                        $count++;
                    }
                }
                $html .=    '<div class="latest-new-box new-gallery">
                                <h2 class="neew-events-title">'.$title.'</h2>
                                <div class="bx-wrapper">
                                    <ul class="bxslider5" data-bxid="'.$rid.'">
                                        '.$ul_html.'
                                    </ul>
                                    <div id="bx-pager'.$rid.'" class="bx-pager5">
                                        '.$bx_html.'
                                    </div>
                                </div>
                            </div>';
                break;

            case 'list-style2':
                $html .=    '<div class="latest-new-box latest-new5">
                                <h2>'.$title.'</h2>';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                    $html .=    '<div class="item-latest-new5">
                                    <div class="latest-new-thumb5">
                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(120,120)).'</a>
                                    </div>
                                    <div class="latest-new-info5">
                                        <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                        <ul class="post-info5">
                                            <li><span class="lnr lnr-clock"></span> '.get_the_time('d M Y').'</li>
                                            <li><span class="lnr lnr-bubble"></span> '.get_comments_number().'</li>
                                        </ul>
                                        <p>'.substr(get_the_excerpt(),0,115).'</p>
                                    </div>
                                </div>';
                    }
                }
                $html .=    '</div>';
                break;

            case 'video-style':
                $list_html = $leading_html = $bg_image = '';
                if(!empty($image)){
                    $bg_image = SV_Assets::build_css('background: rgba(0, 0, 0, 0) url("'.wp_get_attachment_url($image).'") no-repeat scroll center center;');
                }
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $terms = wp_get_post_terms( get_the_id(), 'category');
                        $term_name = $term_link = $term_html = '';
                        if(is_array($terms) && !empty($terms)){
                            $term_name = $terms[0]->name;
                            $term_link = get_term_link( $terms[0]->term_id, 'category' );
                            $term_html = '<a href="'.esc_url($term_link).'" class="video-cat">'.$term_name.'</a>';
                        }
                        $icon_class = 'lnr-file-empty';
                        $format = get_post_format();
                        if($format == 'video') $icon_class = 'lnr-camera-video';
                        if($format == 'image' || $format == 'gallery') $icon_class = 'lnr-camera';
                        if($count % 4 == 1){
                            $leading_html .= '<div class="leading-category-video">
                                                <span class="video-format"><span class="lnr '.$icon_class.'"></span></span>
                                                '.$term_html.'
                                                <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                <p>'.substr(get_the_excerpt(),0,60).'</p>
                                                <div class="video-social">
                                                    '.sv_share_box().'
                                                </div>
                                            </div>';
                        }
                        else{
                            $list_html .=   '<div class="item-category-video clearfix">
                                                <div class="category-video-thumb">
                                                    <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(182,121)).'</a>
                                                    <span class="video-format"><span class="lnr '.$icon_class.'"></span></span>
                                                </div>
                                                <div class="category-video-info">
                                                    '.$term_html.'
                                                    <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    <div class="video-social">
                                                        '.sv_share_box().'
                                                    </div>
                                                </div>
                                            </div>';
                        }
                        $count++;
                    }
                }
                $html .=    '<div class="category-video video-popular-box '.$bg_image.'">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="list-category-video">
                                            <h2>'.$title.'</h2>';
                $html .=                    $list_html;
                $html .=                '</div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        '.$leading_html.'
                                    </div>
                                </div>
                            </div>';
                break;

            default:                
                $html .=    '<div class="most-popular5 video-popular-box">
                                <h2>'.$title.'</h2>';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $html .=    '<div class="item-most-popular5">
                                        <div class="popular-index"><span>'.$count.'</span></div>
                                        <div class="popular-info-post">
                                            <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                            <ul class="post-info5">
                                                <li><span class="lnr lnr-clock"></span> '.get_the_time('d M Y').'</li>
                                                <li><span class="lnr lnr-bubble"></span> '.get_comments_number().'</li>
                                            </ul>
                                        </div>
                                    </div>';
                        $count++;
                    }
                }                  
                $html .=    '</div>';
                break;
        }
        wp_reset_postdata();
        return $html;
    }
}

stp_reg_shortcode('sv_post_list6','sv_vc_post_list6');

vc_map( array(
    "name"      => esc_html__("SV Post List Home 5", 'news'),
    "base"      => "sv_post_list6",
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
                esc_html__("Normal","news")             => '',
                esc_html__("List style 2","news")             => 'list-style2',
                esc_html__("Video style","news")             => 'video-style',
                esc_html__("Gallery style","news")             => 'gallery-style',
                ),
            'description'   => esc_html__( 'Choose style to display.', 'news' ),
        ),
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Title",'news'),
            "param_name" => "title",
        ),
        array(
            "type" => "attach_image",
            "heading" => esc_html__("Image",'news'),
            "param_name" => "image",
            'dependency'  =>  array(
                'element'   => 'style',
                'value'     => 'video-style'
                ),
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
        ),
        array(
            "type"          => "checkbox",
            "holder"        => "div",
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
    )
));


