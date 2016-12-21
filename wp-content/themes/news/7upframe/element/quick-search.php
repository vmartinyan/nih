<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_q_search'))
{
    function sv_vc_q_search($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'title'      => '',
            'style'      => '',
        ),$attr));
        $char = 'a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z';
        $char_array = explode(',', $char);
        $html .=    '<div class="quick-search">
                        <label>'.$title.'</label>';
                        foreach ($char_array as $value) {
                            $html .= '<a href="'.esc_url(get_home_url('/')).'?s='.$value.'&amp;post_type=post">'.$value.'</a>';
                        }
        $html .=    '</div>';
        return $html;
    }
}

stp_reg_shortcode('sv_q_search','sv_vc_q_search');

vc_map( array(
    "name"      => esc_html__("SV Quick Search", 'news'),
    "base"      => "sv_q_search",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Title",'news'),
            "param_name" => "title",
        ),
    )
));