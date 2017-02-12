<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php sv_product_main_detai()?>

	<meta itemprop="url" content="<?php echo esc_url(get_the_permalink()); ?>" />
	<?php 
		$tabs = apply_filters( 'woocommerce_product_tabs', array() );
	?>
	<!-- TAB PRODUCT -->
	<div class="tab-detail">
		<div class="title-tab-detail">
			<ul class="nav nav-tabs" role="tablist">
				<?php 
					$num=0;
					foreach ( $tabs as $key => $tab ) : 
					$num++;
				?>
					<li class="<?php if($num==1){echo 'active';}?>" role="presentation">
						<a href="#sv-<?php echo esc_attr( $key ); ?>" aria-controls="<?php echo esc_attr( $key ); ?>" role="tab" data-toggle="tab"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
					</li>
						
				<?php endforeach; ?>
				<li role="presentation"><a href="#custom-service" aria-controls="profile" role="tab" data-toggle="tab"><?php esc_html_e("Custom Service","news")?></a></li>				
				<li role="presentation"><a href="#tags" aria-controls="settings" role="tab" data-toggle="tab"><?php esc_html_e("Tags","news")?></a></li>
			</ul>
		</div>
		<!-- Tab panes -->
		<div class="content-tab-detail">
			<div class="tab-content">
				<?php 
					$num=0;
					foreach ( $tabs as $key => $tab ) : 
					$num++;
				?>
					<div role="tabpanel" class="tab-pane <?php if($num==1){echo 'active';}?>" id="sv-<?php echo esc_attr( $key ); ?>">
						<div class="inner-content-tab-detail">
							<?php call_user_func( $tab['callback'], $key, $tab ); ?>
						</div>
					</div>
				<?php endforeach; ?>
				<div role="tabpanel" class="tab-pane" id="custom-service">
					<div class="inner-content-tab-detail">
						<h2><?php esc_html_e("Custom Service","news")?></h2>
						<?php
				            $info_content = get_post_meta(get_the_ID(),'custom_service',true);
				            echo apply_filters('the_content',$info_content);
				        ?>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="tags">
					<div class="inner-content-tab-detail">
						<?php 
							global $product,$post;
							$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );
							echo $product->get_tags( ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', $tag_count, 'news' ) . ' ', '</span>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END TAB PRODUCT -->

	<!-- RELATE PRODUCT -->
	<?php 
		global $product;
		$related = $product->get_related(6);
	?>
	<div class="latest-product body-shop">
		<h2><?php esc_html_e("Related products","news")?></h2>
		<div class="latest-product-slider">
			<div class="wrap-item">
				<?php
					$args = apply_filters( 'woocommerce_related_products_args', array(
						'post_type'            => 'product',
						'ignore_sticky_posts'  => 1,
						'no_found_rows'        => 1,
						'posts_per_page'       => 6,									
						'orderby'              => 'ID',
						'post__in'             => $related,
						'post__not_in'         => array( $product->id )
					) );
					$products = new WP_Query( $args );
					if ( $products->have_posts() ) :
						while ( $products->have_posts() ) : 
							$products->the_post();
							global $product;
				?>
							<div class="item">
								<div class="item-product">
									<div class="product-thumb">
										<?php echo balanceTags(sv_product_quick_view());?>
										<a href="<?php echo esc_url(get_the_permalink());?>" class="product-thumb-link">
											<?php the_post_thumbnail(array(250,250))?>
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
							</div>
				<?php 	endwhile;
					endif;
					wp_reset_postdata();
				?>
			</div>
		</div>
	</div>			
	<!-- END RELATE PRODUCT -->
</div>
<?php do_action( 'woocommerce_after_single_product' ); ?>
