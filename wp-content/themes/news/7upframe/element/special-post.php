<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 23/12/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_post_special'))
{
    function sv_vc_post_special($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'      => '',
            'post'      => '',
            'id_post'   => '',
        ),$attr));
        if(empty($id_post)) $id_post = $post;
        if(!empty($id_post)){
            $query = new WP_Query( array(
                'post_type' => 'post',
                'post__in' => array($id_post)
                ));
            if( $query->have_posts() ):
                while ( $query->have_posts() ) : $query->the_post();
                    $terms = wp_get_post_terms( get_the_id(), 'category');
                    $term_name = $term_link = $term_html = '';
                    if(is_array($terms) && !empty($terms)){
                        $term_name = $terms[0]->name;
                        $term_link = get_term_link( $terms[0]->term_id, 'category' );
                        $term_html = '<a href="'.esc_url($term_link).'" class="post-cat-underline">'.$term_name.'</a>';
                    }
                    $cates = get_the_category_list(', ');
                    if($cates) $cate_html = $cates;
                    else $cate_html = esc_html__("No Category","news");
                    $tags = get_the_tag_list(' ',', ',' ');
                    if($tags) $tags_html = $tags;
                    else $tags_html = esc_html__("No Tags","news");
                    switch ($style) {
                        case 'mega-post':
                            $html .=    '<div class="simple-post-mega">
                                            <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(370,208)).'</a>
                                            <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                            <p>'.substr(get_the_excerpt(),0,100).' </p>
                                        </div>';
                            break;

                        case 'home5-style-big':
                            $html .=    '<div class="item-full-top">
                                            <div class="full-top-thumb">
                                                <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(658,600)).'</a>
                                            </div>
                                            <div class="full-top-info">
                                                <ul class="post-info5">
                                                    <li><span class="lnr lnr-clock"></span> '.get_the_time('d M Y').'</li>
                                                    <li><span class="lnr lnr-bubble"></span> '.get_comments_number().'</li>
                                                </ul>
                                                <h2><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h2>
                                                <p>'.substr(get_the_excerpt(),0,60).'</p>
                                                <a href="'.esc_url(get_the_permalink()).'" class="readmore">'.esc_html__("read more","news").'<span class="lnr lnr-chevron-right"></span></a>
                                            </div>
                                        </div>';
                            break;

                        case 'home5-style-small':
                            $html .=    '<div class="item-full-top">
                                            <div class="full-top-thumb">
                                                <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(658,298)).'</a>
                                            </div>
                                            <div class="full-top-info">
                                                <ul class="post-info5">
                                                    <li><span class="lnr lnr-clock"></span> '.get_the_time('d M Y').'</li>
                                                    <li><span class="lnr lnr-bubble"></span> '.get_comments_number().'</li>
                                                </ul>
                                                <h2><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h2>
                                                <p>'.substr(get_the_excerpt(),0,60).'</p>
                                                <a href="'.esc_url(get_the_permalink()).'" class="readmore">'.esc_html__("read more","news").'<span class="lnr lnr-chevron-right"></span></a>
                                            </div>
                                        </div>';
                            break;

                        case 'home4-style-left':
                            $html .=    '<div class="item-top-post-home">
                                            <div class="top-post-home-thumb">
                                                <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(300,200)).'</a>
                                                <ul>
                                                    <li>'.esc_html__("in:","news").' '.$cate_html.'</li>
                                                    <li>'.esc_html__("Post by:","news").' <a href="'.get_author_posts_url(get_the_author_meta('ID')).'">'.get_the_author().'</a></li>
                                                </ul>
                                            </div>
                                            <div class="top-post-home-info">
                                                <div class="top-post-info-extra">
                                                    <span>'.get_comments_number().'</span> <label>'.esc_html__("tags:","news").'</label> '.$tags_html.'
                                                </div>
                                                <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                <span class="top-post-info-date"><span class="lnr lnr-clock"></span> '.get_the_time('d M Y').'</span>
                                                <p>'.substr(get_the_excerpt(),0,60).'</p>
                                            </div>
                                        </div>';
                            break;

                        case 'home4-style-right':
                            $html .=    '<div class="item-top-post-home">
                                            <div class="top-post-home-info">
                                                <div class="top-post-info-extra">
                                                    <span>'.get_comments_number().'</span> <label>'.esc_html__("tags:","news").'</label> '.$tags_html.'
                                                </div>
                                                <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                <span class="top-post-info-date"><span class="lnr lnr-clock"></span> '.get_the_time('d M Y').'</span>
                                                <p>'.substr(get_the_excerpt(),0,60).'</p>
                                            </div>
                                            <div class="top-post-home-thumb">
                                                <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(300,200)).'</a>
                                                <ul>
                                                    <li>'.esc_html__("in:","news").' '.$cate_html.'</li>
                                                    <li>'.esc_html__("Post by:","news").' <a href="'.get_author_posts_url(get_the_author_meta('ID')).'">'.get_the_author().'</a></li>
                                                </ul>
                                            </div>                                            
                                        </div>';
                            break;

                        case 'home2-footer':
                            $icon_class = 'lnr-file-empty';
                            $format = get_post_format();
                            if($format == 'video') $icon_class = 'lnr-camera-video';
                            if($format == 'image' || $format == 'gallery') $icon_class = 'lnr-camera';
                            $html .=    '<div class="item-footer-box-video">
                                            <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(370,250)).'</a>
                                            <span class="lnr '.$icon_class.'"></span>
                                        </div>';
                            break;

                        case 'home2-style':
                            $icon_class = 'lnr-file-empty';
                            $format = get_post_format();
                            if($format == 'video') $icon_class = 'lnr-camera-video';
                            if($format == 'image' || $format == 'gallery') $icon_class = 'lnr-camera';
                            $html .=    '<div class="sidebar-box">
                                            <div class="sidebar-box-thumb">
                                                <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(379,250)).'</a>
                                                <span class="format-post-sidebar"><span class="lnr '.$icon_class.'"></span></span>
                                            </div>
                                            <div class="sidebar-box-info">
                                                '.$term_html.'
                                                <h3 class="title-post2"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                            </div>
                                        </div>';
                            break;
                        
                        default:
                            $html .=    '<div class="box-banner-adv"><div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="banner-image">
                                                    <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(400,460)).'</a>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="banner-text">
                                                    <h4><a href="'.esc_url($term_link).'">'.$term_name.'</a></h4>
                                                    <h2><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h2>
                                                    <p>'.get_the_excerpt().'</p>
                                                    <div class="social-banner-text">
                                                        <a href="'.esc_url("https://plus.google.com/share?url=".get_the_permalink()).'"><i class="fa fa-google-plus"></i></a>
                                                        <a href="'.esc_url("http://www.facebook.com/sharer.php?u=".get_the_permalink()).'"><i class="fa fa-facebook"></i></a>
                                                        <a href="'.esc_url("http://www.twitter.com/share?url=".get_the_permalink()).'"><i class="fa fa-twitter"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div></div>';
                            break;
                    }                    
                endwhile;
            endif;
            wp_reset_postdata();            
        }
        return $html;
    }
}

stp_reg_shortcode('sv_post_special','sv_vc_post_special');

vc_map( array(
    "name"      => esc_html__("SV Post", 'news'),
    "base"      => "sv_post_special",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "dropdown",
            "holder" => "div",
            "heading" => esc_html__("Style",'news'),
            "param_name" => "style",
            "value"     => array(
                esc_html__( 'Default', 'news' )    => '',
                esc_html__( 'Style home 2', 'news' )    => 'home2-style',
                esc_html__( 'Style home 2 footer', 'news' )    => 'home2-footer',
                esc_html__( 'Style home 4 left', 'news' )    => 'home4-style-left',
                esc_html__( 'Style home 4 right', 'news' )    => 'home4-style-right',
                esc_html__( 'Style home 5 small', 'news' )    => 'home5-style-small',
                esc_html__( 'Style home 5 big', 'news' )    => 'home5-style-big',
                esc_html__( 'Style mega post', 'news' )    => 'mega-post',
                ),
            'description' => esc_html__( 'Select post to show.', 'news' ),
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Post",'news'),
            "param_name" => "post",
            "value"     => sv_get_list_post(),
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