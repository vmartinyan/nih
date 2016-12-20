<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_mega_category_tab'))
{
    function sv_vc_mega_category_tab($attr)
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
                $term = get_term_by( 'slug',$tab, 'category' );
                $tab_html .=    '<li role="presentation" class="'.$f_class.'"><a href="#'.$tab.'" aria-controls="'.$tab.'" role="tab" data-toggle="tab">'.$term->name.'</a></li>';
                $args['tax_query'] = array();
                $args['tax_query'][] = array(
                                        'taxonomy'=>'category',
                                        'field'=>'slug',
                                        'terms'=> $tab
                                    );
                $query = new WP_Query($args);
                $content_html .=    '<div role="tabpanel" class="tab-pane '.$f_class.'" id="'.$tab.'">
                                        <div class="mega-tab-content">
                                            <div class="row">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        $cates = get_the_category_list(', ');
                        if($cates) $cate_html = $cates;
                        else $cate_html = esc_html__("No Category","news");
                        $tags = get_the_tag_list(' ',', ',' ');
                        if($tags) $tags_html = $tags;
                        else $tags_html = esc_html__("No Tags","news");
                        $content_html .=    '<div class="col-md-4 col-sm-4 col-xs-12">
                                                <div class="item-mega-post-tab">
                                                    <div class="mega-post-tab-thumb">
                                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(270,180)).'</a>
                                                        <ul>
                                                            <li class="cat-list">'.esc_html__("in:","news").' '.$cate_html.'</li>
                                                            <li>'.esc_html__("Post by:","news").' <a href="'.esc_url(get_author_posts_url(get_the_author_meta('ID'))).'">'.get_the_author().'</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="mega-post-tab-info">
                                                        <div class="top-post-info-extra">
                                                            <span>'.get_comments_number().'</span> <label>'.esc_html__("tags:","news").'</label> '.$tags_html.'
                                                        </div>
                                                        <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
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
        $html .=    '<div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="mega-tab-nav">
                                <h2>'.$title.'</h2>
                                <ul class="nav nav-tabs" role="tablist">
                                    '.$tab_html.'
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="tab-content">
                                '.$content_html.'
                            </div>
                        </div>
                    </div>';
        wp_reset_postdata();
        return $html;
    }
}

stp_reg_shortcode('sv_mega_category_tab','sv_vc_mega_category_tab');

vc_map( array(
    "name"      => esc_html__("SV Mega Menu Category Tabs", 'news'),
    "base"      => "sv_mega_category_tab",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "textfield",
            "heading" => esc_html__("Title",'news'),
            "param_name" => "title",
        ),
        array(
            "type"          => "checkbox",
            "holder"        => "div",
            "heading"       => esc_html__("Categories",'news'),
            "param_name"    => "tabs",
            "value"         => sv_list_taxonomy('category', false),
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