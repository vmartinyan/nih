<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_post_tab4'))
{
    function sv_vc_post_tab4($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
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
        $html .=    '<div class="most-read-popular">
                        <div class="title-most-read-tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#mostread" aria-controls="mostread" role="tab" data-toggle="tab">'.esc_html__("recent","news").'</a></li>
                                <li role="presentation"><a href="#popularread" aria-controls="popularread" role="tab" data-toggle="tab">'.esc_html__("popular","news").'</a></li>
                            </ul>
                        </div>
                        <div class="content-most-read-tab">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="mostread">
                                    <div class="most-read-slider">
                                        <div class="wrap-item">';        
        $query = new WP_Query($args);
        $count = 1;
        $count_query = $query->post_count;
        if($query->have_posts()) {
            while($query->have_posts()) {
                $query->the_post();
                if($count % 4 == 1) $html .=    '<div class="item">';
                $html .=        '<div class="item-most-read clearfix">
                                    <div class="most-read-thumb">
                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(120,80)).'</a>
                                    </div>
                                    <div class="most-read-info">
                                        <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                        <span class="most-read-date"><span class="lnr lnr-clock"></span> '.get_the_time('d M Y').'</span>
                                    </div>
                                </div>';
                if($count % 4 == 0 || $count == $count_query) $html .=    '</div>';
                $count++;
            }
        }
        $html .=                        '</div>
                                    </div>
                                </div>';
        $html .=                '<div role="tabpanel" class="tab-pane" id="popularread">
                                    <div class="most-read-slider">
                                        <div class="wrap-item">';
        $args['orderby'] = 'meta_value_num';
        $args['meta_key'] = 'post_views';
        $query = new WP_Query($args);
        $count = 1;
        $count_query = $query->post_count;
        if($query->have_posts()) {
            while($query->have_posts()) {
                $query->the_post();
                if($count % 4 == 1) $html .=    '<div class="item">';
                $html .=        '<div class="item-most-read clearfix">
                                    <div class="most-read-thumb">
                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(120,80)).'</a>
                                    </div>
                                    <div class="most-read-info">
                                        <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                        <span class="most-read-date"><span class="lnr lnr-clock"></span> '.get_the_time('d M Y').'</span>
                                    </div>
                                </div>';
                if($count % 4 == 0 || $count == $count_query) $html .=    '</div>';
                $count++;
            }
        }
        $html .=                        '</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
        wp_reset_postdata();
        return $html;
    }
}

stp_reg_shortcode('sv_post_tab4','sv_vc_post_tab4');

vc_map( array(
    "name"      => esc_html__("SV Post Tab Home 4", 'news'),
    "base"      => "sv_post_tab4",
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