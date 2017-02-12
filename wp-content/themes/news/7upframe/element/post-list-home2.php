<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 08/10/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_post_list4'))
{
    function sv_vc_post_list4($attr)
    {
        $html = $icon_html = '';
        extract(shortcode_atts(array(
            'style'         => 'list-post-image',
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
            case 'gallery-footer':
                $html .=    '<div class="content-foter-gallery">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                    $html .=    '<a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(123,90)).'</a>';
                    }
                }
                $html .=    '</div>';
                break;

            case 'hot-new-footer':
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $html .=    '<div class="footer-hot-new-item">
                                        <div class="footer-hot-new-thumb">
                                            <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(120,80)).'</a>
                                        </div>
                                        <div class="footer-hot-new-info">
                                            <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                            <p>'.substr(get_the_excerpt(),0,60).'</p>
                                        </div>
                                        <ul class="post-date-author">
                                            <li><span class="lnr lnr-clock"></span> '.get_the_time('M d Y').'</li>
                                            <li><a href="'.esc_url(get_author_posts_url(get_the_author_meta('ID'))).'">'.get_the_author().'</a></li>
                                        </ul>
                                    </div>';
                    }
                }
                break;

            case 'post-load-more':
                $html .=    '<div class="content-load-more most-popular-post-slider">
                                <div class="row">
                                </div>
                            </div>
                            <div class="loadmore-items">
                                <a href="#" class="load-more-button" data-orderby="'.$order_by.'" data-order="'.$order.'" data-cats="'.$cats.'" data-number="'.$number.'" data-type_post="'.$type_post.'" data-paged="0" data-maxpage="'.$query->max_num_pages.'">'.esc_html__("Load more items","news").' <i class="fa fa-refresh"></i></a>
                            </div>';
                break;

            case 'grid-slider':
                $html .=    '<div class="most-popular-post-slider">
                                <div class="wrap-item">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $terms = wp_get_post_terms( get_the_id(), 'category');
                        $term_name = $term_link = $term_html = '';
                        if(is_array($terms) && !empty($terms)){
                            $term_name = $terms[0]->name;
                            $term_link = get_term_link( $terms[0]->term_id, 'category' );
                            $term_html = '<a href="'.esc_url($term_link).'" class="post-cat-underline">'.$term_name.'</a>';
                        }
                        if($count % 6 == 4) $clear_class = 'item-break';
                        else $clear_class = '';
                        if($count % 6 == 1) $html .= '<div class="item"><div class="row">';
                        $html .=    '<div class="col-md-4 col-sm-4 col-xs-12 '.$clear_class.'">
                                        <div class="item-post-box item-post-popular-box">
                                            <div class="item-post-thumb">
                                                <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(379,192)).'</a>
                                            </div>
                                            <div class="item-post-info">
                                                '.$term_html.'
                                                <h3 class="title-post2"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                <ul class="post-date-author">
                                                    <li><span class="lnr lnr-clock"></span> '.get_the_time('M d Y').'</li>
                                                    <li><a href="'.esc_url(get_author_posts_url(get_the_author_meta('ID'))).'">'.get_the_author().'</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>';
                        if($count % 6 == 0 || $count == $count_query) $html .= '</div></div>';
                        $count++;
                    }
                }
                $html .=        '</div>
                            </div>';
                break;

            case 'post-mansory':
                wp_enqueue_script('masonry');
                $html .=    '<div class="masonry-post-box">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $terms = wp_get_post_terms( get_the_id(), 'category');
                        $term_name = $term_link = $term_html = '';
                        if(is_array($terms) && !empty($terms)){
                            $term_name = $terms[0]->name;
                            $term_link = get_term_link( $terms[0]->term_id, 'category' );
                            $term_html = '<a href="'.esc_url($term_link).'" class="post-cat-underline">'.$term_name.'</a>';
                        }
                        $ir = rand(1,10);
                        if($ir % 2 == 0) $size = array(379,277);
                        else $size = array(379,214);
                        $html .=    '<div class="item-post-box">
                                        <div class="item-post-thumb">
                                            <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),$size).'</a>
                                        </div>
                                        <div class="item-post-info">
                                            '.$term_html.'
                                            <h3 class="title-post2"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                            <ul class="post-date-author">
                                                <li><span class="lnr lnr-clock"></span> '.get_the_time('M d Y').'</li>
                                                <li><a href="'.esc_url(get_author_posts_url(get_the_author_meta('ID'))).'">'.get_the_author().'</a></li>
                                            </ul>
                                        </div>
                                    </div>';
                    }
                }
                $html .=    '</div>';
                break;

            case 'list-post-slider':
                $html .=    '<div class="analysis-slider">
                                <div class="wrap-item">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $terms = wp_get_post_terms( get_the_id(), 'category');
                        $term_name = $term_link = $term_html = '';
                        if(is_array($terms) && !empty($terms)){
                            $term_name = $terms[0]->name;
                            $term_link = get_term_link( $terms[0]->term_id, 'category' );
                            $term_html = '<a href="'.esc_url($term_link).'" class="post-cat-underline">'.$term_name.'</a>';
                        }
                        $html .=    '<div class="item">
                                        <div class="item-analysis">
                                            <div class="analysis-thumb">
                                                <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(379,370)).'</a>
                                            </div>
                                        </div>
                                        <div class="analysis-info">
                                            '.$term_html.'
                                            <h3 class="title-post2"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                            <ul class="post-date-author">
                                                <li><span class="lnr lnr-clock"></span> '.get_the_time('M d Y').'</li>
                                                <li><a href="'.esc_url(get_author_posts_url(get_the_author_meta('ID'))).'">'.get_the_author().'</a></li>
                                            </ul>
                                        </div>
                                    </div>';
                    }
                }
                $html .=        '</div>
                            </div>';
                break;
            
            default:                
                $html .=    '<div class="content-latest-news-sidebar">
                                <div class="thumb-latest-news">
                                    '.wp_get_attachment_image($image,'full').'
                                </div>
                                <ul>';
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

stp_reg_shortcode('sv_post_list4','sv_vc_post_list4');

vc_map( array(
    "name"      => esc_html__("SV Post List Home 2", 'news'),
    "base"      => "sv_post_list4",
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
                esc_html__("List Post Image","news")        => 'list-post-image',
                esc_html__("Post slider","news")        => 'list-post-slider',
                esc_html__("Post mansory","news")        => 'post-mansory',
                esc_html__("Grid Slider","news")        => 'grid-slider',
                esc_html__("Load more button","news")        => 'post-load-more',
                esc_html__("Hot News Footer","news")        => 'hot-new-footer',
                esc_html__("Gallery Footer","news")        => 'gallery-footer',
                ),
            'description'   => esc_html__( 'Choose style to display.', 'news' ),
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
add_action( 'wp_ajax_post_load_more_button', 'sv_post_load_more_button' );
add_action( 'wp_ajax_nopriv_post_load_more_button', 'sv_post_load_more_button' );
if(!function_exists('sv_post_load_more_button')){
    function sv_post_load_more_button() {
        $number     = $_POST['number'];
        $order_by   = $_POST['orderby'];
        $order      = $_POST['order'];
        $paged      = $_POST['paged'];
        $type_post  = $_POST['type_post'];
        $cats       = $_POST['cats'];
        $args = array(
            'post_type'         => 'post',
            'posts_per_page'    => $number,
            'orderby'           => $order_by,
            'order'             => $order,
            'paged'             => $paged+1,
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
        $html = '';
        if($query->have_posts()) {
            while($query->have_posts()) {
                $query->the_post();
                $terms = wp_get_post_terms( get_the_id(), 'category');
                $term_name = $term_link = $term_html = '';
                if(is_array($terms) && !empty($terms)){
                    $term_name = $terms[0]->name;
                    $term_link = get_term_link( $terms[0]->term_id, 'category' );
                    $term_html = '<a href="'.esc_url($term_link).'" class="post-cat-underline">'.$term_name.'</a>';
                }
                if($count % 3 == 1) $clear_class = 'item-break';
                else $clear_class = '';
                $html .=    '<div class="col-md-4 col-sm-4 col-xs-12 '.$clear_class.'">
                                <div class="item-post-box item-post-popular-box">
                                    <div class="item-post-thumb">
                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(379,192)).'</a>
                                    </div>
                                    <div class="item-post-info">
                                        '.$term_html.'
                                        <h3 class="title-post2"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                        <ul class="post-date-author">
                                            <li><span class="lnr lnr-clock"></span> '.get_the_time('M d Y').'</li>
                                            <li><a href="'.esc_url(get_author_posts_url(get_the_author_meta('ID'))).'">'.get_the_author().'</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>';
                $count++;
            }
        }
        echo balanceTags($html);
        wp_reset_postdata();
    }
}

