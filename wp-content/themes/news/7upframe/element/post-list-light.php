<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 08/10/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_post_list2'))
{
    function sv_vc_post_list2($attr)
    {
        $html = $icon_html = '';
        extract(shortcode_atts(array(
            'style'         => 'slider-post',
            'icon'          => '',
            'title'         => '',
            'type_post'     => '',
            'cats'          => '',
            'post_formats'  => '',
            'number'        => '10',
            'order'         => 'DESC',
            'order_by'      => '',
            'view_link'     => '',
            'button_link'     => '',
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
            case 'post-load-more':
                $html .=    '<div class="list-latest-post latest-post-loadmore">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $terms = wp_get_post_terms( get_the_id(), 'category');
                        $term_name = $term_link = $term_html = '';
                        if(is_array($terms) && !empty($terms)){
                            $term_name = $terms[0]->name;
                            $term_link = get_term_link( $terms[0]->term_id, 'category' );
                            $term_html = '<a href="'.esc_url($term_link).'" class="post-cat">'.$term_name.'</a>';
                        }
                        if($count % 2 == 0){
                            $html .=    '<div class="item-latest-post">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-ms-12">
                                                    <div class="latest-post-thumb">
                                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(545,300)).'</a>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-ms-12">
                                                    <div class="latest-post-info">
                                                        '.$term_html.'
                                                        <h3 class="post-title6"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                        <p class="desc">'.get_the_excerpt().'</p>
                                                        <div class="social-post-new">
                                                            '.sv_share_box().'
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                        }
                        else{
                            $html .=        '<div class="item-latest-post">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-ms-12">
                                                        <div class="latest-post-info">
                                                            '.$term_html.'
                                                            <h3 class="post-title6"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                            <p class="desc">'.get_the_excerpt().'</p>
                                                            <div class="social-post-new">
                                                                '.sv_share_box().'
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-ms-12">
                                                        <div class="latest-post-thumb">
                                                            <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(545,300)).'</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
                        }
                        $count++;
                    }
                }
                $html .=    '</div>
                            <div class="load-more-box">
                                <span class="lnr lnr-frame-contract"></span>
                                <a href="#" class="btn-load-more" data-orderby="'.$order_by.'" data-order="'.$order.'" data-cats="'.$cats.'" data-number="'.$number.'" data-type_post="'.$type_post.'" data-paged="1" data-maxpage="'.$query->max_num_pages.'">'.esc_html__("Click to load more items","news").'</a>
                            </div>';
                break;

            case 'gallery-style':
                $html .=    '<div class="gallery-slider6">
                                <div class="title-grid-video">
                                    <h2>'.$title.'</h2>';
                if(!empty($view_link)){
                    $html .=    '<a href="'.esc_url($view_link['url']).'" class="see-more"><span data-hover="'.$view_link['title'].'">'.$view_link['title'].'</span></a>';
                }
                $html .=        '</div>
                                <div class="content-gallery-slider clearfix">
                                    <div class="item-gallery-prev"></div>
                                    <div class="main-gallery-slider">
                                        <div class="wrap-item">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $html .=            '<div class="item">
                                                <div class="item-gallery-slider">
                                                    <div class="gallery-slider-thumb">
                                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(400,500)).'</a>
                                                    </div>
                                                    <div class="gallery-slider-info">
                                                        <h2><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h2>
                                                        <p>'.get_the_excerpt().'</p>
                                                        <div class="social-gallery">
                                                            '.sv_share_box().'
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
                    }
                }
                $html .=                '</div>
                                    </div>
                                    <div class="item-gallery-next"></div>
                                </div>
                            </div>';
                break;

            case 'video-style':
                $html .=    '<div class="grid-video">
                                <div class="title-grid-video">
                                    <h2>'.$title.'</h2>';
                if(!empty($view_link)){
                    $html .=    '<a href="'.esc_url($view_link['url']).'" class="see-more"><span data-hover="'.$view_link['title'].'">'.$view_link['title'].'</span></a>';
                }
                $html .=        '</div>
                                <div class="content-grid-video">
                                    <div class="row">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $icon_post_html = '';
                        $format = get_post_format();
                        if($format == 'video') $icon_post_html = '<span class="lnr lnr-camera-video"></span>';
                        if($format == 'image' || $format == 'gallery') $icon_post_html = '<span class="lnr lnr-camera"></span>';
                        if($count % 4 == 1){
                            $html .=    '<div class="col-md-7 col-sm-7 col-xs-12">
                                            <div class="item-video-leading">
                                                <div class="item-video-leading-thumb">
                                                    <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(600,400)).'</a>
                                                </div>
                                                <div class="item-video-leading-info">
                                                    '.$icon_post_html.'
                                                    <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    <p>'.substr(get_the_excerpt(),0,70).' </p>
                                                    <div class="social-video-leading">
                                                        '.sv_share_box().'
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                        }
                        else{
                            if($count % 4 == 2){
                                $html .=    '<div class="col-md-5 col-sm-5 col-xs-12">';
                            }
                            $html .=        '<div class="item-video">
                                                <div class="item-video-thumb">
                                                    <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(190,120)).'</a>
                                                </div>
                                                <div class="item-video-info">
                                                    '.$icon_post_html.'
                                                    <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    <div class="social-video">
                                                        '.sv_share_box().'
                                                    </div>
                                                </div>
                                            </div>';
                            if(($count % 4 == 0 || $count == $count_query) && $count_query > 1){
                                $html .=    '</div>';
                            }
                        }
                        $count++;
                    }
                }
                $html .=            '</div>
                                </div>
                            </div>';
                break;

            case 'post-tab':
                if(!empty($cats)){
                    $pre = rand(0,100);
                    $tabs = explode(',', $cats);
                    $html .=    '<div class="latest-post">
                                    <div class="header-latest-post">
                                        <div class="row">
                                            <div class="col-md-6 colsm-5 col-xs-12">
                                                <h2 class="title-latest-post">'.$title.'</h2>
                                            </div>
                                            <div class="col-md-6 colsm-7 col-xs-12">
                                                <div class="title-tab-latest-post">';
                    $tab_title_html =               '<ul class="nav nav-tabs" role="tablist">';
                    $tab_title_html .=                  '<li role="presentation" class="active"><a href="#all" aria-controls="all" role="tab" data-toggle="tab">'.esc_html__("All","news").'</a></li>';
                    foreach ($tabs as $key => $tab) {
                        $term = get_term_by( 'slug',$tab, 'category' );
                        $tab_title_html .=              '<li role="presentation"><a href="#'.$pre.$term->slug.'" aria-controls="'.$pre.$term->slug.'" role="tab" data-toggle="tab">'.$term->name.'</a></li>';
                    }
                    $tab_title_html .= '</ul>';
                    $html .=                        $tab_title_html;
                    $html .=                    '</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-latest-post">
                                        <div class="tab-content">';
                    $html .=                '<div role="tabpanel" class="tab-pane active" id="all">';
                    $args['tax_query'] = array();
                    $args['tax_query'][]=array(
                                            'taxonomy'=>'category',
                                            'field'=>'slug',
                                            'terms'=> $tabs
                                        );
                    $post_query = new WP_Query($args);
                    $count_query = $post_query->post_count;
                    $count = 1;
                    if($post_query->have_posts()) {
                        while($post_query->have_posts()) {
                            $post_query->the_post();
                            if($count % 2 == 0){
                                $terms = wp_get_post_terms( get_the_id(), 'category');
                                $term_name = $term_link = $term_html = '';
                                if(is_array($terms) && !empty($terms)){
                                    $term_name = $terms[0]->name;
                                    $term_link = get_term_link( $terms[0]->term_id, 'category' );
                                    $term_html = '<a href="'.esc_url($term_link).'" class="post-cat">'.$term_name.'</a>';
                                }
                                $html .=    '<div class="item-latest-post">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-ms-12">
                                                        <div class="latest-post-thumb">
                                                            <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(545,300)).'</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-ms-12">
                                                        <div class="latest-post-info">
                                                            '.$term_html.'
                                                            <h3 class="post-title6"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                            <p class="desc">'.get_the_excerpt().'</p>
                                                            <div class="social-post-new">
                                                                '.sv_share_box().'
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
                            }
                            else{
                                $html .=        '<div class="item-latest-post">
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-6 col-ms-12">
                                                            <div class="latest-post-info">
                                                                <a href="'.esc_url(get_term_link( $term->term_id, 'category' )).'" class="post-cat">'.$term->name.'</a>
                                                                <h3 class="post-title6"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                                <p class="desc">'.get_the_excerpt().'</p>
                                                                <div class="social-post-new">
                                                                    '.sv_share_box().'
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 col-ms-12">
                                                            <div class="latest-post-thumb">
                                                                <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(545,300)).'</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
                            }
                            $count++;
                        }
                    }
                    $html .=                '</div>';
                    foreach ($tabs as $key => $tab) {
                        $term = get_term_by( 'slug',$tab, 'category' );
                        $html .=            '<div role="tabpanel" class="tab-pane" id="'.$pre.$term->slug.'">';
                        $args['tax_query'] = array();
                        $args['tax_query'][]=array(
                                                'taxonomy'=>'category',
                                                'field'=>'slug',
                                                'terms'=> $tab
                                            );
                        $post_query = new WP_Query($args);
                        $count_query = $post_query->post_count;
                        $count = 1;
                        if($post_query->have_posts()) {
                            while($post_query->have_posts()) {
                                $post_query->the_post();
                                if($count % 2 == 0){
                                    $html .=    '<div class="item-latest-post">
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-6 col-ms-12">
                                                            <div class="latest-post-thumb">
                                                                <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(545,300)).'</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 col-ms-12">
                                                            <div class="latest-post-info">
                                                                <a href="'.esc_url(get_term_link( $term->term_id, 'category' )).'" class="post-cat">'.$term->name.'</a>
                                                                <h3 class="post-title6"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                                <p class="desc">'.get_the_excerpt().'</p>
                                                                <div class="social-post-new">
                                                                    '.sv_share_box().'
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
                                }
                                else{
                                    $html .=        '<div class="item-latest-post">
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-6 col-ms-12">
                                                                <div class="latest-post-info">
                                                                    <a href="'.esc_url(get_term_link( $term->term_id, 'category' )).'" class="post-cat">'.$term->name.'</a>
                                                                    <h3 class="post-title6"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                                    <p class="desc">'.get_the_excerpt().'</p>
                                                                    <div class="social-post-new">
                                                                        '.sv_share_box().'
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-ms-12">
                                                                <div class="latest-post-thumb">
                                                                    <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(545,300)).'</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';
                                }
                                $count++;
                            }
                        }
                        $html .=            '</div>';
                    }
                    $html .=            '</div>
                                    </div>
                                </div>';
                }
                break;

            case 'top-post-slider':
                $html .=    '<div class="top-post-slider6">
                                <div class="row">
                                    <div class="col-md-2 col-sm-3 col-xs-12">
                                        <div class="intro-top-post-slider">
                                            <h2>'.esc_html__("Top","news").'</h2>
                                            <h3>'.esc_html__("Post","news").'</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-sm-9 col-xs-12">
                                        <div class="wrap-item">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $html .=            '<div class="item">
                                                <div class="item-top-post-slider">
                                                    <div class="top-post-slider-thumb">
                                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(200,200)).'</a>
                                                    </div>
                                                    <div class="top-post-slider-info">
                                                        <span class="post-index">#'.$count.'</span>
                                                        <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                        <div class="social-top-post-slider">
                                                            '.sv_share_box().'
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
                        $count++;
                    }
                }
                $html .=                '</div>
                                    </div>
                                </div>
                            </div>';
                break;

            case 'trending-slider':                
                $button_link = vc_build_link( $button_link );
                $html .=    '<div class="adv-box-right"><div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="trending-slider6">
                                        <h2>'.$title.'</h2>
                                        <div class="trending-post">
                                            <div class="wrap-item">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $icon_post_html = '';
                        $format = get_post_format();
                        if($format == 'video') $icon_post_html = '<span class="lnr lnr-camera-video"></span>';
                        if($format == 'image' || $format == 'gallery') $icon_post_html = '<span class="lnr lnr-camera"></span>';
                        if($count % 7 == 1){
                            $html .=            '<div class="item"><ul class="list-post-trending">';
                        }
                        $html .=                    '<li>
                                                        <span class="date-time">'.human_time_diff( get_post_time('U'), current_time('timestamp') ) .' '.  esc_html__("ago","news").'</span>
                                                        <a href="'.esc_url(get_the_permalink()).'">'.substr(get_the_title(),0,28).$icon_post_html.'</a>
                                                    </li>';
                        if($count % 7 == 0 || $count == $count_query){
                            $html .=            '</ul></div>';
                        }
                        $count++;
                    }
                }
                $html .=                    '</div>';
                if(!empty($button_link)){
                    $html .=                '<a href="'.esc_url($button_link['url']).'" class="grift-for-men" data-hover="'.$button_link['title'].'"><span>'.$button_link['title'].'</span></a>';
                }
                if(!empty($view_link)){
                    $html .=                '<a href="'.esc_url($view_link['url']).'" class="see-all-news">'.$view_link['title'].'</a>';
                }
                $html .=                '</div>
                                    </div>
                                </div>
                            </div></div>';
                break;

            case 'list-title-icon':
                $html .=    '<div class="post-cat-box">
                                <h2>'.$icon_html.' '.$title.'</h2>
                                <ul>';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $html .=    '<li><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></li>';
                    }
                } 
                $html .=        '</ul>
                            </div>';
                break;

            case 'slider-icon':
                $html .=    '<div class="post-format-slider"><div class="wrap-item">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $terms = wp_get_post_terms( get_the_id(), 'category');
                        $term_name = $term_link = $term_html = '';
                        if(is_array($terms) && !empty($terms)){
                            $term_name = $terms[0]->name;
                            $term_link = get_term_link( $terms[0]->term_id, 'category' );
                            $term_html = '<a href="'.esc_url($term_link).'" class="cat-parent"><span class="lnr lnr-layers"></span> '.$term_name.'</a>';
                        }
                        $html .=    '<div class="item">
                                        <div class="item-post-format">
                                            <div class="post-format-thumb">
                                                <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(370,240)).'</a>
                                                '.$icon_html.'
                                            </div>
                                            <div class="post-format-info">
                                                <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                '.$term_html.'
                                            </div>
                                        </div>
                                    </div>';
                    }
                }
                $html .=    '</div></div>';
                break;

            case 'slider-slick':
                $html .=    '<div class="most-popular-slider"><div class="slider center">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $html .=    '<div class="item-popular-post">
                                        <div class="popular-post-thumb">
                                            <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(470,340)).'</a>
                                        </div>
                                        <div class="popular-post-info">
                                            <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                            <p>'.get_the_excerpt().'</p>
                                            <a href="'.esc_url(get_the_permalink()).'" class="more">'.esc_html__("MORE","news").' <span class="lnr lnr-chevron-right"></span></a>
                                        </div>
                                    </div>';
                    }
                }
                $html .=    '</div></div>';
                break;

            case 'feature':
                $html .=    '<div class="list-featured-post"><div class="row">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $html .=    '<div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="item-featured-post">
                                            <a href="'.esc_url(get_the_permalink()).'" class="featured-post-link">
                                                '.get_the_post_thumbnail(get_the_ID(),array(270,200)).'
                                            </a>
                                            <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                        </div>
                                    </div>';
                    }
                }

                $html .=    '</div></div>';
                break;

            case 'normal-list':
                if(!empty($view_link['url']) && !empty($view_link['title'])){
                    $view_html =    '<a href="'.esc_url($view_link['url']).'" class="more-news">'.$view_link['title'].' <span class="lnr lnr-chevron-right"></span></a>';
                }
                $html .=    '<div class="hot-news"><ul>';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $html .='<li>
                                    <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                    <p>'.substr(get_the_excerpt(),0,70).' </p>
                                </li>';
                        }
                    }

                $html .=    '</ul>
                            '.$view_html.'
                            </div>';
                break;

            case 'trending-list':
                $html .=    '<ul class="list-trending-post">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $html .='<li class="clearfix">
                                    <a href="'.esc_url(get_the_permalink()).'" class="trending-post-thumb">
                                        '.get_the_post_thumbnail(get_the_ID(),array(120,80)).'
                                    </a>
                                    <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                </li>';
                        }
                    }

                $html .=    '</ul>';
                break;                     

            default:                
                $html .=    '<div class="banner-slider3">
                                <div class="wrap-item">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $html .=    '<div class="item">
                                        <div class="item-banner-slider">
                                            <div class="banner-slider-thumb">
                                                <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(570,400)).'</a>
                                            </div>
                                            <div class="banner-slider-info">
                                                <h2><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h2>
                                                <p>'.substr(get_the_excerpt(),0,70).' </p>
                                            </div>
                                        </div>
                                    </div>';
                        $count++;
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

stp_reg_shortcode('sv_post_list2','sv_vc_post_list2');

vc_map( array(
    "name"      => esc_html__("SV Post List Light", 'news'),
    "base"      => "sv_post_list2",
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
                esc_html__("Slider Post","news")        => 'slider-post',
                esc_html__("Trending List","news")      => 'trending-list',
                esc_html__("Normal List","news")        => 'normal-list',
                esc_html__("Feature","news")            => 'feature',
                esc_html__("Slider slick","news")       => 'slider-slick',
                esc_html__("Slider icon","news")        => 'slider-icon',
                esc_html__("List title icon","news")    => 'list-title-icon',
                esc_html__("Trending slider","news")    => 'trending-slider',
                esc_html__("Top Post slider","news")    => 'top-post-slider',
                esc_html__("Post tab","news")           => 'post-tab',
                esc_html__("Post video style","news")   => 'video-style',
                esc_html__("Post gallery style","news") => 'gallery-style',
                esc_html__("Post Load more","news")     => 'post-load-more',
                ),
            'description'   => esc_html__( 'Choose style to display.', 'news' ),
            'edit_field_class'=>'vc_col-sm-12 vc_column'
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Icon",'news'),
            "param_name" => "icon",
            'edit_field_class'=>'vc_col-sm-12 vc_column sv_iconpicker',
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
        array(
            'heading'     => esc_html__( 'Button link', 'news' ),
            'type'        => 'vc_link',
            'param_name'  => 'button_link',
        ),
    )
));
add_action( 'wp_ajax_post_load_more', 'sv_post_load_more' );
add_action( 'wp_ajax_nopriv_post_load_more', 'sv_post_load_more' );
if(!function_exists('sv_post_load_more')){
    function sv_post_load_more() {
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
                    $term_html = '<a href="'.esc_url($term_link).'" class="post-cat">'.$term_name.'</a>';
                }
                if($count % 2 == 0){
                    $html .=    '<div class="item-latest-post">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-ms-12">
                                            <div class="latest-post-thumb">
                                                <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(545,300)).'</a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-ms-12">
                                            <div class="latest-post-info">
                                                '.$term_html.'
                                                <h3 class="post-title6"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                <p class="desc">'.get_the_excerpt().'</p>
                                                <div class="social-post-new">
                                                    '.sv_share_box().'
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                }
                else{
                    $html .=        '<div class="item-latest-post">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-ms-12">
                                                <div class="latest-post-info">
                                                    '.$term_html.'
                                                    <h3 class="post-title6"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    <p class="desc">'.get_the_excerpt().'</p>
                                                    <div class="social-post-new">
                                                        '.sv_share_box().'
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-ms-12">
                                                <div class="latest-post-thumb">
                                                    <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(545,300)).'</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                }
                $count++;
            }
        }
        echo balanceTags($html);
        wp_reset_postdata();
    }
}
