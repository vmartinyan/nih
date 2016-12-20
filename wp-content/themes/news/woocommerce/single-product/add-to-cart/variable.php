<?php
/**
 * Variable product add to cart
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$attribute_keys = array_keys( $attributes );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->id ); ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'news' ); ?></p>
	<?php else : ?>
	<div class="wrap-attr-product">
		<div class="variations">
			<?php foreach ( $attributes as $attribute_name => $options ) : ?>
			<?php if($attribute_name == 'pa_color'){?>
				<div class="attr-product attr-color">
                    <label><?php echo wc_attribute_label( $attribute_name ); ?>:</label>
                    <ul class="select-attr-color attr-color" data-attribute-id="<?php echo esc_attr($attribute_name)?>">
                    	<?php
	                    	if ( ! empty( $options ) ) {
								if ( $product && taxonomy_exists( $attribute_name ) ) {
									// Get terms if this is a taxonomy - ordered. We need the names too.
									$terms = wc_get_product_terms( $product->id, $attribute_name, array( 'fields' => 'all' ) );

									foreach ( $terms as $term ) {
										if ( in_array( $term->slug, $options ) ) {
											echo '<li data-attribute="' . esc_attr( $term->slug ) . '"><a href="#"><span class="color-' . esc_attr( $term->slug ) . '"></span></a></li>';
										}
									}
								} else {
									foreach ( $options as $option ) {
										echo '<li data-attribute="' . esc_attr( $term->slug ) . '"><a href="#"><span class="' . esc_attr( $term->slug ) . '"></span></a></li>';
									}
								}
							}
                    	?>
                    </ul>
                </div>
            <?php }
            else{?>
				<div class="attr-product <?php echo esc_attr($attribute_name)?>">
					<label><?php echo wc_attribute_label( $attribute_name ); ?></label>
                    <div class="attr-size">
	                    <a href="#" class="selected-attr-size"></a>
	                    <ul class="select-attr-size" data-attribute-id="<?php echo esc_attr($attribute_name)?>">
	                    	<li data-attribute=""><a href="#"><?php esc_html_e("Choose an options","news")?></a></li>
	                    	<?php
		                    	if ( ! empty( $options ) ) {
									if ( $product && taxonomy_exists( $attribute_name ) ) {
										// Get terms if this is a taxonomy - ordered. We need the names too.
										$terms = wc_get_product_terms( $product->id, $attribute_name, array( 'fields' => 'all' ) );

										foreach ( $terms as $term ) {
											if ( in_array( $term->slug, $options ) ) {
												echo '<li data-attribute="' . esc_attr( $term->slug ) . '"><a href="#">' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</a></li>';
											}
										}
									} else {
										foreach ( $options as $option ) {
											echo '<li data-attribute="' . esc_attr( $term->slug ) . '"><a href="#">' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</a></li>';
										}
									}
								}
	                    	?>
	                    </ul>
	                </div>
               	</div>
            <?php } ?>
            	<div class="default-attribute">
					<label for="<?php echo sanitize_title( $attribute_name ); ?>"><?php echo wc_attribute_label( $attribute_name ); ?></label>
					<?php
						$selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) : $product->get_variation_default_attribute( $attribute_name );
						wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected ) );
						echo end( $attribute_keys ) === $attribute_name ? '<a class="reset_variations" href="#">' . esc_html__( 'Clear selection', 'news' ) . '</a>' : '';
					?>
				</div>
	        <?php endforeach;?>
	        <a class="reset_variations" href="#">Clear selection</a>
		</div>
	</div>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap" style="display:none;">
			<?php
				/**
				 * woocommerce_before_single_variation Hook
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * woocommerce_after_single_variation Hook
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
