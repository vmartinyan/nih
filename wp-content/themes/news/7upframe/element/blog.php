<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 29/02/16
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_blog'))
{
    function sv_vc_blog($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'      => 'fullwidth',
            'image'      => '',
            'link'       => '',
            'link_post'  => '',
            'number'     => '',
            'order'      => '',
            'order_by'   => '',
        ),$attr));
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        $args=array(
            'post_type'         => 'post',
            'posts_per_page'    => $number,
            'orderby'           => $order_by,
            'order'             => $order,
            'paged'             => $paged,
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
        $query = new WP_Query($args);
        $count = 1;
        $count_query = $query->post_count;
        switch ($style) {
            case 'special-list':
                $html .=    '<div class="content-page-blog">
                                <div class="blog-post-count">
                                    <a href="#" class="prev-story"><span class="lnr lnr-chevron-up"></span></a>
                                    <span class="current-story">1</span> <label>of</label> <span class="total-story"> 10 </span>
                                    <a href="#" class="next-story"><span class="lnr lnr-chevron-down"></span></a>
                                </div>
                                <div class="clearfix">
                                    <div class="main-blog">
                                        <div class="blog-special-content">';
                $title_list_html = '';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $view_html = $icon_class = $icon_html = '';
                        $media_url = get_post_meta(get_the_ID(), 'format_media', true);
                        $gallerys = get_post_meta(get_the_id(),'format_gallery',true);
                        $format = get_post_format();
                        if($format == 'video') {
                            $view_html = '<a href="'.esc_url($media_url).'" class="btn-fancybox video-fancybox event-video-popup">'.esc_html__("watch video","news").' <span class="lnr lnr-camera-video"></span></a>';
                            $icon_html = '<span class="lnr lnr-camera-video"></span>';
                        }
                        if($format == 'gallery') {
                            $view_html = '<a data-gallery="'.$gallerys.'" href="#" class="btn-fancybox gallery-fancybox event-photos">'.esc_html__("View Gallery","news").' <span class="lnr lnr-picture"></span></a>';
                            $icon_html = '<span class="lnr lnr-picture"></span>';
                        }
                        if($count == 1) $f_class = 'active';
                        else $f_class = '';
                        $title_list_html .=     '<li class="'.$f_class.'"><a href="'.esc_url(get_the_permalink()).'"><span class="index">'.$count.'</span>'.substr(get_the_title(),0,42).$icon_html.'</a></li>';
                        if($count == 1){
                            $html .=    '<div class="item-post-blog item-blog-leading">
                                            <div class="item-blog-thumb">
                                                <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(800,500)).'</a>
                                                '.$view_html.'
                                                <div class="item-blog-thumb-info">
                                                    <h2>'.get_the_title().'</h2>
                                                    '.sv_special_metabox().'
                                                </div>
                                            </div>
                                            <div class="item-blog-info">
                                                <h2>'.esc_html__("Follow news","news").'</h2>
                                                <ul class="post-blog-follow clearfix">
                                                    <li><a href="#" class="fl-facebook"><i class="fa fa-facebook"></i>'.esc_html__("Facebook","news").'</a></li>
                                                    <li><a href="#" class="fl-twitter"><i class="fa fa-twitter"></i>'.esc_html__("Twitter","news").'</a></li>
                                                    <li><a href="#" class="fl-pinterest"><i class="fa fa-pinterest-p"></i>'.esc_html__("Pinterest","news").'</a></li>
                                                    <li><a href="#" class="fl-instagram"><i class="fa fa-instagram"></i>'.esc_html__("Instagram","news").' </a></li>
                                                </ul>
                                            </div>
                                        </div>';
                        }
                        else{
                            $html .=    '<div class="item-post-blog">
                                            <div class="item-blog-thumb">
                                                <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(800,500)).'</a>
                                                '.$view_html.'
                                                <div class="item-blog-thumb-info">
                                                    <h2>'.get_the_title().'</h2>
                                                </div>
                                            </div>
                                            <div class="item-blog-info">
                                                <div class="post-info-left">
                                                    <h3>'.esc_html__("By:","news").' '.get_the_author().'</h3>
                                                    '.sv_special_metabox().'
                                                </div>
                                                <div class="post-info-right">
                                                    <p class="desc">'.get_the_excerpt().'</p>
                                                    <a href="'.esc_url(get_the_permalink()).'" class="readmore" data-hover="'.esc_html__("Read more","news").'"><span>'.esc_html__("Read more","news").'</span></a>
                                                </div>
                                            </div>
                                        </div>';
                        }
                        $count++;
                    }
                }
                $html .=                '</div>
                                        <div class="btn-load-more-story">
                                            <a href="#" class="loadmore-story" data-orderby="'.$order_by.'" data-order="'.$order.'" data-number="'.$number.'" data-paged="1" data-maxpage="'.$query->max_num_pages.'"><i class="fa fa-rotate-right"></i> '.esc_html__("Load More Stories","news").'</a>
                                            <a href="'.esc_url($link_post).'" class="loadall-story">'.esc_html__("View All Stories","news").' <span class="lnr lnr-chevron-right"></span></a>
                                        </div>';
                $html .=            '</div>
                                    <div class="sidebar-blog">
                                        <div class="inner-sidebar-blog">
                                            <div class="sidebar-list-post">
                                                <ul class="list-post-blog">
                                                    '.$title_list_html.'
                                                </ul>
                                                <div class="explode-link">
                                                    <a href="#" class="explode-more" data-orderby="'.$order_by.'" data-order="'.$order.'" data-number="'.$number.'" data-paged="1" data-maxpage="'.$query->max_num_pages.'">'.esc_html__("Explore More","news").' <span class="lnr lnr-chevron-down"></span></a>
                                                    <a href="'.esc_url($link_post).'" class="explode-all">'.esc_html__("Explore All","news").' <span class="lnr lnr-chevron-right"></span></a>
                                                </div>
                                                
                                            </div>
                                            <div class="sidebar-blog-adv">
                                                <a href="'.esc_url($link).'">
                                                    '.wp_get_attachment_image($image,'full').'
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                break;

            case 'grid-mansory':
                $html .=    '<div id="blog-masonry" class="content-blog-grid">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $rid = rand(1,12);
                        $size = array(270,180);
                        if($rid % 4 == 2) $size = array(270,294);
                        if($rid % 4 == 3) $size = array(270,164);
                        if($rid % 4 == 0) $size = array(270,152);
                        $html .=    '<div class="item-blog-grid">
                                        <div class="item-blog-grid-thumb">
                                            <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),$size).'</a>
                                        </div>
                                        <div class="item-blog-grid-info">
                                            <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                            <ul>
                                                <li><span class="lnr lnr-clock"></span> '.get_the_time('M d Y').'</li>
                                                <li>'.esc_html__("By","news").' '.get_the_author().'</li>
                                            </ul>
                                            <p>'.substr(get_the_excerpt(),0,80).'</p>
                                            <div class="clearfix">
                                                <a href="'.esc_url(get_the_permalink()).'" class="pull-left">'.esc_html__("Read more","news").'</a>
                                                <a href="'.esc_url(get_comments_link(get_the_ID())).'" class="pull-right">'.get_comments_number().' '.esc_html__("Comments","news").'</a>
                                            </div>
                                        </div>
                                    </div>';
                    }
                }
                $html .=    '</div>
                            <div class="grid-loadmore-item">
                                <a class="load-more-blog-masonry" href="#" data-orderby="'.$order_by.'" data-order="'.$order.'" data-number="'.$number.'" data-paged="1" data-maxpage="'.$query->max_num_pages.'"><i class="fa fa-rotate-right"></i> '.esc_html__("load more items","news").'</a>
                            </div>';
                break;
            
            default:
                $html .=    '<div class="content-blog-'.$style.'">';
                ob_start();
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        get_template_part( 'sv_templates/blog-'.$style.'/content',get_post_format() );
                    }
                }
                $html .=    ob_get_clean();
                $big = 999999999;
                $html .=    '<div class="post-paginav2">';
                $html .=        paginate_links( array(
                                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                    'format'       => '&page=%#%',
                                    'current'      => max( 1, $paged ),
                                    'total'        => $query->max_num_pages,
                                    'prev_text'    => '<span class="lnr lnr-chevron-left"></span>',
                                    'next_text'    => '<span class="lnr lnr-chevron-right"></span>',
                                    'type'         => 'plain',
                                    'end_size'     => 2,
                                    'mid_size'     => 1
                                ) );
                $html .=    '</div>
                        </div>';
                break;
        }        
        wp_reset_postdata();
        return $html;
    }
}

stp_reg_shortcode('sv_blog','sv_vc_blog');

vc_map( array(
    "name"      => esc_html__("SV Blog", 'news'),
    "base"      => "sv_blog",
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
                esc_html__("Full Width","news")        => 'fullwidth',
                esc_html__("Grid Mansory","news")        => 'grid-mansory',
                esc_html__("Blog List","news")        => 'list',
                esc_html__("Blog Special","news")        => 'special-list',
                ),
            'description'   => esc_html__( 'Choose style to display.', 'news' ),
        ),
        array(
            "type" => "attach_image",
            "heading" => esc_html__("Image",'news'),
            "param_name" => "image",
            "dependency"    => array(
                "element"   => "style",
                "value"   => "special-list",
                )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Link image",'news'),
            "param_name" => "link",
            "dependency"    => array(
                "element"   => "style",
                "value"   => "special-list",
                )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Link view all post",'news'),
            "param_name" => "link_post",
            "dependency"    => array(
                "element"   => "style",
                "value"   => "special-list",
                )
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
add_action( 'wp_ajax_post_load_more_blog_masonry', 'sv_post_load_more_blog_masonry' );
add_action( 'wp_ajax_nopriv_post_load_more_blog_masonry', 'sv_post_load_more_blog_masonry' );
if(!function_exists('sv_post_load_more_blog_masonry')){
    function sv_post_load_more_blog_masonry() {
        $number     = $_POST['number'];
        $order_by   = $_POST['orderby'];
        $order      = $_POST['order'];
        $paged      = $_POST['paged'];
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
        $query = new WP_Query($args);
        $count = 1;
        $count_query = $query->post_count;
        $html = '';
        if($query->have_posts()) {
            while($query->have_posts()) {
                $query->the_post();                
                $rid = rand(1,12);
                $size = array(270,180);
                if($rid % 4 == 2) $size = array(270,294);
                if($rid % 4 == 3) $size = array(270,164);
                if($rid % 4 == 0) $size = array(270,152);
                $html .=    '<div class="item-blog-grid">
                                <div class="item-blog-grid-thumb">
                                    <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),$size).'</a>
                                </div>
                                <div class="item-blog-grid-info">
                                    <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                    <ul>
                                        <li><span class="lnr lnr-clock"></span> '.get_the_time('M d Y').'</li>
                                        <li>'.esc_html__("By","news").' '.get_the_author().'</li>
                                    </ul>
                                    <p>'.substr(get_the_excerpt(),0,80).'</p>
                                    <div class="clearfix">
                                        <a href="'.esc_url(get_the_permalink()).'" class="pull-left">'.esc_html__("Read more","news").'</a>
                                        <a href="'.esc_url(get_comments_link(get_the_ID())).'" class="pull-right">'.get_comments_number().' '.esc_html__("Comments","news").'</a>
                                    </div>
                                </div>
                            </div>';
            }
        }
        echo balanceTags($html);
        wp_reset_postdata();
    }
}
add_action( 'wp_ajax_post_load_more_blog_special', 'sv_post_load_more_blog_special' );
add_action( 'wp_ajax_nopriv_post_load_more_blog_special', 'sv_post_load_more_blog_special' );
if(!function_exists('sv_post_load_more_blog_special')){
    function sv_post_load_more_blog_special() {
        $number     = $_POST['number'];
        $order_by   = $_POST['orderby'];
        $order      = $_POST['order'];
        $paged      = $_POST['paged'];
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
        $query = new WP_Query($args);
        $count = 1;
        $count_query = $query->post_count;
        $html = '';
        if($query->have_posts()) {
            while($query->have_posts()) {
                $query->the_post();
                $view_html = $icon_class = $icon_html = '';
                $media_url = get_post_meta(get_the_ID(), 'format_media', true);
                $gallerys = get_post_meta(get_the_id(),'format_gallery',true);
                $format = get_post_format();
                if($format == 'video') {
                    $view_html = '<a href="'.esc_url($media_url).'" class="btn-fancybox video-fancybox event-video-popup">watch video <span class="lnr lnr-camera-video"></span></a>';
                    $icon_html = '<span class="lnr lnr-camera-video"></span>';
                }
                if($format == 'gallery') {
                    $view_html = '<a data-gallery="'.$gallerys.'" href="#" class="btn-fancybox gallery-fancybox event-photos">View Gallery <span class="lnr lnr-picture"></span></a>';
                    $icon_html = '<span class="lnr lnr-picture"></span>';
                }
                $html .=    '<div class="item-post-blog">
                                <div class="item-blog-thumb">
                                    <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(800,500)).'</a>
                                    '.$view_html.'
                                    <div class="item-blog-thumb-info">
                                        <h2>'.get_the_title().'</h2>
                                    </div>
                                </div>
                                <div class="item-blog-info">
                                    <div class="post-info-left">
                                        <h3>'.esc_html__("By:","news").' '.get_the_author().'</h3>
                                        '.sv_special_metabox().'
                                    </div>
                                    <div class="post-info-right">
                                        <p class="desc">'.get_the_excerpt().'</p>
                                        <a href="'.esc_url(get_the_permalink()).'" class="readmore" data-hover="'.esc_html__("Read more","news").'"><span>'.esc_html__("Read more","news").'</span></a>
                                    </div>
                                </div>
                            </div>';
            }
        }
        echo balanceTags($html);
        wp_reset_postdata();
    }
}
add_action( 'wp_ajax_post_load_more_blog_title', 'sv_post_load_more_blog_title' );
add_action( 'wp_ajax_nopriv_post_load_more_blog_title', 'sv_post_load_more_blog_title' );
if(!function_exists('sv_post_load_more_blog_title')){
    function sv_post_load_more_blog_title() {
        $number     = $_POST['number'];
        $order_by   = $_POST['orderby'];
        $order      = $_POST['order'];
        $paged      = $_POST['paged'];
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
        $query = new WP_Query($args);
        $count = (int)$paged*(int)$number +1;
        $count_query = $query->post_count;
        $html = '';
        if($query->have_posts()) {
            while($query->have_posts()) {
                $query->the_post();
                $format = get_post_format();
                $icon_html = '';
                if($format == 'video') {
                    $icon_html = '<span class="lnr lnr-camera-video"></span>';
                }
                if($format == 'gallery') {
                    $icon_html = '<span class="lnr lnr-picture"></span>';
                }
                $html .=    '<li class=""><a href="'.esc_url(get_the_permalink()).'"><span class="index">'.$count.'</span>'.substr(get_the_title(),0,42).$icon_html.'</a></li>';
                $count++;
            }
        }
        $html .=    '<input class="post-number-add-'.$paged.'" type="hidden" value="'.$count_query.'">';
        echo balanceTags($html);
        wp_reset_postdata();
    }
}