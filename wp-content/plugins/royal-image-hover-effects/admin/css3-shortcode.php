<?php

// Register Shortcode
function css3_image_hover_effects_style1_shortcode($atts, $content = null){
	extract( shortcode_atts( array(
	
		'category' => '',
		
	), $atts) );
	

		$q = new WP_Query(
        array('posts_per_page' => -1, 'post_type' => 'css3-rdhov', 'css3hov_cat' => $category)
        );
		
		while($q->have_posts()) : $q->the_post();
		$id = get_the_ID();
	 
	$style1_options = vp_metabox('rdmain-meta.style1_option', false);	
	
	
	$hover_item_show = vp_metabox('rdmain-meta.style1_settings_option.0.hover_item_show', false);
	$select_hover_effects = vp_metabox('rdmain-meta.style1_settings_option.0.select_hover_effects', false);
	$css3_hover_animation = vp_metabox('rdmain-meta.style1_settings_option.0.css3_hover_animation', false);
	$style1_custom_css = vp_metabox('rdmain-meta.style1_settings_option.0.style1_custom_css', false);
	$css3_hover_layout = vp_metabox('rdmain-meta.style1_settings_option.0.css3_hover_layout', false);
	$seclect_circle_effects_border = vp_metabox('rdmain-meta.style1_settings_option.0.seclect_circle_effects_border', false);
	
	// Social Icon Meta Box
   //	$first_social_icon_choser = vp_metabox('rdmain-meta.style1_social_setting.0.first_social_icon_choser', false);

	

	$i = 0;

		$output = '
		<main class="site-content royal-container"><div class="row">
		<style type="text/css">
		'.$style1_custom_css.'
		.royal-item.round.focus-dark, .royal-item.round .royal-hov-conten.focus-dark, .royal-hov-content.round.focus-dark {
			  border: 10px solid #d9d9ff;
			}
		</style>
		';

		foreach ($style1_options as $style1_option) {
			
		if ($select_hover_effects=="effects1") {
		$output .= '<div style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;" class="'.$hover_item_show.'">
						<div class="royal-item">
							<div style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;" class="'.$seclect_circle_effects_border.' royal-hov-content '.$css3_hover_layout.' royal-trans-animation '.$css3_hover_animation.'">
								<span class="royal-image">
									<img src="'.$style1_option['style1_image_upload'].'" alt="Hover Image">
								</span>
								<span class="info-box text-center padding-20px">

									<span class="rdvib-center">
										<h2 style="color: #fff; ">'.$style1_option['put_style1_title'].'</h2>
										<small class="separator"></small>
										<p style="color: #fff;">'.$style1_option['put_style1_description'].'</p>
										<small class="separator"></small>
										<!-- Social Media Icons -->
										<span class="social-media padding-bottom-10px">
	<a href="'.$style1_option['first_social_icon_link'].'" ><i class="fa '.$style1_option['first_social_icon_choser'].' fa-lg margin-right-5px"></i></a>
	<a href="'.$style1_option['second_social_icon_link'].'"><i class="fa '.$style1_option['second_social_icon_choser'].' fa-lg margin-right-5px"></i></a>
	<a href="'.$style1_option['third_social_icon_link'].'"><i class="fa '.$style1_option['third_social_icon_choser'].' fa-lg margin-right-5px"></i></a>
   <a href="'.$style1_option['fourth_social_icon_link'].'"><i class="fa '.$style1_option['fourth_social_icon_choser'].' fa-lg"></i></a>
										</span>
									</span>

								</span>
							</div>
						</div>
					</div>
				';
			}
			
		if ($select_hover_effects=="effects2") {
		$output .= '<div style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;" class="'.$hover_item_show.'">
						<div class="royal-item">
							<div style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;" class="'.$seclect_circle_effects_border.' royal-hov-content '.$css3_hover_layout.' royal-fade-in-animation '.$css3_hover_animation.'">
								<span class="royal-image">
									<img src="'.$style1_option['style1_image_upload'].'" alt="Hover Image">
								</span>
								<span class="info-box text-center padding-20px">

									<span class="rdvib-center">
										<h2 style="color: #fff; ">'.$style1_option['put_style1_title'].'</h2>
										<small class="separator"></small>
										<p style="color: #fff;">'.$style1_option['put_style1_description'].'</p>
										<small class="separator"></small>
										<!-- Social Media Icons -->
										<span class="social-media padding-bottom-10px">
	<a href="'.$style1_option['first_social_icon_link'].'" ><i class="fa '.$style1_option['first_social_icon_choser'].' fa-lg margin-right-5px"></i></a>
	<a href="'.$style1_option['second_social_icon_link'].'"><i class="fa '.$style1_option['second_social_icon_choser'].' fa-lg margin-right-5px"></i></a>
	<a href="'.$style1_option['third_social_icon_link'].'"><i class="fa '.$style1_option['third_social_icon_choser'].' fa-lg margin-right-5px"></i></a>
    <a href="'.$style1_option['fourth_social_icon_link'].'"><i class="fa '.$style1_option['fourth_social_icon_choser'].' fa-lg"></i></a>
										</span>
									</span>

								</span>
							</div>
						</div>
					</div>
				';
			}
		if ($select_hover_effects=="effects3") {
		$output .= '
			<style type="text/css">
			@import url(https://fonts.googleapis.com/css?family='.$style1_google_font.');
			</style>
		<div style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;" class="'.$hover_item_show.'">
						<div class="royal-item">
							<div style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;" class="'.$seclect_circle_effects_border.' royal-hov-content '.$css3_hover_layout.' royal-overtrans-animation '.$css3_hover_animation.'">
								<span class="royal-image">
									<img src="'.$style1_option['style1_image_upload'].'" alt="Hover Image">
								</span>
								<span style="background:'.$backg_color.';" class="info-box text-center padding-20px">

									<span class="rdvib-center">
										<h2 style="color: '.$title_color.'; font-size:'.$title_font_size.'px; font-family:'.$style1_google_font.';">'.$style1_option['put_style1_title'].'</h2>
										<small class="separator"></small>
										<p style="color: '.$descript_color.'; font-size:'.$descript_font_size.'px;">'.$style1_option['put_style1_description'].'</p>
										<small class="separator"></small>
										<!-- Social Media Icons -->
										<span class="social-media padding-bottom-10px">
	<a href="'.$style1_option['first_social_icon_link'].'" ><i class="fa '.$style1_option['first_social_icon_choser'].' fa-lg margin-right-5px"></i></a>
	<a href="'.$style1_option['second_social_icon_link'].'"><i class="fa '.$style1_option['second_social_icon_choser'].' fa-lg margin-right-5px"></i></a>
	<a href="'.$style1_option['third_social_icon_link'].'"><i class="fa '.$style1_option['third_social_icon_choser'].' fa-lg margin-right-5px"></i></a>
    <a href="'.$style1_option['fourth_social_icon_link'].'"><i class="fa '.$style1_option['fourth_social_icon_choser'].' fa-lg"></i></a>
										</span>
									</span>

								</span>
							</div>
						</div>
					</div>
				';
			}
			
		if ($select_hover_effects=="effects4") {
		$output .= '
			<style type="text/css">
			@import url(https://fonts.googleapis.com/css?family='.$style1_google_font.');
			</style>
		<div style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;" class="'.$hover_item_show.'">
						<div class="royal-item">
							<div style="-webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;" class="'.$seclect_circle_effects_border.' royal-hov-content '.$css3_hover_layout.' royal-zoom-out-animation '.$css3_hover_animation.'">
								<span class="royal-image">
									<img src="'.$style1_option['style1_image_upload'].'" alt="Hover Image">
								</span>
								<span style="background:'.$backg_color.';" class="info-box text-center padding-20px">

									<span class="rdvib-center">
										<h2 style="color: '.$title_color.'; font-size:'.$title_font_size.'px; font-family:'.$style1_google_font.';">'.$style1_option['put_style1_title'].'</h2>
										<small class="separator"></small>
										<p style="color: '.$descript_color.'; font-size:'.$descript_font_size.'px;">'.$style1_option['put_style1_description'].'</p>
										<small class="separator"></small>
										<!-- Social Media Icons -->
										<span class="social-media padding-bottom-10px">
	<a href="'.$style1_option['first_social_icon_link'].'" ><i class="fa '.$style1_option['first_social_icon_choser'].' fa-lg margin-right-5px"></i></a>
	<a href="'.$style1_option['second_social_icon_link'].'"><i class="fa '.$style1_option['second_social_icon_choser'].' fa-lg margin-right-5px"></i></a>
	<a href="'.$style1_option['third_social_icon_link'].'"><i class="fa '.$style1_option['third_social_icon_choser'].' fa-lg margin-right-5px"></i></a>
    <a href="'.$style1_option['fourth_social_icon_link'].'"><i class="fa '.$style1_option['fourth_social_icon_choser'].' fa-lg"></i></a>
										</span>
									</span>

								</span>
							</div>
						</div>
					</div>
				';
			}	
		if ($select_hover_effects=="effects5" || $select_hover_effects =="effects6" || $select_hover_effects=="effects7" || $select_hover_effects=="effects8" || $select_hover_effects=="effects9" || $select_hover_effects=="effects10" || $select_hover_effects=="effects11") {
		$output .= '
				<h1 style="color: red; ">SORRY THIS EFFECTS ONLY FOR PRO VERSION. IF YOU WANT TO BUY ROYAL IMAGE HOVER EFFECTS PRO VERSION TO GET AWESOME FEATURES PLEASE <a style="color: blue;" target="_blink" href="http://codecans.com/items/royal-image-hover-effects-pro/">CLICK HERE</a></h1>
				';
			}			
		$i++;
	}
		$output .='</div></main>';	

	
	endwhile;
	wp_reset_query();
	return $output;
}
add_shortcode('vbs_style1', 'css3_image_hover_effects_style1_shortcode');	

?>