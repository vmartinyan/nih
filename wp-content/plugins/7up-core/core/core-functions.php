<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


/**
 * Register post type
 *
 *
 * */

if(!function_exists('stp_reg_post_type'))
{
    function stp_reg_post_type($post_type, $args)
    {
        register_post_type($post_type, $args);
    }
}
/**
 * Register post type
 *
 *
 * */

if(!function_exists('stp_reg_taxonomy'))
{
    function stp_reg_taxonomy($taxonomy, $object_type, $args )
    {
        register_taxonomy($taxonomy, $object_type, $args );
    }
}
/**
 * Add shortcode
 *
 *
 * */

if(!function_exists('stp_reg_shortcode'))
{
    function stp_reg_shortcode($tag , $func )
    {
        add_shortcode($tag , $func );
    }
}
if(!function_exists('sv_shortcode_param'))
{
    function sv_shortcode_param( $name, $form_field_callback, $script_url = null ){
        add_shortcode_param( $name, $form_field_callback, $script_url = null );
    }
}

if(!function_exists('sv_scrape_instagram'))
{
function sv_scrape_instagram($username, $slice = 9) {
    $username = strtolower($username);
    if (get_transient('instagram-media-'.sanitize_title_with_dashes($username))) {
        $remote = wp_remote_get('http://instagram.com/'.trim($username));
        if (is_wp_error($remote))
        return new WP_Error('site_down', __('Unable to communicate with Instagram.', LANGUAGE));
        if ( 200 != wp_remote_retrieve_response_code( $remote ) )
        return new WP_Error('invalid_response', __('Instagram did not return a 200.', LANGUAGE));
        $shards = explode('window._sharedData = ', $remote['body']);
        $insta_json = explode(';</script>', $shards[1]);
        $insta_array = json_decode($insta_json[0], TRUE);
        // var_dump($insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes']);
        if (!$insta_array)
        return new WP_Error('bad_json', __('Instagram has returned invalid data.', LANGUAGE));
        $images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
        $instagram = array();
        foreach ($images as $image) {
            $instagram[] = array(
                'link' => 'http://instagram.com/p/'.$image['code'],
                'thumbnail_src' => $image['thumbnail_src'],
            );
        }
        $instagram = base64_encode( serialize( $instagram ) );
        set_transient('instagram-media-'.sanitize_title_with_dashes($username), $instagram, apply_filters('null_instagram_cache_time', HOUR_IN_SECONDS*2));
    }
    $instagram = unserialize( base64_decode( $instagram ) );
    return array_slice($instagram, 0, $slice);
    }
}
if(!function_exists('sv_images_only'))
{
    function sv_images_only($media_item) {
        if ($media_item['type'] == 'image')
        return true;
        return false;
    }
}
if(!function_exists('sv_get_current_url'))
{
    function sv_get_current_url() {
        $url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        return $url;
    }
}
if(!function_exists('s7upf_get_price_arange')){
    function s7upf_get_price_arange(){
        global $wpdb, $wp_the_query;
        $args       = $wp_the_query->query_vars;
        if ( ! empty( $args['taxonomy'] ) && ! empty( $args['term'] ) ) {
            $tax_query[] = array(
                'taxonomy' => $args['taxonomy'],
                'terms'    => array( $args['term'] ),
                'field'    => 'slug',
            );
        }
        $tax_query  = array();
        $meta_query  = array();
        foreach ( $meta_query as $key => $query ) {
            if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
                unset( $meta_query[ $key ] );
            }
        }

        $meta_query = new WP_Meta_Query( $meta_query );
        $tax_query  = new WP_Tax_Query( $tax_query );

        $meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
        $tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );
        $sql  = "
        SELECT min( CAST( price_meta.meta_value AS UNSIGNED ) ) as min_price, max( CAST( price_meta.meta_value AS UNSIGNED ) ) as max_price FROM {$wpdb->posts} ";
        $sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
        $sql .= "   WHERE {$wpdb->posts}.post_type = 'product'
                    AND {$wpdb->posts}.post_status = 'publish'
                    AND price_meta.meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
                    AND price_meta.meta_value > '' ";
        $sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

        $prices = $wpdb->get_row( $sql );
        $price = array();
        $price['min'] = floor( $prices->min_price );
        $price['max'] = ceil( $prices->max_price );
        return $price;
    }
}
if(!function_exists('s7upf_load_lib')){
    function s7upf_load_lib($folder)
    {
        //Auto load widget
        $files=glob(get_template_directory()."/"."7upframe/".$folder."/*.php");

        // Auto load all file
        if(!empty($files)){
            foreach ($files as $filename)
            {
                load_template($filename);
            }
        }

    }
}
function s7upf_get_image_by_url($image_src,$size,$class=''){
    global $wpdb;
    $width = $height = '';
    if(is_array($size)){
        $width = $size[0];
        $height = $size[1];
    }
    $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
    $id = $wpdb->get_var($query);
    if($id) $html = wp_get_attachment_image($id,$size,0,array('class'=>$class));
    else $html = '<img width="'.esc_attr($width).'"  height="'.esc_attr($height).'" class="'.esc_attr($class).'" alt="" src="'.esc_url($image_src).'">';
    return $html;
}
//Add header style
if (!function_exists('s7upf_add_inline_style')) {
    function s7upf_add_inline_style($style) {
        $content ='<script type="text/javascript">
                    (function($) {
                        "use strict";
                        $("head").append('."'".'<style id="sv_add_footer_css">'.$style.'</style>'."'".');
                    })(jQuery);
                    </script>';
        return $content;
    }
}