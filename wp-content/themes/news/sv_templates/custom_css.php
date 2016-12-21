<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 13/08/15
 * Time: 10:20 AM
 */
$main_color = sv_get_option('main_color');
?>
<?php
$style = '';

/*****BEGIN MAIN COLOR*****/
if(!empty($main_color)){
	$style .= '.main-color
    {color:'.$main_color.'}'."\n";
    
    $style .= '.main-background
    {background-color:'.$main_color.'}'."\n";

    $style .= '.main-border
    {border: 1px solid '.$main_color.'}'."\n";
}
/*****END MAIN COLOR*****/

/*****BEGIN CUSTOM CSS*****/
$custom_css = sv_get_option('custom_css');
if(!empty($custom_css)){
    $style .= $custom_css."\n";
}

/*****END CUSTOM CSS*****/

/*****BEGIN MENU COLOR*****/
$menu_color = sv_get_option('sv_menu_color');
$menu_hover = sv_get_option('sv_menu_color_hover');
$menu_active = sv_get_option('sv_menu_color_active');
if(is_array($menu_color) && !empty($menu_color)){
    $style .= 'nav>li>a{';
    if(!empty($menu_color['font-color'])) $style .= 'color:'.$menu_color['font-color'].';';
    if(!empty($menu_color['font-family'])) $style .= 'font-family:'.$menu_color['font-family'].';';
    if(!empty($menu_color['font-size'])) $style .= 'font-size:'.$menu_color['font-size'].';';
    if(!empty($menu_color['font-style'])) $style .= 'font-style:'.$menu_color['font-style'].';';
    if(!empty($menu_color['font-variant'])) $style .= 'font-variant:'.$menu_color['font-variant'].';';
    if(!empty($menu_color['font-weight'])) $style .= 'font-weight:'.$menu_color['font-weight'].';';
    if(!empty($menu_color['letter-spacing'])) $style .= 'letter-spacing:'.$menu_color['letter-spacing'].';';
    if(!empty($menu_color['line-height'])) $style .= 'line-height:'.$menu_color['line-height'].';';
    if(!empty($menu_color['text-decoration'])) $style .= 'text-decoration:'.$menu_color['text-decoration'].';';
    if(!empty($menu_color['text-transform'])) $style .= 'text-transform:'.$menu_color['text-transform'].';';
    $style .= '}'."\n";
}
if(!empty($menu_hover)){
    $style .= 'nav>li>a:hover{color:'.$menu_hover.'}'."\n";
    $style .= 'nav>li>a:hover{background-color:'.$menu_hover.'}'."\n";
}
if(!empty($menu_active)){
    $style .= 'nav li.parent-current-menu-item>a{color:'.$menu_active.'}'."\n";
    $style .= 'nav li.current-menu-item >a{background-color:'.$menu_active.'}'."\n";
}

/*****END MENU COLOR*****/

/*****BEGIN TYPOGRAPHY*****/
$typo_data = sv_get_option('sv_custom_typography');
if(is_array($typo_data) && !empty($typo_data)){
    foreach ($typo_data as $value) {
        switch ($value['typo_area']) {
            case 'header':
                $style_class = '.site-header';
                break;

            case 'footer':
                $style_class = '.site-footer';
                break;

            case 'widget':
                $style_class = '.widget';
                break;
            
            default:
                $style_class = '#main-content';
                break;
        }
        $class_array = explode(',', $style_class);
        $new_class = '';
        if(is_array($class_array)){
            foreach ($class_array as $prefix) {
                $new_class .= $prefix.' '.$value['typo_heading'].',';
            }
        }
        if(!empty($new_class)) $style .= $new_class.' .nocss{';
        if(!empty($value['typography_style']['font-color'])) $style .= 'color:'.$value['typography_style']['font-color'].';';
        if(!empty($value['typography_style']['font-family'])) $style .= 'font-family:'.$value['typography_style']['font-family'].';';
        if(!empty($value['typography_style']['font-size'])) $style .= 'font-size:'.$value['typography_style']['font-size'].';';
        if(!empty($value['typography_style']['font-style'])) $style .= 'font-style:'.$value['typography_style']['font-style'].';';
        if(!empty($value['typography_style']['font-variant'])) $style .= 'font-variant:'.$value['typography_style']['font-variant'].';';
        if(!empty($value['typography_style']['font-weight'])) $style .= 'font-weight:'.$value['typography_style']['font-weight'].';';
        if(!empty($value['typography_style']['letter-spacing'])) $style .= 'letter-spacing:'.$value['typography_style']['letter-spacing'].';';
        if(!empty($value['typography_style']['line-height'])) $style .= 'line-height:'.$value['typography_style']['line-height'].';';
        if(!empty($value['typography_style']['text-decoration'])) $style .= 'text-decoration:'.$value['typography_style']['text-decoration'].';';
        if(!empty($value['typography_style']['text-transform'])) $style .= 'text-transform:'.$value['typography_style']['text-transform'].';';
        $style .= '}';
        $style .= "\n";
    }
}
/*****END TYPOGRAPHY*****/
if(!empty($style)) print $style;
?>