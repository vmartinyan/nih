<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 */
global $wp_query;
?>
<?php
	$type = 'grid';
    if(isset($_GET['type'])){
        $type = $_GET['type'];
    }
?>
<div class="title-tab-product shop-tab-slider">
	<ul class="nav nav-tabs">
		<li class="<?php if($type == 'grid') echo 'active'?>"><a href="<?php echo esc_url(sv_get_type_url('grid'))?>"><?php esc_html_e("Grid","news")?></a></li>
		<li class="<?php if($type == 'list') echo 'active'?>"><a href="<?php echo esc_url(sv_get_type_url('list'))?>"><?php esc_html_e("List","news")?></a></li>
	</ul>
</div>
<ul class="row list-unstyled product-<?php echo esc_attr($type);?>">
	