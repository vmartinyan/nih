<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
 
/******************************************Core Function******************************************/
//Get option
if(!function_exists('sv_get_option')){
	function sv_get_option($key,$default=NULL)
    {
        if(function_exists('ot_get_option'))
        {
            return ot_get_option($key,$default);
        }

        return $default;
    }
}

//Get list header page
if(!function_exists('sv_list_header_page'))
{
    function sv_list_header_page()
    {
        global $post;
        $page_list = array();
        $page_list[] = array(
            'value' => '',
            'label' => esc_html__('-- Choose One --','news')
        );
        $args= array(
        'post_type' => 'page',
        'posts_per_page' => -1, 
        );
        $query = new WP_Query($args);
        if($query->have_posts()): while ($query->have_posts()):$query->the_post();
            if (strpos($post->post_content, '[sv_logo') ||  strpos($post->post_content, '[sv_menu')) {
                $page_list[] = array(
                    'value' => $post->ID,
                    'label' => $post->post_title
                );
            }
            endwhile;
        endif;
        wp_reset_postdata();
        return $page_list;
    }
}

//Get list sidebar
if(!function_exists('sv_get_sidebar_ids'))
{
    function sv_get_sidebar_ids($for_optiontree=false)
    {
        global $wp_registered_sidebars;
        $r=array();
        $r[]=esc_html__('--Select--','news');
        if(!empty($wp_registered_sidebars)){
            foreach($wp_registered_sidebars as $key=>$value)
            {

                if($for_optiontree){
                    $r[]=array(
                        'value'=>$value['id'],
                        'label'=>$value['name']
                    );
                }else{
                    $r[$value['id']]=$value['name'];
                }
            }
        }
        return $r;
    }
}

//Get order list
if(!function_exists('sv_get_order_list'))
{
    function sv_get_order_list($extra=array())
    {
        $default = array(
            esc_html__('None','news')               => 'none',
            esc_html__('Post ID','news')            => 'ID',
            esc_html__('Author','news')             => 'author',
            esc_html__('Post Title','news')         => 'title',
            esc_html__('Post Name','news')          => 'name',
            esc_html__('Post Date','news')          => 'date',
            esc_html__('Last Modified Date','news') => 'modified',
            esc_html__('Post Parent','news')        => 'parent',
            esc_html__('Random','news')             => 'rand',
            esc_html__('Comment Count','news')      => 'comment_count',
            esc_html__('View Post','news')          => 'post_views',
            esc_html__('Like Post','news')          => '_post_like_count',       
        );

        if(!empty($extra) and is_array($extra))
        {
            $default=array_merge($default,$extra);
        }
        return $default;
    }
}

// Get sidebar
if(!function_exists('sv_get_sidebar'))
{
    function sv_get_sidebar()
    {
        $default=array(
            'position'=>'right',
            'id'      =>'blog-sidebar'
        );

        return apply_filters('sv_get_sidebar',$default);
    }
}

//Favicon
if(!function_exists('sv_load_favicon') )
{
    function sv_load_favicon()
    {
        $value = sv_get_option('favicon');
        $favicon = (isset($value) && !empty($value))?$value:false;
        if($favicon)
            echo '<link rel="Shortcut Icon" href="' . esc_url( $favicon ) . '" type="image/x-icon" />' . "\n";
    }
}
if(!function_exists( 'wp_site_icon' ) ){
    add_action( 'wp_head','sv_load_favicon');
    add_action('login_head', 'sv_load_favicon');
    add_action('admin_head', 'sv_load_favicon');
}

//Fill css background
if(!function_exists('sv_fill_css_background'))
{
    function sv_fill_css_background($data)
    {
        $string = '';
        if(!empty($data['background-color'])) $string .= 'background-color:'.$data['background-color'].' !important;'."\n";
        if(!empty($data['background-repeat'])) $string .= 'background-repeat:'.$data['background-repeat'].';'."\n";
        if(!empty($data['background-attachment'])) $string .= 'background-attachment:'.$data['background-attachment'].';'."\n";
        if(!empty($data['background-position'])) $string .= 'background-position:'.$data['background-position'].';'."\n";
        if(!empty($data['background-size'])) $string .= 'background-size:'.$data['background-size'].';'."\n";
        if(!empty($data['background-image'])) $string .= 'background-image:url("'.$data['background-image'].'");'."\n";
        if(!empty($string)) return SV_Assets::build_css($string);
        else return false;
    }
}

//Get class typography
if(!function_exists('sv_get_class_typography')){
    function sv_get_class_typography($data = ''){
        $style = '';
        if(is_array($data) && !empty($data)){
            if(!empty($data['font-color'])) $style .= 'color:'.$data['font-color'].' !important;';
            if(!empty($data['font-family'])) $style .= 'font-family:'.$data['font-family'].';';
            if(!empty($data['font-size'])) $style .= 'font-size:'.$data['font-size'].';';
            if(!empty($data['font-style'])) $style .= 'font-style:'.$data['font-style'].';';
            if(!empty($data['font-variant'])) $style .= 'font-variant:'.$data['font-variant'].';';
            if(!empty($data['font-weight'])) $style .= 'font-weight:'.$data['font-weight'].';';
            if(!empty($data['letter-spacing'])) $style .= 'letter-spacing:'.$data['letter-spacing'].';';
            if(!empty($data['line-height'])) $style .= 'line-height:'.$data['line-height'].';';
            if(!empty($data['text-decoration'])) $style .= 'text-decoration:'.$data['text-decoration'].';';
            if(!empty($data['text-transform'])) $style .= 'text-transform:'.$data['text-transform'].';';
        }
        if(!empty($style)) return SV_Assets::build_css($style);
        else return '';
    }
}

// Get list menu
if(!function_exists('sv_list_menu_name'))
{
    function sv_list_menu_name()
    {
        $menu_nav = wp_get_nav_menus();
        $menu_list = array('Default' => '');
        if(is_array($menu_nav) && !empty($menu_nav))
        {
            foreach($menu_nav as $item)
            { 
                if(is_object($item))
                {
                    $menu_list[$item->name] = $item->slug;
                }
            }
        }
        return $menu_list;
    }
}

//Display BreadCrumb
if(!function_exists('sv_display_breadcrumb'))
{
    function sv_display_breadcrumb()
    {
        $breadcrumb = sv_get_value_by_id('sv_show_breadrumb','on');
        if($breadcrumb == 'on'){ 
            $b_class = sv_fill_css_background(sv_get_option('sv_bg_breadcrumb'));
            ?>
            <div class="tp-breadcrumb <?php echo esc_attr($b_class)?>">
                <div class="container">
                    <div class="col-md-offset-3 col-md-5">
                        <div class="breadcrumb">
                        <?php 
                            if(function_exists('bcn_display')) bcn_display();
                            else sv_breadcrumb();
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
    }
}

//Custom BreadCrumb
if(!function_exists('sv_breadcrumb'))
{
    function sv_breadcrumb() {
        global $post;
        $year = 'Y';
        if (!is_home() || (is_home() && !is_front_page())) {
            echo '<a href="';
            echo esc_url(home_url('/'));
            echo '">';
            echo esc_html__('Home','news');
            echo '</a>'.' <span class="lnr lnr-chevron-right"></span> ';
            if(is_home() && !is_front_page()){
                echo '<span>'.esc_html__('Blog','news').'</span>'; 
            }
            if (is_category() || is_single()) {
                the_category(' <span class="lnr lnr-chevron-right"></span> ');
                if (is_single()) {
                    echo ' <span class="lnr lnr-chevron-right"></span><span> ';
                    the_title();
                    echo '</span>';
                }
            } elseif (is_page()) {
                if($post->post_parent){
                    $anc = get_post_ancestors( get_the_ID() );
                    $title = get_the_title();
                    foreach ( $anc as $ancestor ) {
                        $output = '<a href="'.esc_url(get_permalink($ancestor)).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a> <span class="lnr lnr-chevron-right"></span><span> ';
                    }
                    echo balanceTags($output);
                    echo '<span> '.$title.'</span>';
                } else {
                    echo '<span> '.get_the_title().'</span>';
                }
            }
        }
        elseif (is_tag()) {single_tag_title();}
        elseif (is_day()) {echo"<span>".esc_html_e("Archive for ","news"); the_time(get_option( 'date_format' )); echo'</span>';}
        elseif (is_month()) {echo"<span>".esc_html_e("Archive for ","news"); the_time('F, Y'); echo'</span>';}
        elseif (is_year()) {echo"<span>".esc_html_e("Archive for ","news"); the_time($year); echo'</span>';}
        elseif (is_author()) {echo"<span>".esc_html_e("Author Archive ","news"); echo'</span>';}
        elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<span>".esc_html_e("Blog Archives","news"); echo'</span>';}
        elseif (is_search()) {echo"<span>".esc_html_e("Search Results","news"); echo'</span>';}
    }
}

//Get page value by ID
if(!function_exists('sv_get_value_by_id'))
{   
    function sv_get_value_by_id($key)
    {
        if(!empty($key)){
            $id = get_the_ID();
            if(is_front_page() && is_home()) $id = (int)get_option( 'page_on_front' );
            if(!is_front_page() && is_home()) $id = (int)get_option( 'page_for_posts' );
            if(is_archive() || is_search()) $id = 0;
            $value = get_post_meta($id,$key,true);
            if(empty($value)) $value = sv_get_option($key);
            if($key == 'sv_header_page' || $key == 'sv_footer_page'){
                if ( is_tax( 'event_category' ) || is_page_template('event.php')) {
                    $value = sv_get_option($key.'_event');
                }
                if(isset($_GET['post_type'])){
                    if($_GET['post_type'] == 'event') $value = sv_get_option($key.'_event');
                }
                if(sv_is_woocommerce_page()){
                    $value = sv_get_option($key.'_woo');
                }
            }
            return $value;
        }
        else return 'Missing a variable of this funtion';
    }
}

//Check woocommerce page
if (!function_exists('sv_is_woocommerce_page')) {
    function sv_is_woocommerce_page() {
        if(  function_exists ( "is_woocommerce" ) && is_woocommerce()){
                return true;
        }
        $woocommerce_keys   =   array ( "woocommerce_shop_page_id" ,
                                        "woocommerce_terms_page_id" ,
                                        "woocommerce_cart_page_id" ,
                                        "woocommerce_checkout_page_id" ,
                                        "woocommerce_pay_page_id" ,
                                        "woocommerce_thanks_page_id" ,
                                        "woocommerce_myaccount_page_id" ,
                                        "woocommerce_edit_address_page_id" ,
                                        "woocommerce_view_order_page_id" ,
                                        "woocommerce_change_password_page_id" ,
                                        "woocommerce_logout_page_id" ,
                                        "woocommerce_lost_password_page_id" ) ;
        foreach ( $woocommerce_keys as $wc_page_id ) {
                if ( get_the_ID () == get_option ( $wc_page_id , 0 ) && get_the_ID() != '') {
                        return true ;
                }
        }
        return false;
    }
}

//navigation
if(!function_exists('sv_paging_nav'))
{
    function sv_paging_nav()
    {
        // Don't print empty markup if there's only one page.
        if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
            return;
        }

        $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
        $pagenum_link = html_entity_decode( get_pagenum_link() );
        $query_args   = array();
        $url_parts    = explode( '?', $pagenum_link );

        if ( isset( $url_parts[1] ) ) {
            wp_parse_str( $url_parts[1], $query_args );
        }

        $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
        $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

        $format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
        $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

        // Set up paginated links.
        $links = paginate_links( array(
            'base'     => $pagenum_link,
            'format'   => $format,
            'total'    => $GLOBALS['wp_query']->max_num_pages,
            'current'  => $paged,
            'mid_size' => 1,
            'type'     => 'plain',
            'add_args' => array_map( 'urlencode', $query_args ),
            'prev_text' => '<span class="lnr lnr-chevron-left"></span>',
            'next_text' =>  '<span class="lnr lnr-chevron-right"></span>',
        ) );

        if ($links) : ?>
            <div class="post-paginav2">
                <?php echo balanceTags($links); ?>
            </div>
        <?php endif;
    }
}
//event navigation
if(!function_exists('sv_paging_nav_event'))
{
    function sv_paging_nav_event($args = array(),$query_input = false)
    {
        // Don't print empty markup if there's only one page.
        if ( $GLOBALS['wp_query']->max_num_pages < 2 && $query_input === false) {
            return;
        }

        $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
        $pagenum_link = html_entity_decode( get_pagenum_link() );
        $query_args   = $args;
        $url_parts    = explode( '?', $pagenum_link );

        if ( isset( $url_parts[1] ) ) {
            wp_parse_str( $url_parts[1], $query_args );
        }

        $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
        $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

        $format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
        $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';
        $query = $GLOBALS['wp_query'];
        if($query_input) $query = $query_input;
        // Set up paginated links.
        if($query_input === false){
            $settings = array(
                'base'     => $pagenum_link,
                'format'   => $format,
                'total'    => $query->max_num_pages,
                'current'  => $paged,
                'mid_size' => 1,
                'type'     => 'list',
                'add_args' => array_map( 'urlencode', $query_args ),
                'prev_text' => '<span class="lnr lnr-chevron-left"></span>',
                'next_text' => '<span class="lnr lnr-chevron-right"></span>',
            );
        }
        else{
            $big = 999999999;
            $settings = array(
                'base'     => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format'   => '?paged=%#%',
                'total'    => $query->max_num_pages,
                'current'  => $paged,
                'mid_size' => 1,
                'type'     => 'list',
                // 'add_args' => array_map( 'urlencode', $query_args ),
                'prev_text' => '<span class="lnr lnr-chevron-left"></span>',
                'next_text' => '<span class="lnr lnr-chevron-right"></span>',
            );
        }
        $links = paginate_links( $settings );

        if ($links) : ?>
            <div class="list-event-paginav">
                <?php echo balanceTags($links); ?>
            </div>
        <?php endif;
    }
}
if(!function_exists('sv_set_post_view'))
{
    function sv_set_post_view($post_id=false)
    {
        if(!$post_id) $post_id=get_the_ID();

        $view=(int)get_post_meta($post_id,'post_views',true);
        $view++;
        update_post_meta($post_id,'post_views',$view);
    }
}

if(!function_exists('sv_get_post_view'))
{
    function sv_get_post_view($post_id=false)
    {
        if(!$post_id) $post_id=get_the_ID();

        return (int)get_post_meta($post_id,'post_views',true);
    }
}

//remove attr embed
if(!function_exists('sv_remove_w3c')){
    function sv_remove_w3c($embed_code,$width='640',$height='360'){
        $embed_code=str_replace('webkitallowfullscreen','',$embed_code);
        $embed_code=str_replace('mozallowfullscreen','',$embed_code);
        $embed_code=str_replace('frameborder="0"','',$embed_code);
        $embed_code=str_replace('frameborder="no"','',$embed_code);
        $embed_code=str_replace('scrolling="no"','',$embed_code);
        $embed_code=str_replace('&','&amp;',$embed_code);
        if($width != '640') $embed_code=str_replace('width="640"','width="'.$width.'"',$embed_code);
        if($height != '360') $embed_code=str_replace('height="360"','height="'.$height.'"',$embed_code);
        $embed_code=str_replace('" width','?byline=0&amp;portrait=0&amp;title=0" width',$embed_code);
        return $embed_code;
    }
}

// MetaBox
if(!function_exists('sv_display_metabox'))
{
    function sv_display_metabox($type ='') {        
    ?>
        <ul class="post-list-info-author list-inline">
            <li><?php esc_html_e("post by:","news")?> <a class="post-author" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php echo get_the_author(); ?></a></li>
            <li><?php the_time('F d, Y')?></li>
            <?php if(is_front_page() && is_home()):?>
            <li><?php esc_html_e('In', 'news');?>:
                <?php $cats = get_the_category_list(', ');?>
                <?php if($cats) echo balanceTags($cats); else _e("No Category",'news');?>
            </li>
            <li><?php esc_html_e('Tags', 'news');?>:
                <?php $cats = get_the_tag_list(' ',', ',' ');?>
                <?php if($cats) echo balanceTags($cats); else _e("No Tag",'news');?>
            </li>
            <?php endif;?>
        </ul>
    <?php
    }
}
/***************************************END Core Function***************************************/


/***************************************Add Theme Function***************************************/
// get list taxonomy
if(!function_exists('sv_list_taxonomy'))
{
    function sv_list_taxonomy($taxonomy,$show_all = true)
    {
        if($show_all) $list = array('--Select--' => '');
        else $list = array();
        if(!isset($taxonomy) || empty($taxonomy)) $taxonomy = 'category';
        $tags = get_terms($taxonomy);
        if(is_array($tags) && !empty($tags)){
            foreach ($tags as $tag) {
                $list[$tag->name] = $tag->slug;
            }
        }
        return $list;
    }
}
//Contact Form list
if(!function_exists('sv_get_list_ContactForm'))
{
    function sv_get_list_ContactForm()
    {
        $contact = array();
        if ( defined( 'WPCF7_VERSION' )){
            $querycontact = get_posts(array('post_type' => 'wpcf7_contact_form','posts_per_page' => -1));
            $contact['-- Select --'] = "";
            if(is_array($querycontact)) foreach ($querycontact as $post_ct) {
                $contact[$post_ct->post_title] = $post_ct->ID;
            }
        }
        return $contact;
    }
}
//List Post
if(!function_exists('sv_get_list_event_post')){
    function sv_get_list_event_post(){
        $list = array();
        $list[] = array(
            'value' => '',
            'label' => esc_html__('-- Choose One --','news')
        );
        $args= array(
        'post_type' => 'event',
        'posts_per_page' => -1, 
        );
        $query = new WP_Query($args);
        global $post;
        if($query->have_posts()): while ($query->have_posts()):$query->the_post();            
            $list[] = array(
                'value' => $post->ID,
                'label' => $post->post_title
            );
            endwhile;
        endif;
        wp_reset_postdata();
        return $list;
    }
}
// Author Box function
if(!function_exists('sv_author_box')){
    function sv_author_box(){ 
        $author_show = sv_get_value_by_id('sv_single_author_box','on');
        if($author_show == 'on'){
        ?>
        <div class="single-article-box">
            <div class="article-thumb">
                <a href="<?php echo esc_url(get_the_author_link()); ?>">
                    <?php echo get_avatar(get_the_author_meta('email','150')); ?>
                </a>
            </div>
            <div class="article-info">
                <h3><a href="<?php echo esc_url(get_the_author_link()); ?>"><?php echo get_the_author(); ?></a></h3>
                <?php if(isset($post->post_author)){
                    $short_des = get_user_option( 'short_des', $post->post_author );
                    echo  '<p>'.$short_des.' </p>';
                }?>
                <div class="social-article">
                    <?php
                        global $post;
                        $sl=array(
                            'googleplus'    =>  "fa fa-google-plus",
                            'facebook'      =>  "fa fa-facebook",
                            'twitter'       =>  "fa fa-twitter",
                            'linkedin'      =>  "fa fa-linkedin",
                            'github'        =>  'fa fa-github',
                            'tumblr'        =>  'fa fa-tumblr',
                            'youtube'       =>  'fa fa-youtube',
                            'instagram'     =>  'fa fa-instagram',
                            'vimeo'         =>  'fa fa-vimeo'
                        );
                        if(isset($post->post_author)){
                            foreach($sl as $type=>$class){
                                $url  = get_user_option( $type, $post->post_author );
                                if($url==true){?>
                                    <a href="<?php echo esc_url($url);?>"><i class="<?php echo esc_attr($class);?>"></i></a>
                                <?php }
                            }
                        }
                    ?>
                </div>
                <p><?php echo get_the_author_meta('description'); ?></p>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php }
    }
}

// Author Light Box function
if(!function_exists('sv_author_box_light')){
    function sv_author_box_light(){ 
        $author_show = sv_get_value_by_id('sv_single_author_box','on');
        if($author_show == 'on'){
        ?>
        <div class="single-leading-info">
            <a href="<?php echo esc_url(get_the_author_link()); ?>" class="single-leading-avatar">
                <?php echo get_avatar(get_the_author_meta('email','73')); ?>
            </a>
            <a href="<?php echo esc_url(get_the_author_link()); ?>" class="single-leading-author"><?php echo get_the_author(); ?></a>
            <p><?php echo get_the_author_meta('description'); ?></p>
            <div class="single-leading-social">
                <?php
                    global $post;
                    $sl=array(
                        'googleplus'    =>  "fa fa-google-plus",
                        'facebook'      =>  "fa fa-facebook",
                        'twitter'       =>  "fa fa-twitter",
                        'linkedin'      =>  "fa fa-linkedin",
                        'github'        =>  'fa fa-github',
                        'tumblr'        =>  'fa fa-tumblr',
                        'youtube'       =>  'fa fa-youtube',
                        'instagram'     =>  'fa fa-instagram',
                        'vimeo'         =>  'fa fa-vimeo'
                    );
                    if(isset($post->post_author)){
                        foreach($sl as $type=>$class){
                            $url  = get_user_option( $type, $post->post_author );
                            if($url==true){?>
                                <a href="<?php echo esc_url($url);?>"><i class="<?php echo esc_attr($class);?>"></i></a>
                            <?php }
                        }
                    }
                ?>
            </div>
        </div>
    <?php }
    }
}

//Relate Box
if(!function_exists('sv_single_related_post'))
{
    function sv_single_related_post()
    {
        $relate_show = sv_get_value_by_id('sv_single_relate_box','on');
        $relate_bg = sv_get_value_by_id('sv_single_relate_bg');
        if($relate_show == 'on'){
            $bg_class = SV_Assets::build_css('    background: #1d1d1d url("'.$relate_bg.'") no-repeat scroll center bottom;');
    ?>
        <div class="clearfix"></div>
        <div class="related-post <?php echo esc_attr($bg_class);?>">
            <h2 class="title home-title"><?php esc_html_e("RELATED POSTS","news")?></h2>
            <div class="home-direct-nav">
                <div class="sv-slider" data-item="4" data-speed="" data-itemres="" data-animation="" data-nav="home-direct-nav">
                    <?php
                        $categories = get_the_category(get_the_ID());
                        $category_ids = array();
                        foreach($categories as $individual_category){
                            $category_ids[] = $individual_category->term_id;
                        }
                        $args=array(
                            'category__in' => $category_ids,
                            'post__not_in' => array(get_the_ID()),
                            'posts_per_page'=>5
                            );                                        
                        $query = new wp_query($args);
                        if( $query->have_posts() ) {
                            while ($query->have_posts()) {
                                $query->the_post();
                                $terms = wp_get_post_terms( get_the_id(), 'category');
                                $term_name = $term_link = $icon = '';
                                if(is_array($terms) && !empty($terms)){
                                    $term_name = $terms[0]->name;
                                    $term_link = get_term_link( $terms[0]->term_id, 'category' );
                                    if(function_exists('get_term_meta')){
                                        $icon = get_term_meta( $terms[0]->term_id, 'cat-icon',true );
                                    }
                                    $icon_html = '';
                                    if(!empty($icon)){
                                        if(strpos($icon,'lnr') !== false) $icon_html = '<span class="lnr '.$icon.'"></span>';
                                        else $icon_html =   '<i class="fa '.$icon.'"></i>';
                                    }
                                    $term_html = '<a href="'.esc_url($term_link).'">'.$icon_html.' '.$term_name.'</a>';
                                }
                                else $term_html = '';
                            echo    '<div class="item">
                                        <div class="post-item">
                                            <div class="post-thumb">
                                                <a href="'.esc_url(get_the_permalink()).'">
                                                    '.get_the_post_thumbnail(get_the_ID(),array(266,216)).'
                                                </a>
                                            </div>
                                            <div class="post-info">
                                                <div class="post-format">
                                                    '.$term_html.'
                                                </div>
                                                <h3 class="post-title">
                                                    <a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a>
                                                </h3>
                                                <p class="desc">'.get_the_excerpt().'</p>
                                            </div>
                                        </div>
                                    </div>';
                            }
                        }
                        wp_reset_postdata();
                    ?>
                </div>
            </div>
        </div>
    <?php }
    }
}

//Relate Box
if(!function_exists('sv_single_related_post_light'))
{
    function sv_single_related_post_light()
    {
        $relate_show = sv_get_value_by_id('sv_single_relate_box','on');
        $relate_bg = sv_get_value_by_id('sv_single_relate_bg');
        if($relate_show == 'on'){
        ?>
        <div class="related-article">
            <h2><?php esc_html_e("RELATED ARTICLES","news")?></h2>
            <div class="row">
            <?php
                $categories = get_the_category(get_the_ID());
                $category_ids = array();
                foreach($categories as $individual_category){
                    $category_ids[] = $individual_category->term_id;
                }
                $args=array(
                    'category__in' => $category_ids,
                    'post__not_in' => array(get_the_ID()),
                    'posts_per_page'=> 3
                    );                                        
                $query = new wp_query($args);
                if( $query->have_posts() ) {
                    while ($query->have_posts()) {
                        $query->the_post(); 
                        $cates = get_the_category_list(', ');
                        if($cates) $cate_html = $cates;
                        else $cate_html = esc_html__("No Category","news");                      
                    echo    '<div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="item-related-article">
                                    <div class="related-article-thumb">
                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(270,180)).'</a>
                                        <ul class="featurred-cat-newday">
                                            <li>'.esc_html__("in:","news").' '.$cate_html.'</li>
                                            <li>'.esc_html__("Post by:","news").' <a href="'.esc_url(get_author_posts_url(get_the_author_meta('ID'))).'">'.get_the_author().'</a></li>
                                        </ul>
                                    </div>
                                    <div class="related-article-info">
                                        <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                    </div>
                                </div>
                            </div>';
                    }
                }
                wp_reset_postdata();
            ?>
            </div>
        </div>
    <?php }
    }
}

// Mini cart
if(!function_exists('sv_mini_cart')){
    function sv_mini_cart($echo = false){
        $html = '';
        if ( ! WC()->cart->is_empty() ){
            $count_item = 0; $html = '';
            $html .=  '<ul class="info-list-cart">';                    
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                $count_item++;
                $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
                $product_quantity = woocommerce_quantity_input( array(
                    'input_name'  => "cart[{$cart_item_key}][qty]",
                    'input_value' => $cart_item['quantity'],
                    'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
                    'min_value'   => '0'
                ), $_product, false );
                $thumb_html = '';
                if(has_post_thumbnail($product_id)) $thumb_html = get_the_post_thumbnail($product_id,array(70,70));
                $html .=    '<li class="item-info-cart" data-key="'.$cart_item_key.'">
                                <div class="cart-thumb">
                                    <a href="'.esc_url( $_product->get_permalink( $cart_item )).'" class="cart-thumb">
                                        '.$thumb_html.'
                                    </a>
                                </div>  
                                <div class="wrap-cart-title">
                                    <h3 class="cart-title"><a href="'.esc_url( $_product->get_permalink( $cart_item )).'">'.$_product->get_title().'</a></h3>
                                    <div class="cart-qty"><label>'.esc_html__("Qty","news").':</label> <span>'.$cart_item['quantity'].'</span></div>
                                </div>  
                                <div class="wrap-cart-remove">
                                    <a href="#" class="remove-product btn-remove"></a>
                                    <span class="cart-price">'.apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ).'</span>
                                </div>  
                            </li>';
            }
            $html .=    '</ul><input id="count-cart-item" type="hidden" value="'.$count_item.'">';
            $html .=    '<div class="total-cart">
                            <label>'.esc_html__("Subtotal","news").'</label> <span class="total-price">'.WC()->cart->get_cart_total().'</span>
                        </div>
                        <div class="link-cart">
                            <a href="'.esc_url(WC()->cart->get_cart_url()).'" class="cart-edit">'.esc_html__("edit cart","news").'</a>
                            <a href="'.esc_url(WC()->cart->get_checkout_url()).'" class="cart-checkout">'.esc_html__("checkout","news").'</a>
                        </div>';
        }
        else $html .= '<ul class="info-list-cart"><li class="item-info-cart"><h3>'.esc_html__("No product in cart","news").'</h3></li></ul>';
        if($echo) echo balanceTags($html);
        else return $html;
    }
}
//get type url
if(!function_exists('sv_get_type_url')){
    function sv_get_type_url($type){
        if(function_exists('sv_get_current_url')) $current_url = sv_get_current_url();
        else $current_url = get_the_permalink();
        $current_url = str_replace('&type=grid', '', $current_url);
        $current_url = str_replace('?type=grid', '', $current_url);
        $current_url = str_replace('&type=list', '', $current_url);
        $current_url = str_replace('?type=list', '', $current_url);
        if(strpos($current_url,'?') > -1 ){
            $current_url .= '&amp;type='.$type;
        }
        else {
            $current_url .= '?type='.$type;
        }
        return $current_url;
    }
}
if(!function_exists('sv_product_link')){
    function sv_product_link(){
        global $product;                                
        $button_html =  apply_filters( 'woocommerce_loop_add_to_cart_link',
            sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s product_type_%s"><span data-hover="'.esc_html__("Add to cart","news").'">%s</span></a>',
                esc_url( $product->add_to_cart_url() ),
                esc_attr( $product->id ),
                esc_attr( $product->get_sku() ),
                esc_attr( isset( $quantity ) ? $quantity : 1 ),
                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button ajax_add_to_cart link-add-cart' : '',
                esc_attr( $product->product_type ),
                esc_html( $product->add_to_cart_text() )
            ),
        $product );
        $html =    '<ul class="product-cart">
                        <li>'.$button_html.'</li>
                        <li><a class="link-detail" href="'.esc_url(get_the_permalink()).'"><span data-hover="'.esc_html__("more detail","news").'">'.esc_html__("more detail","news").'</span></a></li>
                    </ul>';
        return $html;
    }
}
if(!function_exists('sv_product_quick_view')){
    function sv_product_quick_view(){
        $html =    '<a data-product-id="'.get_the_id().'" href="'.esc_url(get_the_permalink()).'" class="product-quick-view fancybox">'.esc_html__("quick view","news").'</a>';
        return $html;
    }
}
if(!function_exists('sv_get_rating_html')){
    function sv_get_rating_html(){
        global $product;
        $html = '';
        $star = $product->get_average_rating();
        $width = $star / 5 * 100;
        if($star){
            $html =  '<div class="wrap-star-rating">
                        <div class="inner-star-rating" style="width:'.$width.'%"></div>
                    </div>';
        }
        return $html;
    }
}
//Header page
if(!function_exists('sv_header_page')){
    function sv_header_page(){
        $url = sv_get_value_by_id('header_url');
        $image = sv_get_value_by_id('header_bg');        
        $header_show = sv_get_value_by_id('show_header');
        ?>
        <?php if(($header_show == 'on' || $header_show == 'yes') && !empty($image) && sv_is_woocommerce_page()):?>
            <div class="banner-shop-image">
                <a href="<?php echo esc_url($url)?>"><img src="<?php echo esc_url($image)?>" alt=""></a>
            </div>
        <?php endif;?>
    <?php }
}
//product main detail
if(!function_exists('sv_product_main_detai')){
    function sv_product_main_detai($ajax = false){
        global $product, $woocommerce;
        $thumb_id = array(get_post_thumbnail_id());
        $attachment_ids = $product->get_gallery_attachment_ids();
        $attachment_ids = array_merge($thumb_id,$attachment_ids);
        $ul_block = $bx_block = '';$i = 0;
        foreach ( $attachment_ids as $attachment_id ) {
            $image_link = wp_get_attachment_url( $attachment_id );
            if ( ! $image_link )
                continue;
            $image_title    = esc_attr( get_the_title( $attachment_id ) );
            $image_caption  = esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );
            $image       = wp_get_attachment_image( $attachment_id, array(350,350), 0, $attr = array(
                'title' => $image_title,
                'alt'   => $image_title
                ) );
            if($i == 0) $el_class = 'active';
            else $el_class = '';
            $ul_block .= '<li><a href="#" class="'.$el_class.'">'.$image.'</a></li>';
            $i++;
        }
        $available_data = array();
        if( $product->is_type( 'variable' ) ) $available_data = $product->get_available_variations();        
        if(!empty($available_data)){
            foreach ($available_data as $available) {
                if(!empty($available['image_src'])){
                    $page_index = $i-1;
                    $ul_block .= '<li data-variation_id="'.$available['variation_id'].'"><a href="#" class="'.$el_class.'"><img src="'.esc_url($available['image_link']).'" srcset="'.esc_url($available['image_link']).'" alt="'.$available['image_alt'].'" title="'.$available['image_title'].'" ></a></li>';                    
                    $i++;
                }
            }
        }
        ?>
            <div class="main-detail">
                <div class="clearfix">
                    <div class="detail-gallery">
                        <div class="mid">
                            <?php 
                            $image_title_thumb    = esc_attr( get_the_title( get_post_thumbnail_id() ) );
                            $image_caption_thumb  = esc_attr( get_post_field( 'post_excerpt', get_post_thumbnail_id() ) );
                                echo wp_get_attachment_image( get_post_thumbnail_id(), array(350,350), 0, $attr = array(
                                        'title' => $image_title_thumb,
                                        'alt'   => $image_caption_thumb
                                        ) );
                            ?>
                        </div>
                        <?php if(count($attachment_ids) > 1):?>
                            <div class="carousel">
                                <ul>
                                    <?php echo balanceTags($ul_block)?>
                                </ul>
                            </div>
                            <div class="gallery-control">
                                <a href="#" class="prev"></a>
                                <a href="#" class="next"></a>
                            </div>
                        <?php endif;?>
                    </div>
                    <div class="detail-info">
                        <div class="product-info">
                            <h2><?php the_title()?></h2>
                            <div class="product-price">
                                <?php echo balanceTags($product->get_price_html())?>
                            </div>
                            <?php echo balanceTags(sv_get_rating_html());?>
                            <p class="desc"><?php echo get_the_excerpt()?></p>
                            <?php woocommerce_template_single_add_to_cart()?>                            
                        </div>
                    </div>
                </div>
            </div>
        <?php   
    }
}
//List Post
if(!function_exists('sv_get_list_post')){
    function sv_get_list_post(){
        $list = array();
        $list[] = array(
            'value' => '',
            'label' => esc_html__('-- Choose One --','news')
        );
        $args= array(
        'post_type' => 'post',
        'posts_per_page' => 50, 
        );
        $query = new WP_Query($args);
        global $post;
        if($query->have_posts()): while ($query->have_posts()):$query->the_post();            
            $list[] = array(
                'value' => $post->ID,
                'label' => $post->post_title
            );
            endwhile;
        endif;
        wp_reset_postdata();
        return $list;
    }
}
//share box
if(!function_exists('sv_share_box')){
    function sv_share_box(){
        $html =     '<a href="'.esc_url("https://plus.google.com/share?url=".get_the_permalink()).'"><i class="fa fa-google-plus"></i></a>
                    <a href="'.esc_url("http://www.facebook.com/sharer.php?u=".get_the_permalink()).'"><i class="fa fa-facebook"></i></a>
                    <a href="'.esc_url("http://www.twitter.com/share?url=".get_the_permalink()).'"><i class="fa fa-twitter"></i></a>';
        return $html;
    }
}
if(!function_exists('sv_special_metabox')){
    function sv_special_metabox(){
        $html = '<div class="statistic-post">
                    '.sv_getPostLikeLink(get_the_ID()).'
                    <a href="'.esc_url("http://pdfmyurl.com/saveaspdf?url=".get_the_permalink()).'"><i class="fa fa-bookmark"></i> '.esc_html__("Save","news").'</a>
                    <a href="'.esc_url("https://plus.google.com/share?url=".get_the_permalink()).'"><i class="fa fa-share-alt"></i> '.esc_html__("Share","news").'</a>
                    <a href="'.esc_url(get_comments_link(get_the_ID())).'"><i class="fa fa-comment"></i> '.get_comments_number().'</a>
                </div>';
        return $html;
    }
}

if(!function_exists('sv_get_page_id')){
    function sv_get_page_id(){
        $id = get_the_ID();
        if(is_front_page() && is_home()) $id = (int)get_option( 'page_on_front' );
        if(!is_front_page() && is_home()) $id = (int)get_option( 'page_for_posts' );
        if(is_archive() || is_search()) $id = 0;
        return $id;
    }
}
if(!function_exists('sv_scroll_top')){
    function sc_scroll_top(){
        $scoll_top = sv_get_value_by_id('show_scroll_top');
        if($scoll_top == 'on'):
            $scoll_top_style = sv_get_value_by_id('scroll_top_style');
        ?>
        <a href="#" class="scroll-top <?php echo esc_attr($scoll_top_style)?>"><span class="lnr lnr-location"></span> <?php esc_html_e("top","news")?> </a>
        <?php endif;
    }
}
if(!function_exists('sv_get_header_default')){
    function sv_get_header_default(){
        ?>
        <div id="header" class="header-default">
            <div class="container">
                <div class="row header">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="logo">
                            <a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_attr__("logo","news");?>">
                                <?php $sv_logo=sv_get_option('logo');?>
                                <?php if($sv_logo!=''){
                                    echo '<img src="' . esc_url($sv_logo) . '" alt="logo">';
                                }   else { echo '<h1>'.get_bloginfo('name', 'display').'</h1>'; }
                                ?>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="main-nav">
                    <?php if ( has_nav_menu( 'primary' ) ) {
                        wp_nav_menu( array(
                                'theme_location' => 'primary',
                                'container'=>false,
                                'walker'=>new SV_Walker_Nav_Menu(),
                                'menu_class'=>'main-menu',
                             )
                        );
                    } ?>
                    <div class="mobile-menu">
                        <span class="mobile-menu-text"><?php esc_html_e("Menu","news");?></span>
                        <a href="#" class="btn-mobile-menu"><span class="lnr lnr-menu"></span></a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
if(!function_exists('sv_get_footer_default')){
    function sv_get_footer_default(){
        ?>
        <div id="footer" class="default-footer">
            <div class="container">
                <p class="copyright"><?php esc_html_e("Copyright &copy; by 7up. All Rights Reserved. Designed by","news")?> <a href="#"><span><?php esc_html_e("7uptheme","news")?></span>.<?php esc_html_e("com","news")?></a>.</p>
            </div>
        </div>
        <?php
    }
}
if(!function_exists('sv_get_footer_visual')){
    function sv_get_footer_visual($page_id){
        ?>
        <div id="footer" class="footer-page">
            <div class="container">
                <?php echo SV_Template::get_vc_pagecontent($page_id);?>
            </div>
        </div>
        <?php
    }
}
if(!function_exists('sv_get_header_visual')){
    function sv_get_header_visual($page_id){
        ?>
        <div id="header" class="header-page">
            <div class="container">
                <?php echo SV_Template::get_vc_pagecontent($page_id);?>
            </div>
        </div>
        <?php
    }
}
/***************************************END Theme Function***************************************/
