<?php
/**
 * Product quantity inputs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div class="quantity attr-product info-qty">
	<label><?php esc_html_e("Qty","news")?>:</label>
	<input type="text" data-step="<?php echo esc_attr( $step ); ?>" <?php if ( is_numeric( $min_value ) ) : ?>data-min="<?php echo esc_attr( $min_value ); ?>"<?php endif; ?> <?php if ( is_numeric( $max_value ) ) : ?>data-max="<?php echo esc_attr( $max_value ); ?>"<?php endif; ?> name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $input_value ); ?>" title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'news' ) ?>" class="input-text text qty-val" size="4" />
	<a class="qty-up" href="#"><span class="lnr lnr-chevron-up-circle"></span></a>
	<a class="qty-down" href="#"><span class="lnr lnr-chevron-down-circle"></span></a>
</div>