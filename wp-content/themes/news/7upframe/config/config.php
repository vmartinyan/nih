<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(!function_exists('sv_set_theme_config')){
    function sv_set_theme_config(){
    global $sv_dir,$sv_config;
        $sv_dir = get_template_directory_uri() . '/7upframe';
        $sv_config = array();
        $sv_config['dir'] = $sv_dir;
        $sv_config['css_url'] = $sv_dir . '/assets/css/';
        $sv_config['js_url'] = $sv_dir . '/assets/js/';
        $sv_config['nav_menu'] = array(
            'primary' => esc_html__( 'Primary Navigation', 'news' ),
        );
        $sv_config['mega_menu'] = '1';
        $sv_config['sidebars']=array(
            array(
                'name'              => esc_html__( 'Blog Sidebar', 'news' ),
                'id'                => 'blog-sidebar',
                'description'       => esc_html__( 'Widgets in this area will be shown on all blog page.', 'news'),
                'before_title'      => '<h3 class="widget-title">',
                'after_title'       => '</h3>',
                'before_widget'     => '<div id="%1$s" class="sidebar-blog-post widget %2$s">',
                'after_widget'      => '</div>',
            ),
        );
        $sv_config['import_config'] = array(
                'homepage_default'          => 'Home',
                'blogpage_default'          => 'Blog',
                'menu_locations'            => array("Main Menu" => "primary"),
                'set_woocommerce_page'      => 1
            );
        $sv_config['import_theme_option'] = 'YTo0MTp7czoxNDoic3ZfaGVhZGVyX3BhZ2UiO3M6MjoiMTciO3M6MTQ6InN2X2Zvb3Rlcl9wYWdlIjtzOjI6IjE5IjtzOjEzOiJ0aGVtZV92ZXJzaW9uIjtzOjQ6ImRhcmsiO3M6MjA6InN2X2hlYWRlcl9wYWdlX2xpZ2h0IjtzOjM6IjgwNyI7czoyMDoic3ZfZm9vdGVyX3BhZ2VfbGlnaHQiO3M6MzoiODA5IjtzOjExOiJzdl80MDRfcGFnZSI7czowOiIiO3M6MTc6InN2X3Nob3dfYnJlYWRydW1iIjtzOjI6Im9uIjtzOjE2OiJzdl9iZ19icmVhZGNydW1iIjtzOjA6IiI7czoxMDoic3ZfYmdfYm9keSI7czowOiIiO3M6MTI6InN2X2ZvbnRfYm9keSI7czowOiIiO3M6MTA6Im1haW5fY29sb3IiO3M6MDoiIjtzOjEwOiJjdXN0b21fY3NzIjtzOjA6IiI7czo0OiJsb2dvIjtzOjcyOiJodHRwOi8vN3VwdGhlbWUuY29tL3dvcmRwcmVzcy9uZXdkYXkvd3AtY29udGVudC91cGxvYWRzLzIwMTYvMDIvbG9nby5wbmciO3M6NzoiZmF2aWNvbiI7czo3MToiaHR0cDovLzd1cHRoZW1lLmNvbS93b3JkcHJlc3MvbmV3ZGF5L3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDE2LzAyLzd1cC5qcGciO3M6MTM6InN2X21lbnVfZml4ZWQiO3M6Mjoib24iO3M6MTM6InN2X21lbnVfY29sb3IiO3M6MDoiIjtzOjE5OiJzdl9tZW51X2NvbG9yX2hvdmVyIjtzOjA6IiI7czoyMDoic3ZfbWVudV9jb2xvcl9hY3RpdmUiO3M6MDoiIjtzOjI0OiJzdl9zaWRlYmFyX3Bvc2l0aW9uX2Jsb2ciO3M6NToicmlnaHQiO3M6MTU6InN2X3NpZGViYXJfYmxvZyI7czoxMjoiYmxvZy1zaWRlYmFyIjtzOjI0OiJzdl9zaWRlYmFyX3Bvc2l0aW9uX3BhZ2UiO3M6Mjoibm8iO3M6MTU6InN2X3NpZGViYXJfcGFnZSI7czowOiIiO3M6MzI6InN2X3NpZGViYXJfcG9zaXRpb25fcGFnZV9hcmNoaXZlIjtzOjU6InJpZ2h0IjtzOjIzOiJzdl9zaWRlYmFyX3BhZ2VfYXJjaGl2ZSI7czoxMjoiYmxvZy1zaWRlYmFyIjtzOjI0OiJzdl9zaWRlYmFyX3Bvc2l0aW9uX3Bvc3QiO3M6NToicmlnaHQiO3M6MTU6InN2X3NpZGViYXJfcG9zdCI7czoxMjoiYmxvZy1zaWRlYmFyIjtzOjE0OiJzdl9hZGRfc2lkZWJhciI7YToyOntpOjA7YTozOntzOjU6InRpdGxlIjtzOjE5OiJXb29jb21tZXJjZSBzaWRlYmFyIjtzOjIwOiJ3aWRnZXRfdGl0bGVfaGVhZGluZyI7czoyOiJoMiI7czoxNDoid2lkZ2V0X3ZlcnNpb24iO3M6MTQ6InNpZGViYXItd2lkZ2V0Ijt9aToxO2E6Mzp7czo1OiJ0aXRsZSI7czoxMzoiTGlnaHQgc2lkZWJhciI7czoyMDoid2lkZ2V0X3RpdGxlX2hlYWRpbmciO3M6MjoiaDIiO3M6MTQ6IndpZGdldF92ZXJzaW9uIjtzOjE3OiJzaWRlYmFyLWJsb2ctcG9zdCI7fX1zOjEyOiJnb29nbGVfZm9udHMiO2E6MTp7aTowO2E6Mjp7czo2OiJmYW1pbHkiO3M6Njoib3N3YWxkIjtzOjg6InZhcmlhbnRzIjthOjM6e2k6MDtzOjM6IjMwMCI7aToxO3M6NzoicmVndWxhciI7aToyO3M6MzoiNzAwIjt9fX1zOjIwOiJzdl9oZWFkZXJfcGFnZV9ldmVudCI7czozOiIxMjciO3M6MjA6InN2X2Zvb3Rlcl9wYWdlX2V2ZW50IjtzOjM6IjE0NSI7czoyMDoic3Zfc2luZ2xlX2F1dGhvcl9ib3giO3M6Mjoib24iO3M6MjA6InN2X3NpbmdsZV9yZWxhdGVfYm94IjtzOjI6Im9uIjtzOjE5OiJzdl9zaW5nbGVfcmVsYXRlX2JnIjtzOjc0OiJodHRwOi8vN3VwdGhlbWUuY29tL3dvcmRwcmVzcy9uZXdkYXkvd3AtY29udGVudC91cGxvYWRzLzIwMTYvMDIvYmctdG9wLmpwZyI7czoxODoic3ZfaGVhZGVyX3BhZ2Vfd29vIjtzOjM6IjQxMSI7czoxODoic3ZfZm9vdGVyX3BhZ2Vfd29vIjtzOjM6IjQxNSI7czoxMToic2hvd19oZWFkZXIiO3M6Mjoib24iO3M6OToiaGVhZGVyX2JnIjtzOjc4OiJodHRwOi8vN3VwdGhlbWUuY29tL3dvcmRwcmVzcy9uZXdkYXkvd3AtY29udGVudC91cGxvYWRzLzIwMTYvMDIvYmFubmVyLWltZy5qcGciO3M6MTA6ImhlYWRlcl91cmwiO3M6MToiIyI7czoyMzoic3Zfc2lkZWJhcl9wb3NpdGlvbl93b28iO3M6NToicmlnaHQiO3M6MTQ6InN2X3NpZGViYXJfd29vIjtzOjE5OiJ3b29jb21tZXJjZS1zaWRlYmFyIjtzOjE1OiJ3b29fc2hvcF9jb2x1bW4iO3M6MToiMyI7fQ==';
        $sv_config['import_widget'] = '{"blog-sidebar":{"text-2":{"title":"","text":"<div class=\"widget widget-image\">\r\n<a href=\"#\"><img src=\"http:\/\/7uptheme.com\/wordpress\/news\/wp-content\/uploads\/2016\/02\/banner.jpg\" alt=\"\"><\/a>\r\n<\/div>","filter":false},"recent-posts-2":{"title":"","number":5}},"single-light-sidebar":{"sv_trending_widget-2":{"title":"Trending","number":"18"},"sv_mailchimp_widget-2":{"title":"NEWSLETTER","form_id":"887","des1":"Subscribe to our email Newsletter for useful tips","des2":"Valuable resources. Choose your preference below..."},"sv_post_tab_widget-2":{"title":"","number":"8"},"text-5":{"title":"","text":"<div class=\"adv-shop-online\">\r\n<a href=\"#\"><img alt=\"\" src=\"http:\/\/7uptheme.com\/wordpress\/news\/wp-content\/uploads\/2016\/03\/ad2.jpg\"><\/a>\r\n<\/div>","filter":false}},"woocommerce-sidebar":{"woocommerce_product_categories-2":{"title":"Categories","orderby":"name","dropdown":0,"count":0,"hierarchical":1,"show_children_only":0,"hide_empty":0},"sv_advantage_widget-2":{"title":"On Sale","advs":{"1":{"title":"<span>up to<\/span> <strong> 45% off<\/strong>","link":"#","image":"http:\/\/7uptheme.com\/wordpress\/news\/wp-content\/uploads\/2016\/02\/ad1.jpg"},"2":{"title":"<span>up to<\/span> <strong> 45% off<\/strong>","link":"#","image":"http:\/\/7uptheme.com\/wordpress\/news\/wp-content\/uploads\/2016\/02\/ad2.jpg"},"3":{"title":"<span>up to<\/span> <strong> 45% off<\/strong>","link":"#","image":"http:\/\/7uptheme.com\/wordpress\/news\/wp-content\/uploads\/2016\/02\/ad3.jpg"}}},"woocommerce_price_filter-2":{"title":"Price"},"woocommerce_product_tag_cloud-2":{"title":"Tags"}},"light-sidebar":{"categories-3":{"title":"Categories","count":0,"hierarchical":0,"dropdown":0},"text-3":{"title":"FAQs","text":"<div class=\"widget1 widget-faqs\">\r\n<ul>\r\n<li class=\"active\">\r\n<a href=\"#\">Consectetuer adipiscing<\/a>\t\t\t\t\t\t\t\t\t\t<p>Vestibulum tortor quam, feugiat vitae, ultricies eget malesuada fam. Lorem ipsum dolor sit amet, consect tur adipiscing elit. Phasellus rutrum, libero id imperdiet ementum<\/p>\r\n<\/li>\t\r\n<li class=\"\">\r\n<a href=\"#\">Hiking through The <\/a>\t\t\t\t\t\t\t\t\t\t<p>Vestibulum tortor quam, feugiat vitae, ultricies eget malesuada fam. Lorem ipsum dolor sit amet, consect tur adipiscing elit. Phasellus rutrum, libero id imperdiet ementum<\/p>\t\t\t\t\t\t\t\t\t<\/li>\r\n<li class=\"\">\r\n<a href=\"#\">Nam eget dui rhoncus<\/a>\t\t\t\t\t\t\t\t\t\t<p>Vestibulum tortor quam, feugiat vitae, ultricies eget malesuada fam. Lorem ipsum dolor sit amet, consect tur adipiscing elit. Phasellus rutrum, libero id imperdiet ementum<\/p>\r\n\t\t\t\t\t\t\t\t\t<\/li>\r\n\t\t\t\t\t\t\t\t<\/ul>\r\n\t\t\t\t\t\t\t<\/div>","filter":false},"text-4":{"title":"","text":"<div class=\"adv-shop-online\">\r\n<a href=\"#\"><img alt=\"\" src=\"http:\/\/7uptheme.com\/wordpress\/news\/wp-content\/uploads\/2016\/03\/ad2.jpg\"><\/a>\r\n<\/div>","filter":false},"tag_cloud-3":{"title":"Tags","taxonomy":"post_tag"}}}';

        /**************************************** PLUGINS ****************************************/

        $sv_config['require-plugin'] = array(    
            array(
                'name'               => 'Option Tree', // The plugin name.
                'slug'               => 'option-tree', // The plugin slug (typically the folder name).
                'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            ),
            array(
                'name'      => esc_html__('Contact Form 7','news'),
                'slug'      => 'contact-form-7',
                'required'  => true,
            ),
            array(
                'name'      => esc_html__('Visual Composer','news'),
                'slug'      => 'js_composer',
                'required'  => true,
                'source'    =>get_template_directory_uri().'/plugins/js_composer.zip'
            ),
            array(
                'name'      => esc_html__('7up Core','news'),
                'slug'      => '7up-core',
                'required'  => true,
                'source'    =>get_template_directory_uri().'/plugins/7up-core.zip'
            ),
            array(
                'name'      => esc_html__('WooCommerce','news'),
                'slug'      => 'woocommerce',
                'required'  => true,
            ),
            array(
                'name'      => esc_html__('MailChimp for WordPress Lite','news'),
                'slug'      => 'mailchimp-for-wp',
                'required'  => true,
            ),
        );

        /**************************************** THEME OPTION ****************************************/

        $sv_config['theme-option'] = array(
            'sections' => array(
                array(
                    'id' => 'option_general',
                    'title' => '<i class="fa fa-cog"></i>'.esc_html__(' General Settings', 'news')
                ),
                array(
                    'id' => 'option_logo',
                    'title' => '<i class="fa fa-image"></i>'.esc_html__(' Logo Settings', 'news')
                ),
                array(
                    'id' => 'option_menu',
                    'title' => '<i class="fa fa-align-justify"></i>'.esc_html__(' Menu Settings', 'news')
                ),
                array(
                    'id' => 'option_layout',
                    'title' => '<i class="fa fa-columns"></i>'.esc_html__(' Layout Settings', 'news')
                ),
                array(
                    'id' => 'option_typography',
                    'title' => '<i class="fa fa-font"></i>'.esc_html__(' Typography', 'news')
                ),
                array(
                    'id' => 'option_event',
                    'title' => '<i class="fa fa-font"></i>'.esc_html__(' Event', 'news')
                ),
                array(
                    'id' => 'option_single',
                    'title' => '<i class="fa fa-cog"></i>'.esc_html__(' Single Settings', 'news')
                ),
            ),
            'settings' => array(
                /*----------------Begin General --------------------*/
                array(
                    'id'          => 'sv_header_page',
                    'label'       => esc_html__( 'Header Page', 'news' ),
                    'desc'        => esc_html__( 'Include page to Header', 'news' ),
                    'type'        => 'select',
                    'section'     => 'option_general',
                    'choices'     => sv_list_header_page()
                ),
                array(
                    'id'          => 'sv_footer_page',
                    'label'       => esc_html__( 'Footer Page', 'news' ),
                    'desc'        => esc_html__( 'Include page to Footer', 'news' ),
                    'type'        => 'page-select',
                    'section'     => 'option_general'
                ),
                array(
                    'id'          => 'sv_404_page',
                    'label'       => esc_html__( '404 Page', 'news' ),
                    'desc'        => esc_html__( 'Include page to 404 page', 'news' ),
                    'type'        => 'page-select',
                    'section'     => 'option_general'
                ),
                array(
                    'id' => 'sv_show_breadrumb',
                    'label' => esc_html__('Show BreadCrumb', 'news'),
                    'desc' => esc_html__('This allow you to show or hide BreadCrumb', 'news'),
                    'type' => 'on-off',
                    'section' => 'option_general',
                    'std' => 'on'
                ),
                array(
                    'id'          => 'sv_bg_breadcrumb',
                    'label'       => esc_html__('Background Breadcrumb','news'),
                    'type'        => 'background',
                    'section'     => 'option_general',
                    'condition'   => 'sv_show_breadrumb:is(on)',
                ),
                array(
                    'id'          => 'sv_bg_body',
                    'label'       => esc_html__('Body Background','news'),
                    'type'        => 'background',
                    'section'     => 'option_general',
                ),
                array(
                    'id'          => 'sv_font_body',
                    'label'       => esc_html__('Body Font','news'),
                    'type'        => 'typography',
                    'section'     => 'option_general',
                ),
                array(
                    'id'          => 'main_color',
                    'label'       => esc_html__('Main color','news'),
                    'type'        => 'colorpicker',
                    'section'     => 'option_general',
                ),
                array(
                    'id'          => 'custom_css',
                    'label'       => esc_html__('Custom CSS','news'),
                    'type'        => 'textarea-simple',
                    'section'     => 'option_general',
                ),
                /*----------------End General ----------------------*/

                /*----------------Begin Logo --------------------*/
                array(
                    'id' => 'logo',
                    'label' => esc_html__('Logo', 'news'),
                    'desc' => esc_html__('This allow you to change logo', 'news'),
                    'type' => 'upload',
                    'section' => 'option_logo',
                ),        
                array(
                    'id' => 'favicon',
                    'label' => esc_html__('Favicon', 'news'),
                    'desc' => esc_html__('This allow you to change favicon of your website', 'news'),
                    'type' => 'upload',
                    'section' => 'option_logo'
                ),
                /*----------------End Logo ----------------------*/

                /*----------------Begin Menu --------------------*/
                array(
                    'id'          => 'sv_menu_fixed',
                    'label'       => esc_html__('Menu Fixed','news'),
                    'desc'        => 'Menu change to fixed when scroll',
                    'type'        => 'on-off',
                    'section'     => 'option_menu',
                    'std'         => 'on',
                ),
                array(
                    'id'          => 'sv_menu_color',
                    'label'       => esc_html__('Menu style','news'),
                    'type'        => 'typography',
                    'section'     => 'option_menu',
                ),
                array(
                    'id'          => 'sv_menu_color_hover',
                    'label'       => esc_html__('Hover color','news'),
                    'desc'        => esc_html__('Choose color','news'),
                    'type'        => 'colorpicker',
                    'section'     => 'option_menu',
                ),
                array(
                    'id'          => 'sv_menu_color_active',
                    'label'       => esc_html__('Active color','news'),
                    'desc'        => esc_html__('Choose color','news'),
                    'type'        => 'colorpicker',
                    'section'     => 'option_menu',
                ),
                /*----------------End Menu ----------------------*/
                

                /*----------------Begin Layout --------------------*/
                array(
                    'id'          => 'sv_sidebar_position_blog',
                    'label'       => esc_html__('Sidebar Blog','news'),
                    'type'        => 'select',
                    'section'     => 'option_layout',
                    'desc'=>esc_html__('Left, or Right, or Center','news'),
                    'std'         => 'right',
                    'choices'     => array(
                        array(
                            'value'=>'no',
                            'label'=>esc_html__('No Sidebar','news'),
                        ),
                        array(
                            'value'=>'left',
                            'label'=>esc_html__('Left','news'),
                        ),
                        array(
                            'value'=>'right',
                            'label'=>esc_html__('Right','news'),
                        )
                    )
                ),
                array(
                    'id'          => 'sv_sidebar_blog',
                    'label'       => esc_html__('Sidebar select display in blog','news'),
                    'type'        => 'sidebar-select',
                    'section'     => 'option_layout',
                    'condition'   => 'sv_sidebar_position_blog:not(no)',
                    'std'         => 'blog-sidebar',
                ),
                /****end blog****/
                array(
                    'id'          => 'sv_sidebar_position_page',
                    'label'       => esc_html__('Sidebar Page','news'),
                    'type'        => 'select',
                    'section'     => 'option_layout',
                    'desc'=>esc_html__('Left, or Right, or Center','news'),
                    'choices'     => array(
                        array(
                            'value'=>'no',
                            'label'=>esc_html__('No Sidebar','news'),
                        ),
                        array(
                            'value'=>'left',
                            'label'=>esc_html__('Left','news'),
                        ),
                        array(
                            'value'=>'right',
                            'label'=>esc_html__('Right','news'),
                        )
                    )
                ),
                array(
                    'id'          => 'sv_sidebar_page',
                    'label'       => esc_html__('Sidebar select display in page','news'),
                    'type'        => 'sidebar-select',
                    'section'     => 'option_layout',
                    'condition'   => 'sv_sidebar_position_page:not(no)',
                ),
                /****end page****/
                array(
                    'id'          => 'sv_sidebar_position_page_archive',
                    'label'       => esc_html__('Sidebar Position on Page Archives:','news'),
                    'type'        => 'select',
                    'section'     => 'option_layout',
                    'desc'=>esc_html__('Left, or Right, or Center','news'),
                    'std'         => 'right',
                    'choices'     => array(
                        array(
                            'value'=>'no',
                            'label'=>esc_html__('No Sidebar','news'),
                        ),
                        array(
                            'value'=>'left',
                            'label'=>esc_html__('Left','news'),
                        ),
                        array(
                            'value'=>'right',
                            'label'=>esc_html__('Right','news'),
                        )
                    )
                ),
                array(
                    'id'          => 'sv_sidebar_page_archive',
                    'label'       => esc_html__('Sidebar select display in page Archives','news'),
                    'type'        => 'sidebar-select',
                    'section'     => 'option_layout',
                    'std'         => 'blog-sidebar',
                    'condition'   => 'sv_sidebar_position_page_archive:not(no)',
                ),
                // END
                array(
                    'id'          => 'sv_sidebar_position_post',
                    'label'       => esc_html__('Sidebar Single Post','news'),
                    'type'        => 'select',
                    'section'     => 'option_layout',
                    'desc'=>esc_html__('Left, or Right, or Center','news'),
                    'std'         => 'right',
                    'choices'     => array(
                        array(
                            'value'=>'no',
                            'label'=>esc_html__('No Sidebar','news'),
                        ),
                        array(
                            'value'=>'left',
                            'label'=>esc_html__('Left','news'),
                        ),
                        array(
                            'value'=>'right',
                            'label'=>esc_html__('Right','news'),
                        )
                    )
                ),
                array(
                    'id'          => 'sv_sidebar_post',
                    'label'       => esc_html__('Sidebar select display in single post','news'),
                    'type'        => 'sidebar-select',
                    'section'     => 'option_layout',
                    'std'         => 'blog-sidebar',
                    'condition'   => 'sv_sidebar_position_post:not(no)',
                ),
                array(
                    'id'          => 'sv_add_sidebar',
                    'label'       => esc_html__('Add SideBar','news'),
                    'type'        => 'list-item',
                    'section'     => 'option_layout',
                    'std'         => '',
                    'settings'    => array( 
                        array(
                            'id'          => 'widget_title_heading',
                            'label'       => esc_html__('Choose heading title widget','news'),
                            'type'        => 'select',
                            'std'        => 'h3',
                            'choices'     => array(
                                array(
                                    'value'=>'h1',
                                    'label'=>esc_html__('H1','news'),
                                ),
                                array(
                                    'value'=>'h2',
                                    'label'=>esc_html__('H2','news'),
                                ),
                                array(
                                    'value'=>'h3',
                                    'label'=>esc_html__('H3','news'),
                                ),
                                array(
                                    'value'=>'h4',
                                    'label'=>esc_html__('H4','news'),
                                ),
                                array(
                                    'value'=>'h5',
                                    'label'=>esc_html__('H5','news'),
                                ),
                                array(
                                    'value'=>'h6',
                                    'label'=>esc_html__('H6','news'),
                                ),
                            )
                        ),
                    ),
                ),
                /*----------------End Layout ----------------------*/

                /*----------------Begin Single ----------------------*/       
                array(
                    'id'          => 'sv_single_author_box',
                    'label'       => esc_html__('Show Author box','news'),
                    'type'        => 'on-off',
                    'section'     => 'option_single',
                    'std'         => 'on',
                ),
                array(
                    'id'          => 'sv_single_relate_box',
                    'label'       => esc_html__('Show Relate box','news'),
                    'type'        => 'on-off',
                    'section'     => 'option_single',
                    'std'         => 'on',
                ),
                array(
                    'id'          => 'sv_single_relate_bg',
                    'label'       => esc_html__('Relate background','news'),
                    'type'        => 'upload',
                    'section'     => 'option_single',
                    'condition'   => 'sv_single_relate_box:is(on)',
                ),

                /*----------------End Single----------------------*/

                /*----------------Begin Typography ----------------------*/
                array(
                    'id'          => 'sv_custom_typography',
                    'label'       => esc_html__('Add Settings','news'),
                    'type'        => 'list-item',
                    'section'     => 'option_typography',
                    'std'         => '',
                    'settings'    => array(
                        array(
                            'id'          => 'typo_area',
                            'label'       => esc_html__('Choose Area to style','news'),
                            'type'        => 'select',
                            'std'        => 'main',
                            'choices'     => array(
                                array(
                                    'value'=>'header',
                                    'label'=>esc_html__('Header','news'),
                                ),
                                array(
                                    'value'=>'main',
                                    'label'=>esc_html__('Main Content','news'),
                                ),
                                array(
                                    'value'=>'widget',
                                    'label'=>esc_html__('Widget','news'),
                                ),
                                array(
                                    'value'=>'footer',
                                    'label'=>esc_html__('Footer','news'),
                                ),
                            )
                        ),
                        array(
                            'id'          => 'typo_heading',
                            'label'       => esc_html__('Choose heading Area','news'),
                            'type'        => 'select',
                            'std'        => 'h3',
                            'choices'     => array(
                                array(
                                    'value'=>'h1',
                                    'label'=>esc_html__('H1','news'),
                                ),
                                array(
                                    'value'=>'h2',
                                    'label'=>esc_html__('H2','news'),
                                ),
                                array(
                                    'value'=>'h3',
                                    'label'=>esc_html__('H3','news'),
                                ),
                                array(
                                    'value'=>'h4',
                                    'label'=>esc_html__('H4','news'),
                                ),
                                array(
                                    'value'=>'h5',
                                    'label'=>esc_html__('H5','news'),
                                ),
                                array(
                                    'value'=>'h6',
                                    'label'=>esc_html__('H6','news'),
                                ),
                                array(
                                    'value'=>'a',
                                    'label'=>esc_html__('a','news'),
                                ),
                                array(
                                    'value'=>'p',
                                    'label'=>esc_html__('p','news'),
                                ),
                            )
                        ),
                        array(
                            'id'          => 'typography_style',
                            'label'       => esc_html__('Add Style','news'),
                            'type'        => 'typography',
                            'section'     => 'option_typography',
                        ),
                    ),
                ),        
                array(
                    'id'          => 'google_fonts',
                    'label'       => esc_html__('Add Google Fonts','news'),
                    'type'        => 'google-fonts',
                    'section'     => 'option_typography',
                ),
                /*----------------End Typography ----------------------*/

                /*----------------Begin Event --------------------*/
                array(
                    'id'          => 'sv_header_page_event',
                    'label'       => esc_html__( 'Header Event', 'news' ),
                    'desc'        => esc_html__( 'Include page to Header', 'news' ),
                    'type'        => 'select',
                    'section'     => 'option_event',
                    'choices'     => sv_list_header_page()
                ),
                array(
                    'id'          => 'sv_footer_page_event',
                    'label'       => esc_html__( 'Footer Page', 'news' ),
                    'desc'        => esc_html__( 'Include page to Footer', 'news' ),
                    'type'        => 'page-select',
                    'section'     => 'option_event'
                ),
                /*----------------End Event ----------------------*/
            )
        );
        if(class_exists( 'WooCommerce' )){
            array_push($sv_config['theme-option']['sections'], array(
                                                        'id' => 'option_woo',
                                                        'title' => '<i class="fa fa-shopping-cart"></i>'.esc_html__(' Shop Settings', 'news')
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'sv_header_page_woo',
                                                        'label'       => esc_html__( 'Header WooCommerce Page', 'news' ),
                                                        'desc'        => esc_html__( 'Include page to Header', 'news' ),
                                                        'type'        => 'select',
                                                        'section'     => 'option_woo',
                                                        'choices'     => sv_list_header_page()
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'sv_footer_page_woo',
                                                        'label'       => esc_html__( 'Footer WooCommerce Page', 'news' ),
                                                        'desc'        => esc_html__( 'Include page to Footer', 'news' ),
                                                        'type'        => 'page-select',
                                                        'section'     => 'option_woo'
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'show_header',
                                                        'label'       => esc_html__('Show header shop','news'),
                                                        'type'        => 'on-off',
                                                        'section'     => 'option_woo',
                                                        'std'         => 'on'
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'header_bg',
                                                        'label'       => esc_html__('Header Image','news'),
                                                        'type'        => 'upload',
                                                        'section'     => 'option_woo',
                                                        'condition'   => 'show_header:is(on)',
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'header_url',
                                                        'label'       => esc_html__('Header Link','news'),
                                                        'type'        => 'Text',
                                                        'section'     => 'option_woo',
                                                        'condition'   => 'show_header:is(on)',
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'sv_sidebar_position_woo',
                                                        'label'       => esc_html__('Sidebar Position WooCommerce page','news'),
                                                        'type'        => 'select',
                                                        'section'     => 'option_woo',
                                                        'desc'=>esc_html__('Left, or Right, or Center','news'),
                                                        'choices'     => array(
                                                            array(
                                                                'value'=>'no',
                                                                'label'=>esc_html__('No Sidebar','news'),
                                                            ),
                                                            array(
                                                                'value'=>'left',
                                                                'label'=>esc_html__('Left','news'),
                                                            ),
                                                            array(
                                                                'value'=>'right',
                                                                'label'=>esc_html__('Right','news'),
                                                            )
                                                        )
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'sv_sidebar_woo',
                                                        'label'       => esc_html__('Sidebar select WooCommerce page','news'),
                                                        'type'        => 'sidebar-select',
                                                        'section'     => 'option_woo',
                                                        'condition'   => 'sv_sidebar_position_woo:not(no)',
                                                        'desc'        => esc_html__('Choose one style of sidebar for WooCommerce page','news'),

                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'woo_shop_column',
                                                        'label'       => esc_html__('Choose shop column','news'),
                                                        'type'        => 'select',
                                                        'section'     => 'option_woo',
                                                        'choices'     => array(                                                    
                                                            array(
                                                                'value'=> 1,
                                                                'label'=> 1,
                                                            ),
                                                            array(
                                                                'value'=> 2,
                                                                'label'=> 2,
                                                            ),
                                                            array(
                                                                'value'=> 3,
                                                                'label'=> 3,
                                                            ),
                                                            array(
                                                                'value'=> 4,
                                                                'label'=> 4,
                                                            ),
                                                        )
                                                    ));
        }
    }
}
sv_set_theme_config();