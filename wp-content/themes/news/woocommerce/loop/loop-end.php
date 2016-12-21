<?php
/**
 * Product Loop End
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 */
global $wp_query;
?>	
</ul>
<div class="product-paging">
	<?php
		echo paginate_links( array(
			'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
			'format'       => '',
			'add_args'     => '',
			'current'      => max( 1, get_query_var( 'paged' ) ),
			'total'        => $wp_query->max_num_pages,
			'prev_text'    => '<span class="lnr lnr-arrow-left"></span>',
			'next_text'    => '<span class="lnr lnr-arrow-right"></span>',
			'type'         => 'plain',
			'end_size'     => 2,
			'mid_size'     => 1
		) );
	?>
</div>