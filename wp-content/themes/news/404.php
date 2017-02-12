<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div class="wrap">
		<div id="primary" class="content-area 404-default single-content">
			<?php
			$page_id = sv_get_option('sv_404_page');
			if(!empty($page_id)) {
			    echo 	'<div class="custom-404-page">
			            	<div class="container">';
			    echo        	SV_Template::get_vc_pagecontent($page_id);
			    echo    	'</div>
			          	</div>';
			}
			else{ ?>
				<div class="container">
					<div class="error-page">
						<div class="error-box">
							<div class="clearfix">
								<div class="error-title">
									<h1><?php esc_html_e("404","news")?></h1>
									<h2><?php esc_html_e("error","news")?></h2>
								</div>
								<div class="error-content">
									<h2><?php esc_html_e("Component not found","news")?></h2>
									<p><?php esc_html_e("Please try one of the following pages:","news")?></p>
									<a href="<?php echo esc_url(get_home_url('/'))?>" class="return-home"><i class="fa fa-home"></i> <?php esc_html_e("Homepage","news")?></a>
									<p><?php esc_html_e("If difficulties persist, please contact the System Administrator of this site and report the error","news")?> </p>
								</div>
							</div>
							<img src="<?php echo get_template_directory_uri();?>/assets/css/images/bg-pen.png" alt="" class="error-image">
						</div>
					</div>
				</div>
			<?php }?>
		</div><!-- .content-area -->
	</div>
<?php wp_footer(); ?>
</body>
</html>
