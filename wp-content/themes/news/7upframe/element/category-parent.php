<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 05/09/15
 * Time: 10:00 AM
 */
if(class_exists("woocommerce")){
if(!function_exists('sv_vc_category_parent'))
{
    function sv_vc_category_parent($attr, $content = false)
    {
        $html = $el_class = $html_wl = $html_cp = '';
        extract(shortcode_atts(array(
            'cats'          => '',
            'position'      => 'none',
        ),$attr));
        if(!empty($cats)){
            $pre = rand(0,1000);
            $tabs = explode(',', $cats);
            $tab_html = $content_html = '';
            foreach ($tabs as $key => $tab) {
                $f_class = '';
                if($key == 0) $f_class = 'active';
                $term = get_term_by( 'slug',$tab, 'product_cat' );
                $tab_html .= '<a data-slide-index="'.$key.'" href="#">'.$term->name.'</a>';
                $term_childrents = get_term_children( $term->term_id, 'product_cat' );
                $term_childrent = $thumbnail_id = '';
                if(isset($term_childrents[0])){
                    $term_childrent = get_term_by( 'id',$term_childrents[0], 'product_cat' );
                    $term_childrent_link = get_term_link( $term_childrent, 'product_cat' );
                    $thumbnail_id = get_woocommerce_term_meta( $term_childrent->term_id, 'thumbnail_id', true );
                    $content_html .=    '<li>
                                            <div class="tab-category-thumb">
                                                <a href="'.esc_url($term_childrent_link).'" class="tab-category-link">
                                                    '.wp_get_attachment_image($thumbnail_id,'full').'
                                                </a>
                                                <div class="info-tab-cat-thumb">
                                                    <h2>'.$term_childrent->name.'</h2>
                                                </div>
                                            </div>
                                            <div class="tab-category-info">
                                                <p>'.$term_childrent->description.'</p>
                                            </div>
                                        </li>';
                }                
            }
            $html .=    '<div class="item-tab-category item-'.$position.'">
                            <ul class="bxslider-cate">
                                '.$content_html.'
                            </ul>
                            <div class="bx-pager-tab" id="bx-pager-'.$pre.'">
                                '.$tab_html.'
                            </div>
                        </div>';
        }
        return $html;
    }
}

stp_reg_shortcode('sv_category_parent','sv_vc_category_parent');
add_action( 'vc_build_admin_page','sv_add_category_parent',10,100 );
if ( ! function_exists( 'sv_add_category_parent' ) ) {
    function sv_add_category_parent(){
        vc_map( array(
            "name"      => esc_html__("SV Product Category Parent", 'news'),
            "base"      => "sv_category_parent",
            "icon"      => "icon-st",
            "category"  => '7Up-theme',
            "params"    => array(                
                array(
                    'holder'     => 'div',
                    'heading'     => esc_html__( 'Product Categories', 'news' ),
                    'type'        => 'checkbox',
                    'param_name'  => 'cats',
                    'value'       => sv_list_taxonomy('product_cat',false)
                ),
                array(
                    'heading'     => esc_html__( 'Position', 'news' ),
                    'type'        => 'dropdown',
                    'param_name'  => 'position',
                    'value'       => array(
                        esc_html__("None", 'news')  => 'none',
                        esc_html__("Left", 'news')  => 'left',
                        esc_html__("Right", 'news')  => 'right',
                        )
                ),
            )
        ));
    }
}
}