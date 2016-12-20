<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 08/10/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_post_list5'))
{
    function sv_vc_post_list5($attr)
    {
        $html = $icon_html = '';
        extract(shortcode_atts(array(
            'title'         => '',
            'des'           => '',
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
            case 'mega-more-new':
                $html .=    '<div class="mega-more-news">
                                <h2>'.$title.'</h2>';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $html .=    '<div class="item-mega-more-news">
                                        <div class="mega-more-news-index"><span>'.$count.'</span></div>
                                        <div class="mega-more-news-title"><h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3></div>
                                        <div class="mega-more-news-link"><a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(120,80)).'</a></div>
                                    </div>';
                        $count++;
                    }
                }
                $html .=    '</div>';
                break;

            case 'mega-vertical-slider':
                $html .=    '<div class="extra-mega-dropdown">
                                <h2>'.$title.'</h2>
                                <div class="control-mega-slider">
                                    <a href="#" class="prev"><span class="lnr lnr-chevron-down-circle"></span></a>
                                    <a href="#" class="next"><span class="lnr lnr-chevron-up-circle"></span></a>
                                </div>
                                <div class="vertical-mega-slider">
                                    <ul>';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $html .=        '<li><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></li>';
                    }
                }
                $html .=            '</ul>
                                </div>
                            </div>';
                break;

            case 'slider-cat':
                if(!empty($cats)){
                    $cates = explode(',', $cats);
                    $html .=    '<div class="latest-news-category">
                                    <h2 class="title-latest-news-category"><span>Latest News</span></h2>
                                    <div class="content-latest-news-category">
                                        <div class="wrap-item">';
                    foreach ($cates as $key => $cat) {
                        $count = $key+1;
                        $term = get_term_by( 'slug',$cat, 'category' );
                        $term_link = get_term_link( $term->term_id, 'category' );
                        if($count % 2 == 1) $html .=    '<div class="item">';
                        $thumbnail_link = get_term_meta( $term->term_id, 'cat-thumb', true );
                        $html .=    '<div class="item-latest-category">
                                        <div class="latest-category-thumb">
                                            <a href="'.esc_url($term_link).'"><img src="'.esc_url($thumbnail_link).'" alt=""></a>
                                        </div>
                                        <div class="latest-category-info">
                                            <h2>'.$term->name.'</h2>
                                            <ul>';
                        $args['tax_query'] = array();
                        $args['tax_query'][]=array(
                                            'taxonomy'=>'category',
                                            'field'=>'slug',
                                            'terms'=> $cat
                                        );
                        $post_query = new WP_Query($args);
                        $count_query = $post_query->post_count;
                        if($post_query->have_posts()) {
                            while($post_query->have_posts()) {
                                $post_query->the_post();
                                $html .=    '<li><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></li>';
                            }
                        }
                        $html .=            '</ul>
                                            <a href="'.esc_url($term_link).'" class="view-all"><span class="lnr lnr-arrow-right-circle"></span> '.esc_html__("View All","news").'</a>
                                        </div>
                                    </div>';

                        if($count % 2 == 0 || $count == count($cates)) $html .=    '</div>';
                    }
                    $html .=            '</div>
                                    </div>
                                </div>';
                }
                break;

            case 'post-lock':
                $html .=    '<div class="nowon-news">
                                <h2 class="nowon-title"><span>'.$title.'</span></h2>
                                <ul class="list-post-nowon">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $html .=    '<li>
                                        <div class="index-nowon-news"><span>'.$count.'.</span></div>
                                        <div class="content-nowon-news">
                                            <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                            <ul>
                                                <li><span class="lnr lnr-clock"></span> '.get_the_time('d M Y').'</li>
                                                <li>'.esc_html__("By: ","news").get_the_author().'</li>
                                            </ul>
                                            <p>'.substr(get_the_excerpt(),0,100).'</p>
                                        </div>
                                        <div class="icon-nowon-news"><span class="lnr lnr-lock"></span></div>
                                    </li>';
                        $count++;
                    }
                }                    
                $html .=        '</ul>
                            </div>';
                break;

            case 'hot-video':
                $html .=    '<div class="video-nowon">
                                <div class="video-on-time">
                                    <h2 class="nowon-title"><span>'.$title.'</span></h2>
                                    <div class="content-video-ontime">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        if($count  == 1){
                            $html .=    '<div class="video-ontime-leading">
                                            <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(510,300)).'</a>
                                        </div>';
                        }
                        else{
                            if($count == 2) $html .= '<ul class="clearfix">';
                            $html .=    '<li>
                                            <div class="video-ontime-more">
                                                <div class="video-ontime-thumb">
                                                    <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(160,100)).'</a>
                                                    <span class="video-time"><span class="lnr lnr-camera-video"></span> '.get_post_meta(get_the_ID(),'time_video',true).'</span>
                                                </div>
                                                <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                            </div>
                                        </li>';
                            if($count > 1 && $count == $count_query) $html .= '</ul>';
                        }
                        $count++;
                    }
                }
                $html .=            '</div>
                                </div>
                            </div>';
                break;

            case 'post-trending':
                $html .=    '<div class="trending-box4">
                                <div class="trending-box-title">
                                    <strong>'.$count_query.'</strong> <span>'.$title.'</span>
                                </div>
                                <div class="list-trending-box">
                                    <div class="wrap-item">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        if($count % 3 == 1) $html .= '<div class="item">';                                            
                        $html .=            '<div class="item-trending-box">
                                                <h3><a href="'.esc_url(get_the_permalink()).'">'.$count.'. '.get_the_title().'</a></h3>
                                                <p>'.substr(get_the_excerpt(),0,60).'</p>
                                                <div class="trending-box-thumb">
                                                    <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(230,130)).'</a>
                                                    <span class="trending-comment">'.get_comments_number().'</span>
                                                </div>
                                            </div>';
                        if($count % 3 == 0 || $count == $count_query) $html .= '</div>';
                        $count++;
                    }
                }
                $html .=            '</div>
                                </div>
                            </div>';
                break;

            case 'post-category':
                if(!empty($cats)){
                    $cates = explode(",",$cats);
                    $cate = $cates[0];
                    $args['tax_query'] = array();
                    if(!empty($post_formats)) {
                        $formats_list = explode(",",$post_formats);            
                        $args['tax_query']['relation'] = 'AND';
                        $args['tax_query'][]=array(
                            'taxonomy'  => 'post_format',
                            'field'     => 'slug',
                            'terms'     => $formats_list
                        );
                    }
                    $args['tax_query']['relation'] = 'AND';
                    $args['tax_query'][]=array(
                        'taxonomy'  => 'category',
                        'field'     => 'slug',
                        'terms'     => $cate
                    );
                    $query = new WP_Query($args);
                    $count = 1;
                    $count_query = $query->post_count;
                    $term = get_term_by( 'slug',$cate, 'category' );
                    $term_link = get_term_link( $term->term_id, 'category' );
                    $html .=    '<div class="list-category-home">
                                    <div class="item-category-home">
                                        <h2 class="title-category-home"><a href="'.esc_url($term_link).'">'.$term->name.'</a></h2>';
                    if($query->have_posts()) {
                        while($query->have_posts()) {
                            $query->the_post();
                            $tags = get_the_tag_list(' ',', ',' ');
                            if($tags) $tags_html = $tags;
                            else $tags_html = esc_html__("No Tags","news");
                            if($count == 1){
                                $html .=    '<div class="post-category-leading clearfix">
                                                <div class="post-category-thum">
                                                    <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(300,170)).'</a>
                                                </div>
                                                <div class="post-category-info">
                                                    <div class="top-post-info-extra">
                                                        <span>'.get_comments_number().'</span> <label>'.esc_html__("tags:","news").'</label> '.$tags_html.'
                                                    </div>
                                                    <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    <ul>
                                                        <li><span class="lnr lnr-clock"></span> '.get_the_time('d M Y').'</li>
                                                        <li>'.esc_html__("By ","news").' <a href="'.get_author_posts_url(get_the_author_meta('ID')).'">'.get_the_author().'</a></li>
                                                    </ul>
                                                    <p>'.substr(get_the_excerpt(),0,90).'</p>
                                                </div>
                                            </div>';
                            }
                            else{
                                if($count == 2){
                                    $html .=    '<div class="post-category-related">
                                                    <ul>'; 
                                }
                                $html .=                '<li>
                                                            <a href="'.esc_url(get_the_permalink()).'">'.get_the_title().get_the_post_thumbnail(get_the_ID(),array(70,51)).'</a>
                                                        </li>';
                                if($count > 1 && $count == $count_query){
                                    $html .=        '</ul>
                                                </div>'; 
                                }
                            }
                            $count++;
                        }
                    }
                    $html .=        '</div>
                                </div>';
                }
                break;

            case 'hot-new':
                $html .=    '<div class="hot-topic-slider">
                                <div class="content-topic-slider">
                                    <div class="wrap-item">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $html .=        '<div class="item">
                                            <div class="item-hot-topic">
                                                <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(570,380)).'</a>
                                                <h2>'.get_the_title().'</h2>
                                            </div>
                                        </div>';
                    }
                }
                $html .=            '</div>
                                </div>
                            </div>';
                break;

            case 'feature-footer':
                $html .=    '<div class="featured-newday">
                                <h2 class="title-featured-newday"><span>'.$title.'</span></h2>
                                <div class="featured-newday-slider">
                                    <div class="wrap-item">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $cates = get_the_category_list(', ');
                        if($cates) $cate_html = $cates;
                        else $cate_html = esc_html__("No Category","news");
                        $html .=        '<div class="item">
                                            <div class="item-featured-newday">
                                                <div class="featured-newday-thumb">
                                                    <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(370,240)).'</a>
                                                </div>
                                                <div class="featured-newday-info">
                                                    <h3><span>'.get_comments_number().'</span><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                </div>
                                                <ul class="featurred-cat-newday">
                                                    <li>'.esc_html__("in:","news").' '.$cate_html.'</li>
                                                    <li>'.esc_html__("Post by:","news").' <a href="'.get_author_posts_url(get_the_author_meta('ID')).'">'.get_the_author().'</a></li>
                                                </ul>
                                            </div>
                                        </div>';
                    }
                }
                $html .=            '</div>
                                </div>
                            </div>';
                break;

            case 'list-footer':
                $html .=    '<div class="most-discussed">
                                <h2>'.$title.'</h2>
                                <ul>';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $html .=    '<li class="clearfix">
                                        <a href="'.esc_url(get_the_permalink()).'" class="dis-thum">'.get_the_post_thumbnail(get_the_ID(),array(90,60)).'</a>
                                        <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                        <span class="dis-date"><span class="lnr lnr-clock"></span> '.get_the_time('d M Y').'</span>
                                    </li>';  
                    }
                }
                $html .=        '</ul>
                            </div>';
                break;            
            
            default:                
                $html .=    '<div class="top-post-home">
                                <div class="row">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $html .=    '<li><span>'.$count.'</span><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></li>';
                        $count++;
                    }
                }                  
                $html .=        '</ul>
                            </div>';
                break;
        }
        wp_reset_postdata();
        return $html;
    }
}

stp_reg_shortcode('sv_post_list5','sv_vc_post_list5');

vc_map( array(
    "name"      => esc_html__("SV Post List Home 4", 'news'),
    "base"      => "sv_post_list5",
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
                esc_html__("List footer","news")        => 'list-footer',
                esc_html__("Feature footer","news")     => 'feature-footer',
                esc_html__("Hot New","news")            => 'hot-new',
                esc_html__("Post Category","news")      => 'post-category',
                esc_html__("Post Trending","news")      => 'post-trending',
                esc_html__("Hot Video","news")          => 'hot-video',
                esc_html__("Post Lock","news")          => 'post-lock',
                esc_html__("Slider Categories","news")  => 'slider-cat',
                esc_html__("Mega vertical slider","news")  => 'mega-vertical-slider',
                esc_html__("Mega more new","news")  => 'mega-more-new',
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
            "type" => "textfield",
            "heading" => esc_html__("Description",'news'),
            "param_name" => "des",
            'dependency'  =>  array(
                'element'   => 'style',
                'value'     => 'hot-new'
                ),
        ),
        array(
            "type" => "attach_image",
            "heading" => esc_html__("Image",'news'),
            "param_name" => "image",
            'dependency'  =>  array(
                'element'   => 'style',
                'value'     => 'list-post-image'
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


