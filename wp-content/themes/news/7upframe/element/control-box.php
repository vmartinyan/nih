<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 22/01/16
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_control_box'))
{
    function sv_vc_control_box($attr)
    {
        $html = $logo = '';
        extract(shortcode_atts(array(
            'style'      => 'style-1',
            'align'      => 'left',
            'login_text'      => 'Login',
            'register_text'   => 'Register',
        ),$attr));
        switch ($style) {
            case 'style-3':
                $html .=    '<div class="register-login '.$align.'">
                                <a href="'.esc_url(wp_login_url()).'" class="login-link">'.$login_text.' <span class="lnr lnr-chevron-right-circle"></span></a>
                                <a href="'.esc_url(wp_registration_url()).'" class="register-link">'.$register_text.' <span class="lnr lnr-chevron-right-circle"></span></a>
                            </div>';
                break;

            case 'style-2':
                $html .=    '<div class="event-login-footer '.$align.'">
                                <a href="'.esc_url(wp_login_url()).'">'.$login_text.'</a>
                                <a href="'.esc_url(wp_registration_url()).'">'.$register_text.'</a>
                            </div>';
                break;
            
            default:
                $html .=    '<div class="header-info-login '.$align.'">
                                <a href="'.esc_url(wp_login_url()).'" class="header-btn-signin"><span class="lnr lnr-user"></span> '.$login_text.'</a>
                                <a href="'.esc_url(wp_registration_url()).'" class="header-btn-join"><span class="lnr lnr-lock"></span> '.$register_text.'</a>
                            </div>';
                break;
        }
        return $html;
    }
}

stp_reg_shortcode('sv_control_box','sv_vc_control_box');

vc_map( array(
    "name"      => esc_html__("SV Control Box", 'news'),
    "base"      => "sv_control_box",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Style', 'news' ),
            'param_name'  => 'style',
            'value'       => array(
                esc_html__( 'Style 1', 'news' )   => 'style-1',
                esc_html__( 'Style 2(Event page)', 'news' )   => 'style-2',
                esc_html__( 'Style 3(Home shop)', 'news' )   => 'style-3',
                )
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Align', 'news' ),
            'param_name'  => 'align',
            'value'       => array(
                esc_html__( 'Left', 'news' )   => 'text-left',
                esc_html__( 'Right', 'news' )   => 'text-right',
                esc_html__( 'Center', 'news' )   => 'text-center',
                )
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