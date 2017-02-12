<?php
/**
* Plugin Name: Cactus Info Slider
* Plugin URI: http://happycactusdev.com/info-slider
* Description: Info Slider is for users who want a step-by-step set of slides to explain a process.  Each slide contains text (on the left) and an image (on the right).  Sliding functionality is from the Unslider.js library.
* Version: 1.0
* Author: Happy Cactus Dev
* Author URI: http://happycactusdev.com
* License: GPL2
*/

add_action('wp_enqueue_scripts', 'cacslide_register_externals');
add_shortcode('cactus-slider', 'cacslide_slider_setup');
add_shortcode('slider-item', 'cacslide_add_slider_item');

// Adds CSS & JS to plugin
function cacslide_register_externals() {
	wp_enqueue_style('info-slider', plugins_url( 'css/info-slider.css', __FILE__));
	wp_enqueue_script('unslider', plugins_url( 'js/unslider.min.js', __FILE__), array( 'jquery' ));
	wp_enqueue_script('infoslider', plugins_url( 'js/infoslider.js', __FILE__));
}

function cacslide_slider_setup($atts, $content=null) {
	$output = do_shortcode($content);
	return '<div class="slider-container"><ul>'.$output.'</ul></div>
			<br><br>
			<button class="unslider-arrow prev"><< Previous</button>
			<button class="unslider-arrow next">Next >></button>';
}

// Creates single slide
function cacslide_add_slider_item($atts, $content=null) {
	extract(
		shortcode_atts( 
			array(
				"nbr" => 1,
				"title" => null,
				"img" => null), 
			$atts));

	$output = '<li class="slider-container-li">';
	$output .= '<div class="info"><h2>'.$title.'</h2><p>'.$content.'</p></div>';
	$output .= '<div class="image"><img src="'.$img.'"></div>';
	$output .= '</li>';

	return $output;
}