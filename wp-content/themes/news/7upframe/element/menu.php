<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 18/08/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_menu'))
{
    function sv_vc_menu($attr,$content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'     => 'main-nav',
            'menu'      => '',
        ),$attr));
        $el_wrap = $style;$ul_class = 'main-menu';
        $menu_res_html = '<div class="mobile-menu">
                            <span class="mobile-menu-text">'.esc_html__("Menu","news").'</span>
                            <a href="#" class="btn-mobile-menu"><span class="lnr lnr-menu"></span></a>
                        </div>';
        if($style == 'event-top-menu' || $style == 'event-top-menu top-menu4' || $style == 'event-top-menu top-menu5'){
            $el_wrap = '';$ul_class = $style;
            $menu_res_html = '';
        }
        if(!empty($menu)){
            $html .= '<div class="'.$el_wrap.'">';
                ob_start();
                wp_nav_menu( array(
                    'menu' => $menu,
                    'container'=>false,
                    'walker'=>new SV_Walker_Nav_Menu(),
                    'menu_class'=> $ul_class.' newday-menu',
                ));
            $html .= @ob_get_clean();
            $html .= $menu_res_html;
            $html .= '</div>';
        }
        else{
            $html .= '<div class="'.$el_wrap.'">';
                ob_start();
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'=>false,
                    'walker'=>new SV_Walker_Nav_Menu(),
                    'menu_class'=> $ul_class.' newday-menu',
                ));
            $html .= @ob_get_clean();
            $html .= '<div class="mobile-menu">
                        <span class="mobile-menu-text">'.esc_html__("Menu","news").'</span>
                        <a href="#" class="btn-mobile-menu"><span class="lnr lnr-menu"></span></a>
                    </div>';
            $html .= '</div>';
        }        
        return $html;
    }
}

stp_reg_shortcode('sv_menu','sv_vc_menu');

vc_map( array(
    "name"      => esc_html__("SV Menu", 'news'),
    "base"      => "sv_menu",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(        
        array(
            'type' => 'dropdown',
            'holder' => 'div',
            'heading' => esc_html__( 'Menu name', 'news' ),
            'param_name' => 'menu',
            'value' => sv_list_menu_name(),
            'description' => esc_html__( 'Select Menu name to display', 'news' )
        ),
    )
));