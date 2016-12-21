<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */

add_action('admin_init', 'sv_custom_meta_boxes');
if(!function_exists('sv_custom_meta_boxes')){
    function sv_custom_meta_boxes(){
        //Format content
        $format_metabox = array(
            'id' => 'block_format_content',
            'title' => esc_html__('Format Settings', 'news'),
            'desc' => '',
            'pages' => array('post'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(                
                array(
                    'id' => 'format_image',
                    'label' => esc_html__('Upload Image', 'news'),
                    'type' => 'upload',
                ),
                array(
                    'id' => 'format_gallery',
                    'label' => esc_html__('Add Gallery', 'news'),
                    'type' => 'Gallery',
                ),
                array(
                    'id' => 'format_media',
                    'label' => esc_html__('Link Media', 'news'),
                    'type' => 'text',
                ),
                array(
                    'id' => 'time_video',
                    'label' => esc_html__('Time Video', 'news'),
                    'type' => 'text',
                )
            ),
        );
        // SideBar
    	$sidebar_metabox_default = array(
            'id'        => 'sv_sidebar_option',
            'title'     => 'Advanced Settings',
            'desc'      => '',
            'pages'     => array( 'page','post','product'),
            'context'   => 'side',
            'priority'  => 'low',
            'fields'    => array(
                array(
                    'id'          => 'sv_sidebar_position',
                    'label'       => esc_html__('Sidebar position ','news'),
                    'type'        => 'select',
                    'std' => '',
                    'choices'     => array(
                        array(
                            'label'=>esc_html__('--Select--','news'),
                            'value'=>'',
                        ),
                        array(
                            'label'=>esc_html__('No Sidebar','news'),
                            'value'=>'no'
                        ),
                        array(
                            'label'=>esc_html__('Left sidebar','news'),
                            'value'=>'left'
                        ),
                        array(
                            'label'=>esc_html__('Right sidebar','news'),
                            'value'=>'right'
                        ),
                    ),

                ),
                array(
                    'id'        =>'sv_select_sidebar',
                    'label'     =>esc_html__('Selects sidebar','news'),
                    'type'      =>'sidebar-select',
                    'condition' => 'sv_sidebar_position:not(no),sv_sidebar_position:not()',
                ),
                array(
                    'id'          => 'sv_show_breadrumb',
                    'label'       => esc_html__('Show Breadcrumb','news'),
                    'type'        => 'select',
                    'choices'     => array(
                        array(
                            'label'=>esc_html__('--Select--','news'),
                            'value'=>'',
                        ),
                        array(
                            'label'=>esc_html__('Yes','news'),
                            'value'=>'yes'
                        ),
                        array(
                            'label'=>esc_html__('No','news'),
                            'value'=>'no'
                        ),
                    ),

                ),
                array(
                    'id'          => 'sv_header_page',
                    'label'       => esc_html__('Choose page header','news'),
                    'type'        => 'select',
                    'choices'     => sv_list_header_page()
                ),
                array(
                    'id'          => 'sv_footer_page',
                    'label'       => esc_html__('Choose page footer','news'),
                    'type'        => 'page-select'
                ),
                array(
                    'id'          => 'sv_bg_body',
                    'label'       => esc_html__('Body Background','news'),
                    'type'        => 'background',
                ),
                array(
                    'id'          => 'sv_font_body',
                    'label'       => esc_html__('Body Font','news'),
                    'type'        => 'typography',
                ),
                array(
                    'id'          => 'show_header',
                    'label'       => esc_html__('Show Header','news'),
                    'type'        => 'select',
                    'choices'     => array(
                        array(
                            'label'=>esc_html__('--Select--','news'),
                            'value'=>'',
                        ),
                        array(
                            'label'=>esc_html__('Yes','news'),
                            'value'=>'yes'
                        ),
                        array(
                            'label'=>esc_html__('No','news'),
                            'value'=>'no'
                        ),
                    ),

                ),
                array(
                    'id'        =>'header_bg',
                    'label'     =>esc_html__('Header Image','news'),
                    'type'      =>'upload',
                    'condition' => 'show_header:is(yes)',
                ),
                array(
                    'id'        =>'header_url',
                    'label'     =>esc_html__('Header Link','news'),
                    'type'      =>'text',
                    'condition' => 'show_header:is(yes)',
                ),
            )
        );
        // Blog metabox
        $magazine_metabox = array(
            'id'        => 'sv_blog_meta',
            'title'     => 'Set type post',
            'pages'     => array( 'post' ),
            'context'   => 'side',
            'priority'  => 'high',
            'fields'    => array(
                array(
                    'id'          => 'trending_post',
                    'label'       => esc_html__('Trending Post','news'),
                    'type'        => 'on-off',
                    'std'         => 'off'
                ),
                array(
                    'id'          => 'featured_post',
                    'label'       => esc_html__('Featured Post','news'),
                    'type'        => 'on-off',
                    'std'         => 'off'
                ),
                array(
                    'id'          => 'time_update',
                    'label'       => esc_html__('Update in day','news'),
                    'type'        => 'date-picker'
                ),
            )
        );
        //Event meta
        $event_meta_box = array(
            'id'        => 'event_option',
            'title'     => esc_html__(  'Event Options' , 'news' ),
            'desc'      => '',
            'pages'     => array( 'event' ),
            'context'   => 'normal',
            'priority'  => 'high',
            'fields'    => array(
                array(
                    'id' => 'event_gallery',
                    'label' => esc_html__('Event Gallery', 'news'),
                    'type' => 'Gallery',
                ),
                array(
                    'id' => 'event_media',
                    'label' => esc_html__('Event Media', 'news'),
                    'type' => 'text',
                ),
                array(
                    'id' => 'event_site',
                    'label' => esc_html__('Event Link', 'news'),
                    'type' => 'text',
                ),
                array(
                    'id'                => 'event_date',
                    'label'             => esc_html__('Event Date', 'news'),
                    'desc'              => esc_html__('Choose date for this event.','news'),
                    'type'              => 'date-picker',
                ),
                array(
                    'id' => 'event_time',
                    'label' => esc_html__('Event Time', 'news'),
                    'type' => 'text',
                ),
                array(
                    'id' => 'event_location',
                    'label' => esc_html__('Event Location', 'news'),
                    'type' => 'text',
                ),
                array(
                    'id' => 'event_free',
                    'label' => esc_html__('Event Price', 'news'),
                    'type' => 'text',
                ),
            )
        );
        //Product Add Info Tab
        $product_info_tab = array(
            'id' => 'product_info_content',
            'title' => esc_html__('Add Custom Service Tab', 'news'),
            'pages' => array('product'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id' => 'custom_service',
                    'label' => esc_html__('Custom Service Content', 'news'),
                    'type' => 'Textarea',
                )
            ),
        );
        //Scroll top
        $scroll_top_meta = array(
            'id' => 'scroll_top_meta',
            'title' => esc_html__('Show Scroll top', 'news'),
            'pages' => array('page'),
            'context' => 'normal',
            'priority' => 'low',
            'fields' => array(
                array(
                    'id' => 'show_scroll_top',
                    'label' => esc_html__('Show Scroll top', 'news'),
                    'type' => 'on-off',
                    'std' => 'off',
                ),
                array(
                    'id'          => 'scroll_top_style',
                    'label'       => esc_html__('Scroll top Style','news'),
                    'type'        => 'select',
                    'std'         => 'scroll-top3',
                    'choices'     => array(
                        array(
                            'label'=>esc_html__('Style 1','news'),
                            'value'=>'scroll-top3',
                        ),
                        array(
                            'label'=>esc_html__('Style 2','news'),
                            'value'=>'scroll-top4'
                        ),
                    ),
                    'condition' => 'show_scroll_top:is(on)',
                ),
            ),
        );
        if (function_exists('ot_register_meta_box')){
            ot_register_meta_box($format_metabox);
            ot_register_meta_box($sidebar_metabox_default);
            ot_register_meta_box($magazine_metabox);
            ot_register_meta_box($event_meta_box);
            ot_register_meta_box($product_info_tab);
            ot_register_meta_box($scroll_top_meta);
        }
    }
}
// Icon Post category
add_action('category_add_form_fields', 'sv_category_metabox_add', 10, 1);
add_action('category_edit_form_fields', 'sv_category_metabox_edit', 10, 1);    
if(!function_exists('sv_category_metabox_add')){ 
    function sv_category_metabox_add($tag) { ?>
        <div class="form-field">
            <label for="cat-icon"><?php esc_html_e('Category icon','news') ?></label>
            <input name="cat-icon" id="cat-icon" type="text" value="" class="sv_iconpicker" />        
        </div>
        <div class="form-field">
            <label style="display: block;"><?php esc_html_e( 'Category thumbnail' ,'news');?></label>
            <img style="max-width: 100%; width:100px;" class ="image-preview" src="">
            <input id="cat-thumb" name="cat-thumb" type ="hidden" class ="custom_media_url images-img-link" value="">
            <button class="sv-button-upload" style="background: #00A0D2;  color: #fff;  border: none;  padding: 7px 10px;"><?php esc_html_e("Upload", 'news');?></button>
            <button class="sv-button-remove-upload" style="background: #d54e21;  color: #fff;  border: none;  padding: 7px 10px;"><?php esc_html_e("Remove", 'news');?></button>
        </div>
    <?php }
}
if(!function_exists('sv_category_metabox_edit')){  
    function sv_category_metabox_edit($tag) { ?>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="cat-icon"><?php esc_html_e('Category icon','news'); ?></label>
            </th>
            <td>
                <input name="cat-icon" id="cat-icon" type="text" value="<?php echo get_term_meta($tag->term_id, 'cat-icon', true); ?>" class="sv_iconpicker" />
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="cat-thumb"><?php esc_html_e('Category thumbnail','news'); ?></label>
            </th>
            <td>
                <img style="max-width: 100%; width:100px;" class ="image-preview" src="<?php echo get_term_meta($tag->term_id, 'cat-thumb', true); ?>">
                <input id="cat-thumb" name="cat-thumb" type ="hidden" class ="custom_media_url images-img-link" value="<?php echo get_term_meta($tag->term_id, 'cat-thumb', true); ?>">
                <button class="sv-button-upload" style="background: #00A0D2;  color: #fff;  border: none;  padding: 7px 10px;"><?php esc_html_e("Upload", 'news');?></button>
                <button class="sv-button-remove-upload" style="background: #d54e21;  color: #fff;  border: none;  padding: 7px 10px;"><?php esc_html_e("Remove", 'news');?></button>
            </td>
        </tr>
    <?php }
}
add_action('created_category', 'sv_save_category_metadata', 10, 1);    
add_action('edited_category', 'sv_save_category_metadata', 10, 1);
if(!function_exists('sv_save_category_metadata')){ 
    function sv_save_category_metadata($term_id)
    {
        if (isset($_POST['cat-icon'])) update_term_meta( $term_id, 'cat-icon', $_POST['cat-icon']);
        if (isset($_POST['cat-thumb'])) update_term_meta( $term_id, 'cat-thumb', $_POST['cat-thumb']);
    }
}
//end

// Gallery Event category
add_action('event_category_add_form_fields', 'sv_event_category_metabox_add', 10, 1);
add_action('event_category_edit_form_fields', 'sv_event_category_metabox_edit', 10, 1);    
if(!function_exists('sv_event_category_metabox_add')){ 
    function sv_event_category_metabox_add($tag) { 

        ?>
        <div class="form-field">
            <label><?php esc_html_e('Category Gallery','news'); ?></label>
            <div class="gallery-metabox">
                <div class="img-previews">
                </div>
                <a class="button button-primary sv-button-remove"> <?php esc_html_e("Remove","news")?></a>
                <a class="button button-primary sv-button-upload-img"> <?php esc_html_e("Edit Gallery","news")?></a>
                <input name="cat-gallery" type="hidden" class="sv-gallery-value multi-image-url" value=""></input>
            </div>
        </div>
    <?php }
}
if(!function_exists('sv_event_category_metabox_edit')){ 
    function sv_event_category_metabox_edit($tag) { ?>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="cat-gallery"><?php esc_html_e('Category Gallery','news'); ?></label>
            </th>
            <td>            
                <div class="gallery-metabox">
                    <div class="img-previews">
                        <?php 
                        $gallerys = get_term_meta($tag->term_id, 'cat-gallery', true);
                        $ga_array = json_decode($gallerys,true);
                        if(!empty($ga_array)){
                            foreach ($ga_array as $img) {
                                if(!empty($img)) echo '<img src="'.$img.'" style="width:100px; height:100px; padding:5px;">';
                            }
                        }
                        ?> 
                    </div>
                    <a class="button button-primary sv-button-remove"> <?php esc_html_e("Remove","news")?></a>
                    <a class="button button-primary sv-button-upload-img"> <?php esc_html_e("Edit Gallery","news")?></a>
                    <input name="cat-gallery" type="hidden" class="sv-gallery-value multi-image-url" value="<?php echo get_term_meta($tag->term_id, 'cat-gallery', true); ?>"></input>
                </div>            
            </td>
        </tr>
    <?php }
}
add_action('created_event_category', 'sv_event_save_category_metadata', 10, 1);    
add_action('edited_event_category', 'sv_event_save_category_metadata', 10, 1);
if(!function_exists('sv_event_save_category_metadata')){ 
    function sv_event_save_category_metadata($term_id)
    {
        if (isset($_POST['cat-gallery'])) 
            update_term_meta( $term_id, 'cat-gallery', $_POST['cat-gallery']);                  
    }
}
//end
?>