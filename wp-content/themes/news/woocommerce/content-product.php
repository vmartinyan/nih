<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product;
// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;
?>
<?php
	$type = 'grid';
    if(isset($_GET['type'])){
        $type = $_GET['type'];
    }
?>
<?php if($type == 'list'){
	$size = array(270,270);?>
	<li class="col-md-12 col-sm-12 col-xs-12">
		<div class="item-product">
			<div class="product-thumb">
				<?php echo balanceTags(sv_product_quick_view());?>
				<a href="<?php echo esc_url(get_the_permalink());?>" class="product-thumb-link">
					<?php the_post_thumbnail($size)?>
				</a>
			</div>
		</div>
		<div class="product-info">
			<h3><a href="<?php echo esc_url(get_the_permalink());?>"><?php the_title()?></a></h3>
			<div class="product-price">
				<label><?php esc_html_e("Price:","news")?>  </label> <?php echo balanceTags($product->get_price_html())?>
			</div>
			<?php echo balanceTags(sv_get_rating_html());?>
			<p class="desc"><?php echo get_the_excerpt()?></p>
			<?php echo balanceTags(sv_product_link());?>
		</div>
	</li>
<?php }
	else{
		$b_col = 12;$col = 4;$size = array(270,270);
		$col_option = $woocommerce_loop['columns'];
		if(!empty($col_option)) $col = $b_col/(int)$col_option;
		if($col_option == 2) $size = array(420,420);
		if($col_option >= 2) $col_sm = 6;
		else $col_sm = 12;
	?>
	<li class="col-md-<?php echo esc_attr($col)?> col-sm-<?php echo esc_attr($col_sm)?> col-xs-12">
		<div class="item-product">
			<div class="product-thumb">
				<?php echo balanceTags(sv_product_quick_view());?>
				<a href="<?php echo esc_url(get_the_permalink());?>" class="product-thumb-link">
					<?php the_post_thumbnail($size)?>
				</a>
			</div>
			<div class="product-info">
				<h3><a href="<?php echo esc_url(get_the_permalink());?>"><?php the_title()?></a></h3>
				<div class="product-price">
					<label><?php esc_html_e("Price:","news")?>  </label> <?php echo balanceTags($product->get_price_html())?>
				</div>
				<?php echo balanceTags(sv_product_link());?>
			</div>
		</div>
	</li>
<?php }?>