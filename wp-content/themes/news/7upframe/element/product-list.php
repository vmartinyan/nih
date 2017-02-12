<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 05/09/15
 * Time: 10:00 AM
 */
if(class_exists("woocommerce")){
if(!function_exists('sv_vc_product_list'))
{
    function sv_vc_product_list($attr, $content = false)
    {
        $html = $el_class = $html_wl = $html_cp = '';
        extract(shortcode_atts(array(
            'style'         => 'cat-tab',
            'number'        => '8',
            'cats'          => '',
            'view_link'     => '',
            'feature_tab'   => '',
            'new_product_text'   => 'New Products',
            'special_text'   => 'Specials',
            'bestsell_text'   => 'Best Sellers',
            'title'         => '',
            'order_by'      => 'date',
            'order'         => 'DESC',
            'product_type'  => 'latest',
        ),$attr));
        $custom_list = array();
        $args = array(
            'post_type'         => 'product',
            'posts_per_page'    => $number,
            'orderby'          => $order_by,
            'order'             => $order,
            );
        if($product_type == 'toprate'){
            add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
            $args['no_found_rows'] = 1;
            $args['meta_query'] = WC()->query->get_meta_query();
        }
        if($product_type == 'mostview'){
            $args['meta_key'] = 'post_views';
            $args['orderby'] = 'meta_value_num';
        }
        if($product_type == 'bestsell'){
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
        }
        if($product_type=='onsale'){
            $args['meta_query'][]=array(
                'key'   => '_sale_price',
                'value' => 0,
                'compare' => '>',                
                'type'          => 'numeric'
            );
        }
        if($product_type == 'featured'){
            $args['meta_key'] = '_featured';
            $args['meta_value'] = 'yes';
        }
        if(!empty($cats)) {
            $custom_list = explode(",",$cats);
            $args['tax_query'][]=array(
                'taxonomy'=>'product_cat',
                'field'=>'slug',
                'terms'=> $custom_list
            );
        }
        $product_query = new WP_Query($args);
        $count_query = $product_query->post_count;
        switch ($style) {
            case 'feature-tab':
                if(!empty($feature_tab)){
                    $html .=    '<div class="shop-tab-slider">';
                    $pre = rand(0,1000);$tab_title_html = '';
                    $tabs = explode(',', $feature_tab);
                    $tab_title_html .=    '<ul class="nav nav-tabs" role="tablist">';
                    $ccount = 1;
                    foreach ($tabs as $tab) {
                        $f_class = '';$tab_text = '';
                        if($tab == 'feature-product')  $tab_text = $special_text;
                        if($tab == 'new-product')  $tab_text = $new_product_text;
                        if($tab == 'bestsell')  $tab_text = $bestsell_text;
                        if($ccount == 1) $f_class = 'active';
                        $tab_title_html .= '<li role="presentation" class="'.$f_class.'"><a href="#'.$pre.$tab.'" aria-controls="'.$pre.$tab.'" role="tab" data-toggle="tab">'.$tab_text.'</a></li>';
                        $ccount ++;
                    }
                    $tab_title_html .=        '</ul>';
                    $html .=        $tab_title_html;
                    $html .=        '<div class="tab-content">';
                    $ccount = 1;
                    foreach ($tabs as $tab) {
                        $args['orderby'] = 'date';
                        unset($args['meta_key']);
                        unset($args['meta_value']);
                        if($tab == 'feature-product'){
                            $args['meta_key'] = '_featured';
                            $args['meta_value'] = 'yes';
                        }
                        if($tab == 'bestsell'){
                            $args['meta_key'] = 'total_sales';
                            $args['orderby'] = 'meta_value_num';
                        }

                        $f_class = '';
                        if($ccount == 1) $f_class = 'active';
                        $html .=    '<div role="tabpanel" class="tab-pane '.$f_class.'" id="'.$pre.$tab.'">
                                        <div class="owl-tab-slider">
                                            <div class="wrap-item">';
                        $product_query = new WP_Query($args);
                        $count_query = $product_query->post_count;
                        $count = 1;
                        if($product_query->have_posts()) {
                            while($product_query->have_posts()) {
                                $product_query->the_post();
                                global $product,$post;
                                if(has_post_thumbnail(get_the_ID())) $thumb_html = get_the_post_thumbnail(get_the_ID(),array(250,250));
                                else $thumb_html = '';
                                $button_html =  apply_filters( 'woocommerce_loop_add_to_cart_link',
                                    sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s product_type_%s"><span data-hover="'.esc_html__("Add to cart","news").'">%s</span></a>',
                                        esc_url( $product->add_to_cart_url() ),
                                        esc_attr( $product->id ),
                                        esc_attr( $product->get_sku() ),
                                        esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                        $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button ajax_add_to_cart link-add-cart' : '',
                                        esc_attr( $product->product_type ),
                                        esc_html( $product->add_to_cart_text() )
                                    ),
                                $product );
                                if($count % 2 == 1){
                                    $html .= '<div class="item">';
                                }
                                $html .=        '<div class="item-product">
                                                    <div class="product-thumb">
                                                        <a href="#" class="product-quick-view fancybox.ajax">quick view</a>
                                                        <a href="'.esc_url(get_the_permalink()).'" class="product-thumb-link">
                                                            '.$thumb_html.'
                                                        </a>
                                                    </div>
                                                    <div class="product-info">
                                                        <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                        <div class="product-price">
                                                            <label>'.esc_html__("Price:","news").'  </label> '.$product->get_price_html().'
                                                        </div>
                                                        <ul class="product-cart">
                                                            <li>'.$button_html.'</li>
                                                            <li><a class="link-detail" href="'.esc_url(get_the_permalink()).'"><span data-hover="'.esc_html__("more detail","news").'">'.esc_html__("more detail","news").'</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>';
                                if($count % 2 == 0 || $count == $count_query){
                                    $html .=        '</div>';
                                }
                                $count++;
                            }
                        }
                        $html .=            '</div>
                                        </div>
                                    </div>';
                        $ccount++;
                    }
                    $html .=        '</div>';
                    $html .=    '</div>';
                }
                break;

            default:
                if(!empty($cats)){
                    $view_link = vc_build_link( $view_link );
                    if(!empty($view_link['url']) && !empty($view_link['title'])){
                        $view_html = '<a href="'.esc_url($view_link['url']).'" class="view-all">'.$view_link['title'].' <span class="lnr lnr-chevron-right-circle"></span></a>';
                    }
                    else $view_html = '';
                    $pre = rand(0,1000);$tab_title_html = '';
                    $cats = explode(',', $cats);
                    $tab_title_html .=    '<ul class="nav nav-tabs" role="tablist">';
                    $ccount = 1;
                    foreach ($cats as $cat_id) {
                        
                        $f_class = '';$expanded = 'false';
                        if($ccount == 1){
                            $f_class = 'active';
                            $expanded = 'true';
                        }
                        $term = get_term_by( 'slug',$cat_id, 'product_cat' );
                        $tab_title_html .= '<li role="presentation" class="'.$f_class.'"><a href="#'.$pre.$term->slug.'" aria-controls="'.$pre.$term->slug.'" role="tab" data-toggle="tab">'.$term->name.'</a></li>';
                        $ccount ++;
                    }
                    $tab_title_html .=        '</ul>';
                    
                    $html .=    '<div class="shop-featured-product">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="shop-featured-tab-title clearfix">
                                                <h2>'.$title.'</h2>
                                                '.$tab_title_html.'
                                                '.$view_html.'
                                            </div>  
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <div class="featured-tab-content">
                                                <div class="tab-content">';
                    $ccount = 1;
                    foreach ($cats as $cat_id) {
                        $f_class = '';
                        if($ccount == 1) $f_class = 'active';
                        $term = get_term_by( 'slug',$cat_id, 'product_cat' );
                        $args['tax_query'] = array();
                        $args['tax_query'][]=array(
                                                'taxonomy'=>'product_cat',
                                                'field'=>'slug',
                                                'terms'=> $cat_id
                                            );
                        $product_query = new WP_Query($args);
                        $count_query = $product_query->post_count;
                        $count = 1;
                        $html .=    '<div role="tabpanel" class="tab-pane '.$f_class.'" id="'.$pre.$term->slug.'">
                                        <div class="featured-product-slider">
                                            <div class="wrap-item">';
                        if($product_query->have_posts()) {
                            while($product_query->have_posts()) {
                                $product_query->the_post();
                                global $product,$post;
                                if(has_post_thumbnail(get_the_ID())) $thumb_html = get_the_post_thumbnail(get_the_ID(),array(470,470));
                                else $thumb_html = '';
                                $button_html =  apply_filters( 'woocommerce_loop_add_to_cart_link',
                                    sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s product_type_%s"><span data-hover="'.esc_html__("Add to cart","news").'">%s</span></a>',
                                        esc_url( $product->add_to_cart_url() ),
                                        esc_attr( $product->id ),
                                        esc_attr( $product->get_sku() ),
                                        esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                        $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button ajax_add_to_cart link-add-cart' : '',
                                        esc_attr( $product->product_type ),
                                        esc_html( $product->add_to_cart_text() )
                                    ),
                                $product );
                                $html .=        '<div class="item">
                                                    <div class="item-featured-product">
                                                        <a href="'.esc_url(get_the_permalink()).'">'.$thumb_html.'</a>
                                                        <div class="product-info">
                                                            <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                            <div class="product-price">
                                                                <label>'.esc_html__("Price:","news").'  </label> '.$product->get_price_html().'
                                                            </div>
                                                            <ul class="product-cart">
                                                                <li>'.$button_html.'</li>
                                                                <li><a class="link-detail" href="'.esc_url(get_the_permalink()).'"><span data-hover="'.esc_html__("more detail","news").'">'.esc_html__("more detail","news").'</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>';
                                $count++;
                            }
                        }
                        $html .=            '</div>
                                        </div>
                                    </div>';
                        $ccount++;
                    }                    
                    $html .=                    '</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                }
                break;
        }
        wp_reset_postdata();
        return $html;
    }
}

stp_reg_shortcode('sv_product_list','sv_vc_product_list');
add_action( 'vc_build_admin_page','sv_add_list_product',10,100 );
if ( ! function_exists( 'sv_add_list_product' ) ) {
    function sv_add_list_product(){
        vc_map( array(
            "name"      => esc_html__("SV Product list", 'news'),
            "base"      => "sv_product_list",
            "icon"      => "icon-st",
            "category"  => '7Up-theme',
            "params"    => array(
                array(
                    'heading'     => esc_html__( 'Style', 'news' ),
                    'type'        => 'dropdown',
                    'description' => esc_html__( 'Choose style to display.', 'news' ),
                    'param_name'  => 'style',
                    'value'       => array(
                        esc_html__('Category Tab','news') => 'cat-tab',
                        esc_html__('Feature Tab','news') => 'feature-tab',
                        )
                ),
                array(
                    'heading'     => esc_html__( 'Title', 'news' ),
                    'type'        => 'textfield',
                    'param_name'  => 'title',
                    'dependency'  => array(
                        'element'   => 'style',
                        'value'   => 'cat-tab',
                        )
                ),
                array(
                    'heading'     => esc_html__( 'View link', 'news' ),
                    'type'        => 'vc_link',
                    'param_name'  => 'view_link',
                    'dependency'  => array(
                        'element'   => 'style',
                        'value'   => 'cat-tab',
                        )
                ),
                array(
                    'heading'     => esc_html__( 'Feature Tabs', 'news' ),
                    'type'        => 'checkbox',
                    'param_name'  => 'feature_tab',
                    'value'       => array(
                        esc_html__('New Product','news') => 'new-product',
                        esc_html__('Special Product','news') => 'feature-product',
                        esc_html__('Best Seller','news') => 'bestsell',
                        ),
                    'dependency'  => array(
                        'element'   => 'style',
                        'value'   => 'feature-tab',
                        )
                ),
                array(
                    'heading'     => esc_html__( 'New Product tab label', 'news' ),
                    'type'        => 'textfield',
                    'param_name'  => 'new_product_text',
                    'dependency'  => array(
                        'element'   => 'style',
                        'value'   => 'feature-tab',
                        )
                ),
                array(
                    'heading'     => esc_html__( 'Special tab label', 'news' ),
                    'type'        => 'textfield',
                    'param_name'  => 'special_text',
                    'dependency'  => array(
                        'element'   => 'style',
                        'value'   => 'feature-tab',
                        )
                ),
                array(
                    'heading'     => esc_html__( 'Bestsell tab label', 'news' ),
                    'type'        => 'textfield',
                    'param_name'  => 'bestsell_text',
                    'dependency'  => array(
                        'element'   => 'style',
                        'value'   => 'feature-tab',
                        )
                ),
                array(
                    'heading'     => esc_html__( 'Number', 'news' ),
                    'type'        => 'textfield',
                    'description' => esc_html__( 'Enter number of product. Default is 8.', 'news' ),
                    'param_name'  => 'number',
                ),
                array(
                    'heading'     => esc_html__( 'Product Type', 'news' ),
                    'type'        => 'dropdown',
                    'param_name'  => 'product_type',
                    'value' => array(
                        esc_html__('Latest Products','news')    => 'latest',
                        esc_html__('Featured Products','news')  => 'featured',
                        esc_html__('Best Sellers','news')       => 'bestsell',
                        esc_html__('On Sale','news')            => 'onsale',
                        esc_html__('Top rate','news')           => 'toprate',
                        esc_html__('Most view','news')          => 'mostview',
                    ),
                    'description' => esc_html__( 'Select Product View Type', 'news' ),
                    'dependency'  => array(
                        'element'   => 'style',
                        'value'   => 'cat-tab',
                        )
                ),
                array(
                    'holder'     => 'div',
                    'heading'     => esc_html__( 'Product Categories', 'news' ),
                    'type'        => 'checkbox',
                    'param_name'  => 'cats',
                    'value'       => sv_list_taxonomy('product_cat',false)
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__( 'Order By', 'news' ),
                    'value' => array(
                        esc_html__('Date','news')  => 'date',
                        esc_html__('Rand','news')  => 'rand',
                        esc_html__('Name','news')  => 'title',
                        esc_html__('Price','news') => 'price',
                    ),
                    'param_name' => 'orderby',
                    'description' => esc_html__( 'Select Orderby Type ', 'news' ),
                    'edit_field_class'=>'vc_col-sm-6 vc_column',
                ),
                array(
                    'heading'     => esc_html__( 'Order', 'news' ),
                    'type'        => 'dropdown',
                    'param_name'  => 'order',
                    'value' => array(                   
                        esc_html__('Desc','news')  => 'DESC',
                        esc_html__('Asc','news')  => 'ASC',
                    ),
                    'description' => esc_html__( 'Select Order Type ', 'news' ),
                    'edit_field_class'=>'vc_col-sm-6 vc_column',
                ),
            )
        ));
    }
}
}