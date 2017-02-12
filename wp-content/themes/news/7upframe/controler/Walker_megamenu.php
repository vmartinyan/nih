<?php
class SV_Walker_Nav_Menu extends Walker_Nav_Menu {  

	// add classes to ul sub-menus

	function start_lvl( &$output, $depth = 0, $args = array() ) {

	    // depth dependent classes
	    $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
	    $display_depth = ( $depth + 1); // because it counts the first submenu as 0
	    $classes = array(
	        'sub-menu',
	        ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
	        ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
	        'menu-depth-' . $display_depth
	        );

	    $class_names = implode( ' ', $classes );
	  	
	  	// if($display_depth > 1) $class_names .= ' dropdown-menu';

	    // build html
	    $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";

	}  

	// add main/sub classes to li's and links
 	function start_el(  &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	    global $wp_query;
	    $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

	  	// get metabox value
	  	$icon = $enable_megamenu = $content = $background_url = $col_size = '';
	  	$enable_megamenu 	= get_post_meta($item->ID,'enable_megamenu',true);
	  	$enable_megamenu123 = get_post_meta($item->ID,'enable_megamenu123',true);
	  	$icon 				= get_post_meta($item->ID,'icon_menu'.$depth,true);
	  	$content 			= get_post_meta($item->ID,'content'.$depth,true);
	  	$col_size 			= get_post_meta($item->ID,'col_size',true);
	  	if($col_size == '0') $col_size = '12';
	  	$col_class = 'col-md-'.$col_size;
	  	if($col_size < '6') $col_class .= ' col-sm-6';
	  	$icon_html = $icon ? '<i class="fa '.$icon.'"></i>':'';
	  	$mega_menu = false;
	  	if(!empty($icon) || !empty($content)) $mega_menu = true;
	    // depth dependent classes

	    $depth_classes = array(
	        ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
	        ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
	        ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
	        'menu-item-depth-' . $depth
	    );

	    $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
	  	if(($enable_megamenu || $enable_megamenu123) && $depth == 0) $depth_class_names .= ' has-mega-menu light';
	    // passed classes

	    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
	    $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
	  	// $class_names = str_replace('menu-item-has-children', 'menu-item-has-children parentMenu menu', $class_names);	  	

	    // link attributes
	    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
	    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
	    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
	    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_url( $item->url        ) .'"' : '';
	    $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';	  

	    $item_output = sprintf( '%1$s<a%2$s>'.$icon_html.'%3$s%4$s%5$s</a>%6$s',
	        $args->before,
	        $attributes,
	        $args->link_before,
	        apply_filters( 'the_title', $item->title, $item->ID ),
	        $args->link_after,
	        $args->after
	    );

  		// build html

  		// var_dump(apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args ));

	    if($mega_menu){
	    	$content = str_replace('../wp-content', esc_url(get_home_url('/')).'/wp-content', $content);
	    	if($depth == 1){
	    		if(empty($content)) {
	    			$output .= '<li class="'.$col_class.' ' . $class_names . '">';
					$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	    		}
	    		else {
	    			$output .= '<li class="'.$col_class.'">';
	    			//$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	    			$output .= '<div class="mega-menu-content">'.apply_filters( 'the_content',$content).'</div>';
	    			// $output .= '</li>';
	    		}
	    	}

	    	if($depth == 2) {
	    		$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
	    		if(empty($content)) $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	    		else {
	    			$output .= '<div class="mega-menu-content">'.apply_filters( 'the_content',$content).'</div>';
	    		}
	    	}
	    }	

	    else {
	    	$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
	    	$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	    }

	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$icon 				= get_post_meta($item->ID,'icon_menu'.$depth,true);
	  	$content 			= get_post_meta($item->ID,'content'.$depth,true);
	  	$mega_menu = false;
	  	if(!empty($icon) || !empty($content)) $mega_menu = true;
	  	if($mega_menu){
	  		if($depth == 1 && empty($content)) $output .= "</li>\n";
	  		else $output .= "</li>\n";
	  	}
        else $output .= "</li>\n";
    }

}

?>