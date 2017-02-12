<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 21/01/16
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_post_category_tab'))
{
    function sv_vc_post_category_tab($attr)
    {
        $html = $tab_title_html = '';
        extract(shortcode_atts(array(
            'cats'      => '',
            'number'    => '10',
            'order'     => 'DESC',
            'order_by'  => '',
        ),$attr));
        $args = array(
            'post_type'         => 'post',
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
        if(!empty($cats)){
            $pre = rand(0,1000);
            if(!empty($tabs_list)){
                $tab_title_html =       '<div class="event-tab-list">
                                            <ul class="nav nav-tabs" role="tablist">';
                foreach ($tabs_list as $key => $item_slug) {
                    $f_class = '';
                    if($key == 0) $f_class = 'active';
                    $term = get_term_by( 'slug',$item_slug, 'category');
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
                $term = get_term_by( 'slug',$item_slug, 'category');
                if(is_object($term)){
                    $args['tax_query'] = array();
                    $args['tax_query'][]=array(
                                            'taxonomy'=>'category',
                                            'field'=>'slug',
                                            'terms'=> $item_slug
                                        );
                    $event_query = new WP_Query($args);
                    $count_query = $event_query->post_count;
                    $html .=    '<div role="tabpanel" class="tab-pane '.$f_class.'" id="'.$pre.$term->slug.'">
                                    <div class="home-direct-nav">
                                        <div class="sv-slider" data-item="3" data-speed="" data-itemres="" data-animation="" data-nav="home-direct-nav">';
                    if($event_query->have_posts()) {
                        while($event_query->have_posts()) {
                            $event_query->the_post();
                            $event_time = get_the_time('F d, Y');
                            $event_link = get_the_permalink();
                            $event_media = get_post_meta(get_the_ID(),'format_media',true);
                            $event_gallery = get_post_meta(get_the_ID(),'format_gallery',true);
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
                                                <div class="post-timer">
                                                    <span class="lnr lnr-clock"></span> <span class="date-time">'.$event_time.'</span> 
                                                </div>
                                                <div class="post-thumb">
                                                    <a href="'.esc_url(get_the_permalink()).'">'.$thumb_html.'</a>
                                                </div>
                                                <div class="post-info">
                                                    <h3 class="post-title"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    <p class="desc">'.get_the_excerpt().'</p>
                                                    <ul class="event-extra-link list-unstyled">';
                            if(!empty($event_media)) $html .=    '<li><a href="'.esc_url($event_media).'" class="event-video-popup">'.esc_html__("video preview","news").'</a></li>';
                            if(!empty($event_gallery)) $html .=    '<li><a class="event-photos" href="#" data-gallery="'.$gallerys.'">'.esc_html__("Photos","news").'</a></li>';
                            if(!empty($event_link)) $html .=    '<li><a href="'.esc_url($event_link).'">'.esc_html__("show detail","news").'</a></li>';
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
        wp_reset_postdata();
        return $html;
    }
}

stp_reg_shortcode('sv_post_category_tab','sv_vc_post_category_tab');
vc_map( array(
    "name"      => esc_html__("SV Post Category Tab", 'news'),
    "base"      => "sv_post_category_tab",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "checkbox",
            "holder" => "div",
            "heading" => esc_html__("Categories",'news'),
            "param_name" => "cats",
            "value"     => sv_list_taxonomy('category', false),
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
            "value"         => sv_get_order_list(),
            'edit_field_class'=>'vc_col-sm-6 vc_column'
        ),
    )
));