<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 21/01/16
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_event'))
{
    function sv_vc_event($attr)
    {
        $html = $tab_title_html = '';
        extract(shortcode_atts(array(
            'style'      => '',
            'title'      => '',
            'tab_title'  => '',
            'time'      => '',
            'cats'      => '',
            'number'    => '10',
            'order'     => 'DESC',
            'order_by'  => '',
        ),$attr));
        $args = array(
            'post_type'         => 'event',
            'posts_per_page'    => $number,
            'orderby'          => $order_by,
            'order'             => $order,
        );
        if($order_by == 'post_views'){
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'post_views';
        }
        if($order_by == 'event_date'){
            $args['orderby'] = 'meta_value';
            $args['meta_key'] = 'event_date';
        }
        if($order_by == '_post_like_count'){
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = '_post_like_count';
        }
        $tabs_list = explode(',', $cats);
        switch ($style) {
            case 'event-slider-home4':
                $html .=    '<div class="motion-event">
                                <div class="title-motion-event">'.$title.'</div>
                                <div class="wrap-item">';
                $event_query = new WP_Query($args);
                if($event_query->have_posts()) {
                    while($event_query->have_posts()) {
                        $event_query->the_post();
                        $event_date = get_post_meta(get_the_ID(),'event_date',true);
                        $event_time = get_post_meta(get_the_ID(),'event_time',true);
                        $event_link = get_post_meta(get_the_ID(),'event_site',true);
                        $event_location = get_post_meta(get_the_ID(),'event_location',true);
                        $thumb_html = '';
                        if(has_post_thumbnail(get_the_ID())) $thumb_html = get_the_post_thumbnail(get_the_ID(),array(1170,600));
                        $html .=    '<div class="item">
                                        <div class="item-motion-event">
                                            <div class="motion-event-thumb">
                                                <a href="'.esc_url($event_link).'">'.$thumb_html.'</a>
                                            </div>
                                            <div class="motion-event-info">
                                                <h2>'.get_the_title().'</h2>
                                                <ul>
                                                    <li><span class="lnr lnr-calendar-full"></span> '.mysql2date( 'j F Y', $event_date ).'</li>
                                                    <li><span class="lnr lnr-clock"></span> '.$event_time.'</li>
                                                    <li><span class="lnr lnr-apartment"></span> '.$event_location.'</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>';
                    }
                }
                $html .=        '</div>
                            </div>';
                break;

            case 'event-grid':
                $event_query = new WP_Query($args);
                $html .=    '<div class="list-post-event"><div class="row">';
                if($event_query->have_posts()) {
                    while($event_query->have_posts()) {
                        $event_query->the_post();
                        $event_date = get_post_meta(get_the_ID(),'event_date',true);
                        $event_time = get_post_meta(get_the_ID(),'event_time',true);
                        $event_link = get_post_meta(get_the_ID(),'event_site',true);
                        $event_location = get_post_meta(get_the_ID(),'event_location',true);
                        $thumb_html = '';
                        if(has_post_thumbnail(get_the_ID())) $thumb_html = get_the_post_thumbnail(get_the_ID(),array(250,170));
                $html .=    '<div class="col-md-4 col-sm-6 co-xs-12">
                                <div class="item-post-event">
                                    <div class="post-event-thumb">
                                        <a href="'.esc_url(get_the_permalink()).'">'.$thumb_html.'</a>
                                    </div>
                                    <div class="post-event-info">
                                        <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                        <ul>
                                            <li><a href="'.esc_url($event_link).'"><span class="lnr lnr-calendar-full"></span> '.mysql2date( 'j F Y', $event_date ).'</a></li>
                                            <li><a href="'.esc_url($event_link).'"><span class="lnr lnr-clock"></span> '.$event_time.'</a></li>
                                            <li><a href="'.esc_url($event_link).'"><span class="lnr lnr-apartment"></span> '.$event_location.'</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>';        
                    }
                }
                $html .=    '</div></div>';
                break;

            case 'grid-slider':
                if(!empty($cats)) {
                    $args['tax_query'][]=array(
                        'taxonomy'  => 'event_category',
                        'field'     => 'slug',
                        'terms'     => $tabs_list
                    );
                }
                $event_query = new WP_Query($args);
                $count_query = $event_query->post_count;
                $count = 1;
                $html .=    '<div class="event-popular-slider">
                                <div class="sv-slider" data-item="3" data-speed="" data-itemres="" data-animation="" data-nav="home-direct-nav" data-auto_height="yes">';
                if($event_query->have_posts()) {
                    while($event_query->have_posts()) {
                        $event_query->the_post();
                        $size = array(370,200);
                        if($count % 3 == 0) $size = array(370,540);
                        $thumb_html = '';
                        if(has_post_thumbnail(get_the_ID())) $thumb_html = get_the_post_thumbnail(get_the_ID(),$size);
                        if($count % 3 == 1 || $count % 3 == 0){
                        $html .=    '<div class="item">';
                        }
                        $event_date = get_post_meta(get_the_ID(),'event_date',true);
                        $event_time = get_post_meta(get_the_ID(),'event_time',true);
                        $event_link = get_post_meta(get_the_ID(),'event_site',true);
                        $event_location = get_post_meta(get_the_ID(),'event_location',true);
                        $event_free = get_post_meta(get_the_ID(),'event_free',true);
                        if(!empty($event_free)) $free_html = '<label>'.$event_free.' </label>';
                        else $free_html = '';
                        $html .=        '<div class="item-event-popular">
                                            <div class="event-popular-thumb post-thumb">
                                                <a href="'.esc_url(get_the_permalink()).'">'.$thumb_html.'</a>
                                                '.$free_html.'
                                            </div>
                                            <div class="event-popular-info">
                                                <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                <ul>
                                                    <li><a href="'.esc_url($event_link).'"><span class="lnr lnr-calendar-full"></span> '.mysql2date( 'j F Y', $event_date ).'</a></li>
                                                    <li><a href="'.esc_url($event_link).'"><span class="lnr lnr-clock"></span> '.$event_time.'</a></li>
                                                    <li><a href="'.esc_url($event_link).'"><span class="lnr lnr-apartment"></span> '.$event_location.'</a></li>
                                                </ul>
                                            </div>
                                        </div>';
                        if($count % 3 == 2 || $count % 3 == 0 || $count == $count_query){
                        $html .=    '</div>';
                        }
                        $count++;
                    }
                }
                $html .=        '</div>
                            </div>';
                break;

            case 'comming-tab':
                if(!empty($cats)){
                    $pre = rand(0,1000);
                    if(!empty($tabs_list)){
                        $tab_title_html =       '<div class="clearfix"></div><div class="event-tab-title">
                                                    <h3>'.$tab_title.'</h3>
                                                    <ul role="tablist" class="nav nav-tabs">';
                        foreach ($tabs_list as $key => $item_slug) {
                            $f_class = '';
                            if($key == 0) $f_class = 'active';
                            $term = get_term_by( 'slug',$item_slug, 'event_category');
                            if(is_object($term)) $tab_title_html .= '<li role="presentation" class="'.$f_class.'"><a href="#'.$pre.$term->slug.'" data-value="'.$term->slug.'" aria-controls="'.$pre.$term->slug.'" role="tab" data-toggle="tab">'.$term->name.'</a></li>';
                        }
                        $tab_title_html .=          '</ul>
                                                </div>';
                    }

                    $html .=    '<div class="event-upcomming">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-4 col-xs-12">
                                            <h2 class="event-title">'.$title.'</h2>
                                            <div class="event-countdown hotdeal-countdown" data-date="'.$time.'"></div>
                                            '.$tab_title_html.'
                                        </div>
                                        <div class="col-md-9 col-sm-8 col-xs-12">
                                            <div class="tab-content">';
                    foreach ($tabs_list as $key => $item_slug) {
                        $f_class = '';
                        if($key == 0) $f_class = 'active';
                        $term = get_term_by( 'slug',$item_slug, 'event_category');
                        if(is_object($term)){                      
                            $args['tax_query'] = array();
                            $args['tax_query'][]=array(
                                                    'taxonomy'=>'event_category',
                                                    'field'=>'slug',
                                                    'terms'=> $item_slug
                                                );
                            $event_query = new WP_Query($args);
                            $count_query = $event_query->post_count;
                            $html .=             '<div role="tabpanel" class="tab-pane '.$f_class.'" id="'.$pre.$term->slug.'">';
                            $html .=                '<div class="row">
                                                        <div class="col-md-5 col-sm-6 col-xs-12">
                                                            <div class="event-list-post">
                                                                <h3>'.$term->description.'</h3>
                                                                    <ul class="list-post-timing">';
                                                if($event_query->have_posts()) {
                                                    while($event_query->have_posts()) {
                                                        $event_query->the_post();
                                                        $event_time = get_post_meta(get_the_ID(),'event_time',true);
                                                        $event_link = get_post_meta(get_the_ID(),'event_site',true);
                                                        $html .=        '<li>
                                                                            <h3><a href="'.esc_url($event_link).'"><span class="lnr lnr-clock"></span> '.get_the_title().'</a></h3>
                                                                            <span class="date-time">'.$event_time.'</span>
                                                                        </li>';
                                                    }
                                                }
                            $html .=                                '</ul>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7 col-sm-6 col-xs-12">
                                                                <div class="event-upcomming-slider">
                                                                    <div class="wrap-item">';
                            $gallerys = get_term_meta($term->term_id, 'cat-gallery', true);
                            $ga_array = json_decode($gallerys,true);
                            if(!empty($ga_array)){
                                foreach ($ga_array as $img) {
                                    if(!empty($img)) $html .=           '<div class="item">
                                                                            <a href="#" class="event-upcomming-link">
                                                                                <img src="'.$img.'" alt="">
                                                                            </a>
                                                                        </div>';
                                }
                            }                        
                            $html .=                                '</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';
                        }
                    }
                    $html .=                '</div>
                                        </div>
                                    </div>
                                </div>';
                }
                break;
            
            default:
                if(!empty($cats)){
                    $pre = rand(0,1000);
                    if(!empty($tabs_list)){
                        $tab_title_html =       '<div class="event-tab-list">
                                                    <ul class="nav nav-tabs" role="tablist">';
                        foreach ($tabs_list as $key => $item_slug) {
                            $f_class = '';
                            if($key == 0) $f_class = 'active';
                            $term = get_term_by( 'slug',$item_slug, 'event_category');
                            if(is_object($term)) $tab_title_html .= '<li role="presentation" class="'.$f_class.'"><a href="#'.$pre.$term->slug.'" data-value="'.$term->slug.'" aria-controls="'.$pre.$term->slug.'" role="tab" data-toggle="tab">'.$term->name.'</a></li>';
                        }
                        $tab_title_html .=          '</ul>
                                                </div>';
                    }
                    $html .=    '<div class="current-event event-slider">';
                    $html .=        $tab_title_html;
                    $html .=        '<div class="event-tab-content">
                                        <div class="tab-content">';
                    foreach ($tabs_list as $key => $item_slug) {
                        $f_class = '';
                        if($key == 0) $f_class = 'active';
                        $term = get_term_by( 'slug',$item_slug, 'event_category');
                        if(is_object($term)){
                            $args['tax_query'] = array();
                            $args['tax_query'][]=array(
                                                    'taxonomy'=>'event_category',
                                                    'field'=>'slug',
                                                    'terms'=> $item_slug
                                                );
                            $event_query = new WP_Query($args);
                            $count_query = $event_query->post_count;
                            $html .=    '<div role="tabpanel" class="tab-pane '.$f_class.'" id="'.$pre.$term->slug.'">
                                            <div class="home-direct-nav">
                                                <div class="sv-slider" data-item="3" data-speed="" data-itemres="1,1,2,3" data-animation="" data-nav="home-direct-nav">';
                            if($event_query->have_posts()) {
                                while($event_query->have_posts()) {
                                    $event_query->the_post();
                                    $event_time = get_post_meta(get_the_ID(),'event_time',true);
                                    $event_link = get_post_meta(get_the_ID(),'event_site',true);
                                    $event_media = get_post_meta(get_the_ID(),'event_media',true);
                                    $event_gallery = get_post_meta(get_the_ID(),'event_gallery',true);
                                    $thumb_html = $gallerys = '';
                                    $array_gallery = explode(',', $event_gallery);
                                    if(is_array($array_gallery) && !empty($array_gallery)){
                                        foreach ($array_gallery as $key => $item) {
                                            $gallerys .= wp_get_attachment_url($item).',';
                                        }
                                    }
                                    if(has_post_thumbnail(get_the_ID())) $thumb_html = get_the_post_thumbnail(get_the_ID(),array(277,166));
                                    $html .=    '<div class="item item-event">
                                                    <div class="item-event-post">                                                        
                                                        <div class="post-thumb">
                                                            <a href="'.esc_url(get_the_permalink()).'">'.$thumb_html.'</a>
                                                        </div>
                                                        <div class="post-info">
                                                            <div class="post-timer">
                                                                <span class="lnr lnr-clock"></span> <span class="date-time">'.$event_time.'</span> 
                                                            </div>
                                                            <h3 class="post-title"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                            <p class="desc">'.get_the_excerpt().'</p>
                                                            <ul class="event-extra-link list-unstyled">';
                                    if(!empty($event_media)) $html .=    '<li><a href="'.esc_url($event_media).'" class="event-video-popup">'.esc_html__("video preview","news").'</a></li>';
                                    if(!empty($event_gallery)) $html .=    '<li><a class="event-photos" href="#" data-gallery="'.$gallerys.'">'.esc_html__("Photos","news").'</a></li>';
                                    if(!empty($event_link)) $html .=    '<li><a href="'.esc_url($event_link).'">'.esc_html__("show site","news").'</a></li>';
                                    $html .=                '</ul>
                                                        </div>
                                                    </div>
                                                </div>';
                                }
                            }
                            $html .=            '</div>
                                            </div>
                                        </div>';
                        }
                    }
                    $html .=            '</div>
                                    </div>';
                    $html .=    '</div>';
                }
                break;
        }        
        wp_reset_postdata();
        return $html;
    }
}

stp_reg_shortcode('sv_event','sv_vc_event');
vc_map( array(
    "name"      => esc_html__("SV Event", 'news'),
    "base"      => "sv_event",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style",'news'),
            "param_name" => "style",
            "value"     => array(
                esc_html__("Tab category","news") => '',
                esc_html__("Grid Slider","news") => 'grid-slider',
                esc_html__("Event comming tab","news") => 'comming-tab',
                esc_html__("Event Grid","news") => 'event-grid',
                esc_html__("Event Slider home 4","news") => 'event-slider-home4',
                )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Title",'news'),
            "param_name" => "title",
            "dependency"    => array(
                "element"   => "style",
                "value"   => array("comming-tab","event-slider-home4"),
                )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Title Tab",'news'),
            "param_name" => "tab_title",
            "dependency"    => array(
                "element"   => "style",
                "value"   => "comming-tab",
                )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Time CountDown",'news'),
            "param_name" => "time",
            'description'   => esc_html__( 'EntertTime for countdown. Format is mm/dd/yyyy. Example: 12/15/2016.', 'news' ),
            "dependency"    => array(
                "element"   => "style",
                "value"   => "comming-tab",
                )
        ),
        array(
            "type" => "checkbox",
            "holder" => "div",
            "heading" => esc_html__("Categories",'news'),
            "param_name" => "cats",
            "value"     => sv_list_taxonomy_event(),
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Number post",'news'),
            "param_name" => "number",
            'description'   => esc_html__( 'Number of post display in this element. Default is 10.', 'news' ),
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
            "value"         => sv_get_order_list(array(
                                    esc_html__("Event on start",'news')   => 'event_date',
                                )),
            'edit_field_class'=>'vc_col-sm-6 vc_column'
        ),
    )
));