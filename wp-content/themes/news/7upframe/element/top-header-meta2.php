<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 22/01/16
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_top_meta2'))
{
    function sv_vc_top_meta2($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'search_show'      => '',
            'control_box'      => '',
            'icon'      => '',
            'label'      => '',
            'link'      => '',
            'login_text'      => esc_html__('Login','news'),
            'register_text'   => esc_html__('Register','news'),
        ),$attr));
        $icon_html = '';
        if(!empty($icon)){
            if(strpos($icon,'lnr') !== false) $icon_html = '<span class="lnr '.$icon.'"></span>';
            else $icon_html =   '<i class="fa '.$icon.'"></i>';
        }
        ob_start();
            $search_val = get_search_query();
            ?>
            <form class="header-search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <input type="text" name="s" value="<?php echo esc_attr($search_val);?>" class="header-input-search">
                <a href="#" class="header-btn-search"><span class="lnr lnr-magnifier"></span> <?php esc_html_e("Search","news")?></a>
            </form>
        <?php
        $search_html = ob_get_clean();
            $html .=    '<div class="header-info pull-right">
                            <div class="header-info-search">
                                <a href="'.esc_url($link).'" class="header-btn-video">'.$icon_html.' '.$label.'</a>
                                '.$search_html.'
                            </div>
                            <div class="header-info-login">
                                <a href="'.esc_url(wp_login_url()).'" class="header-btn-signin"><span class="lnr lnr-user"></span> '.$login_text.'</a>
                                <a href="'.esc_url(wp_registration_url()).'" class="header-btn-join"><span class="lnr lnr-lock"></span> '.$register_text.'</a>
                            </div>
                        </div>';
        return $html;
    }
}

stp_reg_shortcode('sv_top_meta2','sv_vc_top_meta2');

vc_map( array(
    "name"      => esc_html__("SV Top Header meta 2", 'news'),
    "base"      => "sv_top_meta2",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "checkbox",
            "heading" => esc_html__("Show Search Form",'news'),
            "param_name" => "search_show",            
        ),
        array(
            "type" => "checkbox",
            "heading" => esc_html__("Show Control Button",'news'),
            "param_name" => "control_box",            
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extral label",'news'),
            "param_name" => "label",            
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extral link",'news'),
            "param_name" => "link",            
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extral icon",'news'),
            "param_name" => "icon",
            'edit_field_class'=>'vc_col-sm-12 vc_column sv_iconpicker'           
        ),
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Login Text",'news'),
            "param_name" => "login_text",
        ),
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Register Text",'news'),
            "param_name" => "register_text",
        )
    )
));