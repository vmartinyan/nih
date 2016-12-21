<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package 7up-framework
 */
?>
<?php
$sidebar = sv_get_sidebar();
if ( is_active_sidebar( $sidebar['id']) && $sidebar['position'] != 'no' ):?>
	<?php if(sv_is_woocommerce_page() || $sidebar['id'] == 'woocommerce-sidebar'){?>
		<div class="col-md-3 col-sm-4 col-xs-12">
			<div class="sidebar-product">
			    <?php dynamic_sidebar($sidebar['id']); ?>
			</div>
		</div>
	<?php }
	else{
		?>
		<div class="col-md-3 col-sm-4 col-xs-12">
			<?php dynamic_sidebar($sidebar['id']); ?>
		</div>
		<?php
	}?>
<?php endif;?>