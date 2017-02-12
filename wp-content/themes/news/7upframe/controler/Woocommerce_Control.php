<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */

if(class_exists( 'WooCommerce' )){
    /*********************************** ADD TO CART AJAX *******************************************/
    add_action( 'wp_ajax_add_to_cart', 'sv_minicart_ajax' );
    add_action( 'wp_ajax_nopriv_add_to_cart', 'sv_minicart_ajax' );
    if(!function_exists('sv_minicart_ajax')){
        function sv_minicart_ajax() {
            
            $product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
            $quantity = empty( $_POST['quantity'] ) ? 1 : apply_filters( 'woocommerce_stock_amount', $_POST['quantity'] );
            $passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );

            if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity ) ) {
                do_action( 'woocommerce_ajax_added_to_cart', $product_id );
                WC_AJAX::get_refreshed_fragments();
            } else {
                $this->json_headers();

                // If there was an error adding to the cart, redirect to the product page to show any errors
                $data = array(
                    'error' => true,
                    'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id )
                    );
                echo json_encode( $data );
            }
            die();
        }
    }
    /*********************************** END ADD TO CART AJAX ****************************************/

    /********************************** REMOVE ITEM MINICART AJAX ************************************/
    add_action( 'wp_ajax_product_remove', 'sv_product_remove' );
    add_action( 'wp_ajax_nopriv_product_remove', 'sv_product_remove' );
    if(!function_exists('sv_product_remove')){
        function sv_product_remove() {
            global $wpdb, $woocommerce;
            $cart_item_key = $_POST['cart_item_key'];
            if ( $woocommerce->cart->get_cart_item( $cart_item_key ) ) {
                $woocommerce->cart->remove_cart_item( $cart_item_key );
            }
            exit();
        }
    }

    /********************************** END REMOVE ITEM MINICART AJAX ************************************/
    
    /********************************** FANCYBOX POPUP CONTENT ************************************/

    add_action( 'wp_ajax_product_popup_content', 'sv_product_popup_content' );
    add_action( 'wp_ajax_nopriv_product_popup_content', 'sv_product_popup_content' );
    if(!function_exists('sv_product_popup_content')){
        function sv_product_popup_content() {
            $product_id = $_POST['product_id'];
            $query = new WP_Query( array(
                'post_type' => 'product',
                'post__in' => array($product_id)
                ));
            if( $query->have_posts() ):
                echo '<div class="woocommerce single-product product-popup-content">';
                while ( $query->have_posts() ) : $query->the_post();    
                    global $post,$product,$woocommerce;         
                    sv_product_main_detai(true);
                endwhile;
                echo '</div>';
            endif;
            wp_reset_postdata();
        }
    }
    /********************************** END FANCYBOX POPUP CONTENT ******************************/

    //remove woo breadcrumbs
    add_action( 'init','sv_remove_wc_breadcrumbs' );

    // remove action wrap main content
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

    // Custom wrap main content
    add_action('woocommerce_before_main_content', 'sv_add_before_main_content', 10);
    add_action('woocommerce_after_main_content', 'sv_add_after_main_content', 10);

    // Remove page title
    add_filter( 'woocommerce_show_page_title', 'sv_remove_page_title');

    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
    remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

    //Custom woo shop column
    add_filter( 'loop_shop_columns', 'sv_woo_shop_columns', 1, 10 );

    //FUNCTION
    function sv_remove_page_title() {
        return false;
    }

    function sv_add_before_main_content() {
        $sidebar = sv_get_sidebar();
        $sidebar_pos = $sidebar['position'];
        $main_class = 'col-md-12 col-sm-12 col-xs-12';
        if($sidebar_pos != 'no') $main_class = 'col-md-9 col-sm-8 col-xs-12';
        $col_class = 'shop-width-'.sv_get_option('woo_shop_column',3);
        ?>
        <div id="main-content" class="<?php echo esc_attr($col_class);?>">
            <div class="container">
                <?php sv_header_page()?>
                <div class="row content-product-page">
                    <?php if($sidebar_pos=='left'){ get_sidebar(); }?>
                    <div class="<?php echo esc_attr($main_class); ?>">
                        <div class="main-product">
        <?php
    }

    function sv_add_after_main_content() {
        $sidebar = sv_get_sidebar();
        $sidebar_pos=$sidebar['position'];
        ?>
                        </div>
                    </div>
                    <?php if($sidebar_pos=='right'){ get_sidebar(); }?>
                </div>
            </div>
        </div>
        <?php
    }

    function sv_remove_wc_breadcrumbs()
    {
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
    }

    function sv_output_related_products() {
        $output = null;
        ob_start();
        woocommerce_related_products(array('posts_per_page' => 4,'columns'  => 4),true,false); 
        $content = ob_get_clean();
        if($content) { $output .= $content; }

        echo '<div class="clear"></div>' . $output;
    }

    //Custom woo shop column
    add_filter( 'loop_shop_columns', 'sv_woo_shop_columns', 1, 10 );
    function sv_woo_shop_columns( $number_columns ) {
        $col = sv_get_option('woo_shop_column',3);
        return $col;
    }
    add_filter( 'loop_shop_per_page', 'sv_woo_shop_number', 20 );
    function sv_woo_shop_number( $number) {
        $col = sv_get_option('woo_shop_number',12);
        return $col;
    }
}