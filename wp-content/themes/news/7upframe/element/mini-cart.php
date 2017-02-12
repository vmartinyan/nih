<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */
if(class_exists( 'WooCommerce' )){
    if(!function_exists('sv_vc_mini_cart'))
    {
        function sv_vc_mini_cart($attr)
        {
            $html = '';
            extract(shortcode_atts(array(
                'title'      => 'Cart',
            ),$attr));
            $html .=    '<div class="mini-cart">
                            <a href="'.esc_url(WC()->cart->get_cart_url()).'" class="mini-cart-link icon-cart">'.$title.' <sup class="cart-item-count">0</sup></a>
                            <div class="mini-cart-info">
                                <h2><span class="cart-item-count">0</span>'.esc_html__(" Items","news").'</h2>
                                <div class="mini-cart-content">'.sv_mini_cart().'</div>
                            </div>
                            <input id="num-decimal" type="hidden" value="'.get_option("woocommerce_price_num_decimals").'">
                            <input id="currency" type="hidden" value=".'.get_option("woocommerce_currency").'">
                        </div>';
            return $html;
        }
    }

    stp_reg_shortcode('sv_mini_cart','sv_vc_mini_cart');

    vc_map( array(
        "name"      => esc_html__("SV Mini Cart", 'news'),
        "base"      => "sv_mini_cart",
        "icon"      => "icon-st",
        "category"  => '7Up-theme',
        "params"    => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => esc_html__("Title",'news'),
                "param_name" => "title",
            )
        )
    ));
}