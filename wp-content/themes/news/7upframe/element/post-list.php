<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 08/10/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_post_list'))
{
    function sv_vc_post_list($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'         => 'normal',
            'type_post'     => '',
            'cats'          => '',
            'post_tabs'     => '',
            'post_formats'  => '',
            'type_display'  => 'style-1',
            'number'        => '10',
            'show_comment'  => '',
            'row_slider'    => '1',
            'view_text'     => 'view all',
            'view_link'     => '1',
            'order'         => 'DESC',
            'order_by'      => '',
            'item'          => '3',
            'speed'         => '',
        ),$attr));
        $view_link = vc_build_link( $view_link );
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
        $slider_before =    '<div class="home-direct-nav '.esc_attr($style).'">
                                <div class="row">';
        $slider_after =         '</div>
                            </div>';
        if($type_display == 'slider'){
            $slider_before .=   '<div class="sv-slider" data-item="'.$item.'" data-speed="'.$speed.'" data-itemres="" data-animation="" data-nav="home-direct-nav">';            
            $slider_after .=    '</div>';
        }
        if(!empty($view_link['url']) && !empty($view_link['title'])){
            $view_html = '<a href="'.esc_url($view_link['url']).'" class="btn-view-all"><span class="view-all-text" data-hover="view all">'.$view_link['title'].'</span> </a>';
        }
        else $view_html = '';
        switch ($style) {
            case 'tabs-post':
                if(!empty($post_tabs)){
                    $pre = rand(0,100);
                    $tabs = explode(',', $post_tabs);
                    $html .=    '<div class="tab-video-slider">';
                    $ul_tab_html = $bx_slider_html = $ul_bx_slider = '';
                    foreach ($tabs as $key => $tab) {
                        $ul_bx_slider = '';
                        if($key == 0) $set_active = 'active';
                        else $set_active = '';
                        if($tab == 'popular'){
                            $tab_text = esc_html__("most popular","news");                            
                            $args_popular = $args;
                            $args_popular['orderby'] = 'meta_value_num';
                            $args_popular['meta_key'] = 'post_views';
                            $query = new WP_Query($args_popular);
                        }
                        if($tab == 'feature'){
                            $tab_text = esc_html__("feature","news");
                            $args_feature = $args;
                            $args_feature['meta_query']['relation'] = 'OR';
                            $args_feature['meta_query'][] = array(
                                    'key'     => 'featured_post',
                                    'value'   => 'on',
                                    'compare' => '=',
                                );
                            $query = new WP_Query($args_feature);
                        }
                        if($tab == 'latest'){
                            $args_latest = $args;
                            $args_popular['orderby'] = 'ID';
                            $args_popular['order'] = 'DESC';
                            $query = new WP_Query($args_popular);
                                $tab_text = esc_html__("latest","news");
                        }
                        $bx_slider_html .=  '<div class="tab-item '.$set_active.'" id="'.$pre.$tab.'">
                                                <div id="slider-'.$pre.$tab.'"  class="bx-pager">';
                        $ul_bx_slider .=    '<ul class="bxslider" data-id="slider-'.$pre.$tab.'">';
                        $count = 0;
                        if($query->have_posts()) {
                            while($query->have_posts()) {
                                $query->the_post();
                                $terms = wp_get_post_terms( get_the_id(), 'category');
                                $term_name = $term_link = '';
                                if(is_array($terms) && !empty($terms)){
                                    $term_name = $terms[0]->name;
                                    $term_link = get_term_link( $terms[0]->term_id, 'category' );
                                    $icon = get_term_meta( $terms[0]->term_id, 'cat-icon',true );
                                    $icon_html = '';
                                    if(!empty($icon)){
                                        if(strpos($icon,'lnr') !== false) $icon_html = '<span class="lnr '.$icon.'"></span>';
                                        else $icon_html =   '<i class="fa '.$icon.'"></i>';
                                    }
                                    $term_html = $icon_html.' '.$term_name;
                                }
                                $bx_slider_html .=  '<a data-slide-index="'.$count.'" href="'.esc_url(get_the_permalink()).'">
                                                        <div class="video-thumb-content">
                                                            '.get_the_post_thumbnail(get_the_ID(),array(270,150)).'
                                                            <div class="video-thumb-info">
                                                                <div class="post-format">
                                                                    '.$term_html.'
                                                                </div>
                                                                <h3 class="post-title">'.get_the_title().'</h3>
                                                            </div>
                                                        </div>  
                                                    </a>';
                                $ul_bx_slider .=    '<li>
                                                        <div class="video-slider-content">
                                                            <a href="#">'.get_the_post_thumbnail(get_the_ID(),array(900,500)).'</a>
                                                            <div class="video-slider-info">';
                                ob_start();
                                sv_display_metabox();
                                $ul_bx_slider .=            ob_get_clean();                                
                                $ul_bx_slider .=            '<h2 class="title">'.get_the_title().'</h2>
                                                            </div>
                                                        </div>  
                                                    </li>';
                                $count++;
                            }
                        }
                        $ul_bx_slider .=    '</ul>';
                        $bx_slider_html .=      '</div>
                                                '.$ul_bx_slider.'
                                            </div>';
                        $ul_tab_html .= '<li class="'.$set_active.'"><a href="#'.$pre.$tab.'" data-id="'.$pre.$tab.'">'.$tab_text.' </a></li>';
                    }
                    $html .=        '<ul class="title-tab-video">';
                    $html .=            $ul_tab_html;
                    $html .=        '</ul>';
                    $html .=        '<div class="tab-content-slider">';
                    $html .=            $bx_slider_html;
                    $html .=        '</div>';
                    $html .=    '</div>';
                }
                break;

            case 'special-slider':
                $html .=    '<div class="gallery-slider">';
                $html .=        '<div class="slider center">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $html .=    sv_post_loop_content('gallery-slider');
                    }
                }
                $html .=        '</div>';
                $html .=    '</div>';
                $html .= $view_html;
                break;

            case 'trending':
                $col = (int)$item;
                $max_col = 12;
                $col_item = $max_col / $col;
                $html .= $slider_before;
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        if($count % 6 == 1 || $count % 6 == 4){
                            if($type_display == 'slider') $html .=    '<div class="item">';
                            else $html .=    '<div class="col-md-'.$col_item.' col-sm-4 col-xs-12"><div class="row">';
                            

                        }
                        if($count % 6 == 1 || $count % 6 == 0){
                            $html .=            '<div class="col-md-12 col-sm-12 col-xs-12">';
                            $html .=                sv_post_loop_content('trending-big',$item);
                            $html .=            '</div>';
                        }
                        if($count % 6 == 2 || $count % 6 == 3 || $count % 6 == 5 || $count % 6 == 4){
                            $html .=            '<div class="col-md-6 col-sm-6 col-xs-12">';
                            $html .=                sv_post_loop_content('trending-small',$item);
                            $html .=            '</div>';
                        }
                        if($count % 6 == 3 || $count % 6 == 0 || $count == $count_query){
                            if($type_display == 'slider') $html .=    '</div>';
                            else $html .=    '</div></div>';
                        }
                        $count++;
                    }
                }
                $html .= $slider_after;
                $html .= $view_html;
                break;            

            default:                
                $html .= $slider_before;
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        if($row_slider == '2' && $count % 2 == 1 && $type_display == 'slider') $html .= '<div class="item">';
                        $html .= sv_post_loop_content($style,$item,$type_display,$show_comment);
                        if($row_slider == '2' && ($count % 2 == 0 || $count_query == $count) && $type_display == 'slider') $html .= '</div>';
                        $count++;
                    }
                }
                $html .= $slider_after;
                $html .= $view_html;
                break;
        }
        wp_reset_postdata();
        return $html;
    }
}

stp_reg_shortcode('sv_post_list','sv_vc_post_list');

vc_map( array(
    "name"      => esc_html__("SV Post List", 'news'),
    "base"      => "sv_post_list",
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
                esc_html__("Normal","news")    => 'normal',
                esc_html__("Feature Video","news")    => 'feature',
                esc_html__("Trending","news")    => 'trending',
                esc_html__("Special slider","news")    => 'special-slider',
                esc_html__("Video Post","news")    => 'tabs-post',
                ),
            'description'   => esc_html__( 'Choose style to display.', 'news' ),
            'edit_field_class'=>'vc_col-sm-6 vc_column'
        ),
        array(
            "type" => "checkbox",
            "heading" => esc_html__("Video post tabs",'news'),
            "param_name" => "post_tabs",
            'description'   => esc_html__( 'Choose Tabs to display.', 'news' ),
            "value"         => array(
                esc_html__("Popular","news") => 'popular',
                esc_html__("Feature","news") => 'feature',
                esc_html__("Latest","news") => 'latest',
                ),
            'dependency'  =>  array(
                'element'   => 'style',
                'value'     => 'tabs-post'
                ),
        ),
        array(
            "type"          => "dropdown",
            "heading"       => esc_html__("Type Display",'news'),
            "param_name"    => "type_display",
            "value"         => array(
                esc_html__("Normal","news") => 'normal',
                esc_html__("Slider","news") => 'slider',
                ),
            'description'   => esc_html__( 'Choose type to display.', 'news' ),
            'dependency'  =>  array(
                'element'   => 'style',
                'value'     => array('normal','feature','trending')
                ),
            'edit_field_class'=>'vc_col-sm-6 vc_column'
        ),
        array(
            "type"          => "dropdown",
            "heading"       => esc_html__("Show Comment",'news'),
            "param_name"    => "show_comment",
            "value"         => array(
                esc_html__("No","news")   => '',
                esc_html__("Yes","news")    => 'yes',
                ),
            'dependency'  =>  array(
                'element'   => 'style',
                'value'     => 'normal'
                ),
            'edit_field_class'=>'vc_col-sm-6 vc_column'
        ),
        array(
            "type"          => "dropdown",
            "heading"       => esc_html__("Row item",'news'),
            "param_name"    => "row_slider",
            "value"         => array(
                esc_html__("Default","news")   => '1',
                esc_html__("Two row","news")   => '2',
                ),
            'dependency'  =>  array(
                'element'   => 'type_display',
                'value'     => 'slider'
                ),
            'edit_field_class'=>'vc_col-sm-6 vc_column'
        ),
        array(
            'heading'     => esc_html__( 'Item slider/ column display', 'news' ),
            'type'        => 'textfield',
            'description' => esc_html__( 'Enter number of item. Default is 3.', 'news' ),
            'param_name'  => 'item',
        ),
        array(
            'heading'     => esc_html__( 'Speed', 'news' ),
            'type'        => 'textfield',
            'description' => esc_html__( 'Enter time slider go to next item. Unit (ms). Example 5000. If empty this field autoPlay is false.', 'news' ),
            'param_name'  => 'speed',
            'dependency'  =>  array(
                'element'   => 'type_display',
                'value'     => 'slider'
                )
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
            'heading'     => esc_html__( 'View label', 'news' ),
            'type'        => 'textfield',
            'param_name'  => 'view_text',
        ),
        array(
            'heading'     => esc_html__( 'View link', 'news' ),
            'type'        => 'vc_link',
            'param_name'  => 'view_link',
        ),
    )
));
// get post loop html
if(!function_exists('sv_post_loop_content'))
{
    function sv_post_loop_content($style = 'style-1', $col = '3',$type_display = 'normal',$show_comment = '')
    {
        $html = ''; $col = (int)$col;
        $max_col = 12;
        $col_item = $max_col / $col;        
        $comment_number = get_comments_number();
        if($comment_number > 1) $comment_text = esc_html__("Comments","news");
        else $comment_text = esc_html__("Comment","news");
        if($show_comment == 'yes') $comment_html = '<p class="comment-count"><span class="lnr lnr-bubble"></span> '.$comment_number.' '.$comment_text.'</p>';
        else $comment_html = '';
        $terms = wp_get_post_terms( get_the_id(), 'category');
        $term_name = $term_link = '';
        if(is_array($terms) && !empty($terms)){
            $term_name = $terms[0]->name;
            $term_link = get_term_link( $terms[0]->term_id, 'category' );
            $icon = get_term_meta( $terms[0]->term_id, 'cat-icon',true );
            $icon_html = '';
            if(!empty($icon)){
                if(strpos($icon,'lnr') !== false) $icon_html = '<span class="lnr '.$icon.'"></span>';
                else $icon_html =   '<i class="fa '.$icon.'"></i>';
            }
            $term_html = '<a href="'.esc_url($term_link).'">'.$icon_html.' '.$term_name.'</a>';
        }
        else $term_html = '';
        switch ($style) {
            case 'tabs-post':
                $html.=     '';
                break;

            case 'gallery-slider':
                $html .=    '<div class="item-gallery-post">
                                <div class="post-thumb">
                                    <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(700,525)).'</a>
                                </div>
                                <div class="post-info">
                                    <div class="post-format">
                                        '.$term_html.'
                                    </div>
                                    <h3 class="post-title"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                    <p class="desc">'.get_the_excerpt().'</p>
                                </div>
                            </div>';
                break;
            case 'feature':
            $size = array(360,216);
            if($col >= 4) $size = array(266,216);
            if($col < 3) $size = array(360*1.5,216*1.5);
            if($type_display == 'slider') $el_wrap = 'col-md-12 col-sm-12 col-xs-12';
            else $el_wrap = 'col-md-'.$col_item.' col-sm-4 col-xs-12';
            $html .=    '<div class="'.$el_wrap.'">
                            <div class="item-video-post post-item">
                                <div class="post-format">
                                    '.$term_html.'
                                </div>
                                <h3 class="post-title"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                <div class="post-thumb">
                                    <a href="'.esc_url(get_the_permalink()).'">
                                        '.get_the_post_thumbnail(get_the_ID(),$size).'
                                    </a>
                                </div>
                                <div class="post-info">
                                    <p class="desc">'.get_the_excerpt().'</p>
                                    <div class="info-post-extra">
                                        <p class="post-author">'.esc_html__("post by:","news").' <a href="'.get_author_posts_url(get_the_author_meta('ID')).'">'.get_the_author().'</a></p>
                                        <ul class="comment-view-total list-inline">
                                            <li class="post-view-count"><a href="'.esc_url(get_the_permalink()).'"><span class="lnr lnr-eye"></span> '.sv_get_post_view().' '.esc_html__("View","news").'</a></li>
                                            <li class="post-comment-count"><a href="'.get_comments_link().'"><span class="lnr lnr-bubble"></span> '.$comment_number.' '.$comment_text.'</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>';
            break;

            case 'trending-big':
                $size = array(547,340);
                if($col == 1) $size = array(547*2,340*2);
                $html .=    '<div class="item-trending-post post-item">
                                <div class="post-thumb">
                                    <a href="'.esc_url(get_the_permalink()).'">
                                        '.get_the_post_thumbnail(get_the_ID(),$size).'
                                    </a>
                                </div>
                                <div class="post-info">
                                    <div class="post-format">
                                        '.$term_html.'
                                    </div>
                                    <h3 class="post-title">
                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a>
                                    </h3>
                                </div>
                            </div>';
                break;

            case 'trending-small':
                $size = array(266,165);
                if($col == 1) $size = array(266*2,165*2);
                $html .=    '<div class="item-trending-post post-item">
                                <div class="post-thumb">
                                    <a href="'.esc_url(get_the_permalink()).'">
                                        '.get_the_post_thumbnail(get_the_ID(),$size).'
                                    </a>
                                </div>
                                <div class="post-info">
                                    <div class="post-format">
                                        '.$term_html.'
                                    </div>
                                    <h3 class="post-title">
                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a>
                                    </h3>
                                </div>
                            </div>';
                break;
            
            default:
                $size = array(360,216);
                if($col >= 4) $size = array(266,216);
                if($col < 3) $size = array(360*1.5,216*1.5);
                if($type_display == 'slider') $el_wrap = 'item-slider';
                else $el_wrap = 'col-md-'.$col_item.' col-sm-4 col-xs-12';
                $html .=    '<div class="'.$el_wrap.'">
                                <div class="item-top-post post-item">
                                    <div class="post-thumb">
                                        <a href="'.esc_url(get_the_permalink()).'">
                                            '.get_the_post_thumbnail(get_the_ID(),$size).'
                                            '.$comment_html.'
                                        </a>
                                    </div>
                                    <div class="post-info fix-height">
                                        <!--<div class="post-format">
                                            '.$term_html.'
                                        </div>-->
                                        <h4 class="post-title"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h4>
                                        <p class="desc">'.get_the_excerpt().'</p>
                                        <!--<a class="btn-view-all hide-icon" href="'.esc_url(get_the_permalink()).'"><span class="view-all-text" data-hover="'.esc_attr__("Read More","news").'">'.esc_html__("Read More","news").'</span> </a>-->
                                    </div>
                                </div>
                            </div>';
                break;
        }
        return $html;
    }
}