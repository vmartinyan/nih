<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 22/01/16
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_top_meta'))
{
    function sv_vc_top_meta($attr)
    {
        $html = $el_search = $el_social = '';
        extract(shortcode_atts(array(
            'color'      => '',
            'search_show'      => '',
            'social'      => '',
        ),$attr));
        parse_str( urldecode( $social ), $data);
        if($color == 'header-blue'){
            $el_search = 'btn-search4';
            $el_social = 'top-social4';
        }
        if($color == 'header-orange2'){
            $el_search = 'btn-search5';
            $el_social = 'top-social5';
        }
        ob_start();
            $search_val = get_search_query();
            if(empty($search_val)){
                $search_val = esc_html__("[:hy]Որոնել[:en]Search","news");
            }?>
            <form class="event-form-search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <input type="text" name="s" value="<?php echo esc_attr($search_val);?>" onfocus="if (this.value==this.defaultValue) this.value = ''" onblur="if (this.value=='') this.value = this.defaultValue">
            </form>
        <?php
        $search_html = ob_get_clean();
        $html .=    '<div class="wrap-social-search">';
        if($search_show){
            $html .=    '<div class="event-top-search clearfix">
                            '.$search_html.'
                            <a href="#" class="event-btn-search '.$el_search.'"><span class="lnr lnr-magnifier"></span></a>
                        </div>';
        }        
        if(is_array($data)){
            $html .=    '<div class="event-top-social '.$el_social.' clearfix">';
            foreach ($data as $key => $value) {
                $url = '#';
                if(isset($value['url'])) $url = $value['url'];
                $html .=    '<a href="'.esc_url($url).'"><i class="fa '.$value['social'].'"></i></a>';
            }
            $html .=    '</div>';            
        }
        $html .=    '</div>';
        return $html;
    }
}

stp_reg_shortcode('sv_top_meta','sv_vc_top_meta');

vc_map( array(
    "name"      => esc_html__("SV Top Header meta", 'news'),
    "base"      => "sv_top_meta",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Color",'news'),
            "param_name" => "color",
            "value"     => array(
                esc_html__("Orange",'news')  => '',
                esc_html__("Blue",'news')  => 'header-blue',
                esc_html__("Orange 2",'news')  => 'header-orange2',
                )
        ),
        array(
            "type" => "checkbox",
            "heading" => esc_html__("Show Search Form",'news'),
            "param_name" => "search_show",            
        ),
        array(
            "type" => "add_social",
            "heading" => esc_html__("Social",'news'),
            "param_name" => "social",            
        )
    )
));