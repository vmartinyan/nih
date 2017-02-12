<?php
 
function css3_image_eff_custom_icon(){
?>
 
<style>
#adminmenu .menu-icon-css3-rdhov div.wp-menu-image:before {
content: "\f232";
}
</style>
 
<?php
}
add_action( 'admin_head', 'css3_image_eff_custom_icon' );
?>