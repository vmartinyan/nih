<?php
/**
 * The EGW Hover Effects Widget.
 *
 * Copy this template to /egw-hover-effects-widget/widget.php in your theme or
 * child theme to make edits.
 *
 */
// Image is set?
if ( $instance['src'] != '' ) {
		$img = '<img src="' . $instance['src'] . '"  style="width:100%; height=100%"';
	// Alt for image.
	if($instance['title']!=""){
		$img .= 'alt="' . esc_attr( $instance['title'] ) . '" title="' .  esc_attr( $instance['title'] ) . '" ';
	}
	// Dynamic Class for image.
	if($instance['get_bg_effects']!=""){
		$img .= 'class="' . esc_attr( $instance['get_bg_effects'] ) . '"';
	}
	$img .= '/>';
}

//Create Captions
if($instance['title']!="" ||  $instance['text']){
	$captions='<a style="';
	// padding Set?
	if($instance['padding']!=""){
		$captions.='padding:' . esc_attr( $instance['padding'] ) .'px; ';
	}
	// background Color And disable opacity Set?
	if($instance['captions_bg_color']!="" && $instance['disable_opacity']==""){
		$captions.='background: rgba(' . $this->hex2RGB(esc_attr( $instance['captions_bg_color'] )) . ',0.5) ; ';
	}else{
		$captions.='background:#'.esc_attr( $instance['captions_bg_color']).'; ';
	}
	// Text color Set?
	if($instance['text_color']!=""){
		$captions.='color:#' . esc_attr( $instance['text_color'] ) .'; ';
	}
	// Text color Set?
	if($instance['text_size']!=""){
		$captions.='font-size:' . esc_attr( $instance['text_size'] ) .'px;';
	}
	
	$captions .='"';
	//Captions effects Set?
	if($instance['captions_effects']!=""){
		$captions .='class="mask ' . esc_attr( $instance['captions_effects'] ) .'"';
	}
	// Linked?
	if ( $instance['url'] != '' ) {
		$captions .= 'href="' . esc_attr($instance['url'] ) . '" ';
		if ( $instance['new_window'] != '' ) {
			$captions .= 'target="_blank"';
		} 
	}
	$captions .='>';
	
	// title color Set?
	if($instance['text_color']!=""){
		$title_style .=' color: #' . esc_attr( $instance['title_color'] ) .';';
	}
	// title color Set?
	if($instance['title_size']!=""){
		$title_style .='font-size:' . esc_attr( $instance['title_size'] ) .'px;';
	}
		$captions .='<h2 style="'.$title_style.'">' . esc_attr( $instance['title'] ) . '</h2>
			' . esc_attr( $instance['text'] ) . '';
		$captions .='</a>';	
}
//Widget Style
$widget .='style="';
	// font-family Set?
	if($instance['fonts_family']!=""){
		$widget .='font-family:' . esc_attr( $instance['fonts_family'] ) .';';
	}
	/*border color & border width Set ?*/
	if($instance['border_color']!="" && $instance['border_width']!=""){
		$widget .=' border:'.esc_attr( $instance['border_width'] ).'px solid #'.esc_attr( $instance['border_color'] ).';';
	}
	if($instance['width']!=""){
		$widget .=' width:'.esc_attr( $instance['width'] ).'px;';
	}
	if($instance['width']!=""){
		$widget .=' height:'.esc_attr( $instance['height'] ).'px;';
	}
$widget .='"';
$widget .='class="egw-widget ';
	// font-family Set?
	if($instance['custom_css']!=""){
		$widget .= esc_attr( $instance['custom_css'] );
	}
	// widge_style Set?
	if($instance['widge_style']!=""){
		$widget .=' '.esc_attr( $instance['widge_style'] );
	}		
$widget .='"';
?>
<div <?php echo $widget;?>>
	<?php
	// Disable captions?
	if($instance['disable_captions']!=""){
		 echo $img;
	}else{
		 echo $img.$captions;
	}
	?>
</div>
