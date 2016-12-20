<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_search_form'))
{
    function sv_vc_search_form($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style' => 'search-form',
        ),$attr));        
        ob_start();
        switch ($style) {
            case 'header-search7':
                $search_val = get_search_query();
                if(empty($search_val)){
                    $search_val = esc_html__("Search","news");
                }
                ?>
                <div class="search-form-7">
                    <form>
                        <input type="text" name="s" value="<?php echo esc_attr($search_val);?>" onfocus="if (this.value==this.defaultValue) this.value = ''" onblur="if (this.value=='') this.value = this.defaultValue">
                        <input type="submit" value="">
                    </form> 
                </div>
                <?php
                break;

            case 'header-search6':
                ?>
                <div class="header-search6">
                    <a href="#" class="btn-header-search"><span class="lnr lnr-magnifier"></span></a>
                    <form method="get" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
                        <input class="input-header-search" type="text" name="s" id="s" value="<?php echo get_search_query() ?>">
                    </form>
                </div>
                <?php
                break;
            
            default:
                $search_val = get_search_query();
                if(empty($search_val)){
                    $search_val = esc_html__("search","news");
                }
                ?>
                <div class="<?php echo esc_attr($style)?>">
                    <form method="get" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
                        <input type="text" name="s" value="<?php echo esc_attr($search_val);?>" onfocus="if (this.value==this.defaultValue) this.value = ''" onblur="if (this.value=='') this.value = this.defaultValue">
                        <input class="btn-link-default" type="submit" value="">
                    </form>
                </div>
                <?php
                        break;
                }        
        $html .=    ob_get_clean();
        return $html;
    }
}

stp_reg_shortcode('sv_search_form','sv_vc_search_form');

vc_map( array(
    "name"      => esc_html__("SV Search Form", 'news'),
    "base"      => "sv_search_form",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type"          => "dropdown",
            "holder"        => "div",
            "heading"       => esc_html__("Style",'news'),
            "param_name"    => "style",
            "value"         => array(
                esc_html__("Default","news")    => 'search-form',
                esc_html__("Search Header 2","news")    => 'search-form2',
                esc_html__("Search Header 6","news")    => 'header-search6',
                esc_html__("Search Header 7","news")    => 'header-search7',
                ),
            'description'   => esc_html__( 'Choose style to display.', 'news' ),
        ),
    )
));