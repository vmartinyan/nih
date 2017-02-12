<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_megamenu_post_tab'))
{
    function sv_vc_megamenu_post_tab($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'title'         => '',
            'tabs'          => '',
            'number'        => '10',
            'order'         => 'DESC',
            'order_by'      => '',
        ),$attr));
        $args=array(
            'post_type'         => 'post',
            'posts_per_page'    => $number,
            'orderby'           => $order_by,
            'order'             => $order,
        );
        if(!empty($tabs)){
            $tabs = explode(',', $tabs);
            $tab_html = $content_html = $title_tab = '';
            foreach ($tabs as $key => $tab) {
                if($key == 0) $f_class = 'active';
                else $f_class = '';
                if($tab == 'latest'){
                    $title_tab = esc_html__("Latest News","news");
                }
                if($tab == 'trending'){
                    $title_tab = esc_html__("Trending","news");
                    $args['meta_query'] = array();
                    $args['meta_query'][] = array(
                        'key'     => 'trending_post',
                        'value'   => 'on',
                        'compare' => '=',
                    );
                }
                if($tab == 'featured'){
                    $title_tab = esc_html__("Featured","news");
                    $args['meta_query'] = array();
                    $args['meta_query'][] = array(
                            'key'     => 'featured_post',
                            'value'   => 'on',
                            'compare' => '=',
                        );
                }
                if($tab == 'popular'){
                    $title_tab = esc_html__("Most Popular","news");
                    $args['orderby'] = 'meta_value_num';
                    $args['meta_key'] = 'post_views';
                }
                if($tab == 'review'){
                    $title_tab = esc_html__("Most Review","news");
                    unset($args['meta_query']);
                    unset($args['meta_key']);
                    $args['orderby'] = 'comment_count';
                }
                $tab_html .=    '<li role="presentation" class="'.$f_class.'"><a href="#'.$tab.'" aria-controls="'.$tab.'" role="tab" data-toggle="tab">'.$title_tab.'</a></li>';
                $query = new WP_Query($args);
                $content_html .=    '<div role="tabpanel" class="tab-pane '.$f_class.'" id="'.$tab.'">
                                        <div class="home-direct-nav">
                                            <div class="wrap-item">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $content_html .=    '<div class="item">
                                                <div class="item-event-post">
                                                    <div class="post-timer">
                                                        <span class="lnr lnr-clock"></span> <span class="date-time">'.get_the_time('F d, Y').'</span> 
                                                    </div>
                                                    <div class="post-thumb">
                                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(277,166)).'</a>
                                                    </div>
                                                    <div class="post-info">
                                                        <h3 class="post-title"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                        <p class="desc">'.get_the_excerpt().'</p>
                                                    </div>
                                                </div>
                                            </div>';
                    }
                }
                $content_html .=            '</div>
                                        </div>
                                    </div>';
            }
        }
        $html .=    '<div class="event-slider box-post-slider">
                        <h2 class="title home-title">'.$title.'</h2>
                        <div class="current-event">
                            <div class="event-tab-list">
                                <ul class="nav nav-tabs" role="tablist">
                                    '.$tab_html.'
                                </ul>
                            </div>
                            <div class="event-tab-content">
                                <div class="tab-content mega-post-slider">
                                    '.$content_html.'
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>';
        wp_reset_postdata();
        return $html;
    }
}

stp_reg_shortcode('sv_megamenu_post_tab','sv_vc_megamenu_post_tab');

vc_map( array(
    "name"      => esc_html__("SV Mega Menu post Tab", 'news'),
    "base"      => "sv_megamenu_post_tab",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "textfield",
            "heading" => esc_html__("Title",'news'),
            "param_name" => "title",
        ),
        array(
            "type" => "checkbox",
            "heading" => esc_html__("Tabs",'news'),
            "param_name" => "tabs",
            "value"     => array(
                esc_html__("Latest News",'news') => 'latest',
                esc_html__("Trending",'news') => 'trending',
                esc_html__("Featured",'news') => 'featured',
                esc_html__("Most Popular",'news') => 'popular',
                esc_html__("Most Review",'news') => 'review',
                )
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