<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_event_post'))
{
    function sv_vc_event_post($attr)
    {
        $html = $feature_html = '';
        extract(shortcode_atts(array(
            'style'     => '',
            'title'     => '',
            'post'      => '',
            'id_post'   => '',
        ),$attr));
        if(empty($id_post)) $id_post = $post;
        if(!empty($id_post)){
            $query = new WP_Query( array(
                'post_type' => 'event',
                'post__in' => array($id_post)
                ));
            if( $query->have_posts() ):
                while ( $query->have_posts() ) : $query->the_post();
                    $event_media = get_post_meta(get_the_ID(),'event_media',true);
                    $event_date = get_post_meta(get_the_ID(),'event_date',true);
                    $event_time = get_post_meta(get_the_ID(),'event_time',true);
                    $event_link = get_post_meta(get_the_ID(),'event_site',true);
                    $event_location = get_post_meta(get_the_ID(),'event_location',true);
                    if(!empty($event_media)) $feature_html = sv_remove_w3c(wp_oembed_get($event_media),'770','433');
                    else $feature_html = get_the_post_thumbnail(get_the_ID(),'full');
                    switch ($style) {
                        case 'home-5':
                            $html .=    '<div class="latest-new-box  new-events">
                                            <h2 class="neew-events-title">'.$title.'</h2>
                                            <div class="new-events-thumb">
                                                <a href="'.esc_url($event_link).'">'.get_the_post_thumbnail(get_the_ID(),array(433,244)).'</a>
                                            </div>
                                            <div class="new-events-info">
                                                <h3><a href="'.esc_url($event_link).'">'.get_the_title().'</a></h3>
                                                <ul class="post-info5">
                                                    <li>'.esc_html__("By: ","news").'<a href="'.get_author_posts_url(get_the_author_meta('ID')).'">'.get_the_author().'</a></li>
                                                    <li>'.get_the_time('F d, Y').'</li>
                                                </ul>
                                            </div>
                                        </div>';
                            break;

                        case 'home-7':
                            $html .=    '<div class="item-event-current">
                                            <div class="content-event-current">
                                                <div class="item-event-icon">
                                                    <span class="lnr lnr-clock"></span>
                                                </div>
                                                <div class="item-event-info">
                                                    <span class="date-time">'.$event_time.'</span>
                                                    <h3><a href="'.esc_url($event_link).'">'.get_the_title().'</a></h3>
                                                </div>
                                            </div>
                                            <a href="'.esc_url($event_link).'" class="find-ticket">'.esc_html__("find ticket","news").'</a>
                                        </div>';
                            break;
                        
                        default:
                            $html .=    '<div class="content-event-video">
                                            <div class="row">
                                                <div class="col-md-8 col-sm-7 col-xs-12">
                                                    <div class="video-iframe">
                                                        '.$feature_html.'
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-5 col-xs-12">
                                                    <div class="info-event-vimeo">
                                                        <h2><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h2>
                                                        <p class="info-author-event"><span>'.esc_html__("from","news").'</span> '.get_the_author().' <span>'.human_time_diff( get_post_time('U'), current_time('timestamp') ).' '.esc_html__("ago","news").'</span> </p>
                                                        <p class="desc">'.get_the_excerpt().' </p>
                                                        <a href="'.esc_url(get_the_permalink()).'" class="see-more"><span>'.esc_html__("see more","news").'</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                            break;
                    }                    
                endwhile;
            endif;
            wp_reset_postdata();            
        }
        return $html;
    }
}

stp_reg_shortcode('sv_event_post','sv_vc_event_post');

vc_map( array(
    "name"      => esc_html__("SV Event Post", 'news'),
    "base"      => "sv_event_post",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style",'news'),
            "param_name" => "style",
            "value"     => array(
                esc_html__("Default","news") => '',
                esc_html__("Style home 7","news") => 'home-7',
                esc_html__("Style home 5","news") => 'home-5',
                )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Title",'news'),
            "param_name" => "title",
            "dependency"    => array(
                "element"   => 'style',
                "value"   => 'home-5',
                )
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Post",'news'),
            "param_name" => "post",
            "value"     => sv_get_list_event_post(),
            'description' => esc_html__( 'Select post to show.', 'news' ),
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Post ID",'news'),
            "param_name" => "id_post",
            'description' => esc_html__( 'Enter post ID to show. Default is select post value.', 'news' ),
        ),
    )
));