<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(class_exists('Vc_Manager')){
    function sv_add_custom_shortcode_param( $name, $form_field_callback, $script_url = null ) {
        return WpbakeryShortcodeParams::addField( $name, $form_field_callback, $script_url );
    }

    sv_add_custom_shortcode_param('add_mission', 'sv_add_mission', get_template_directory_uri(). '/assets/js/vc_js.js');
    
    // function mission
    function sv_add_mission($settings, $value)
    {
        $val = $value;
        $html = '<div class="st_add_mission">';
        
        parse_str(urldecode($value), $mission);
        if(is_array($mission)) 
        {
            $i = 1;
            foreach ($mission as $key => $value) {
                if(!isset($value['url'])) $value['url'] = '';
                $html .= '<div class="mission-item" data-item="'.$i.'">';
                    $html .= '<label>'.esc_html__("Mission","news").' '.$i.':</label></br><label>'.esc_html__("Year","news").' </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-mission" name="'.$i.'[year]" value="'.$value['year'].'" type="text" ></br>';
                    $html .= '<label>'.esc_html__("Percent","news").' </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-mission" name="'.$i.'[percent]" value="'.$value['percent'].'" type="text" ></br>';
                    $html .= '<label>'.esc_html__("Description","news").' </label></br><textarea style="width:80%;margin-bottom:15px" class="st-mission" name="'.$i.'[description]" type="text" >'.$value['description'].'</textarea>';
                    $html .= '<a style="color:red" href="#" class="st-del-item">'.esc_html__("Delete","news").'</a>';
                $html .= '</div>';
                $i++;
            }
        }
        $html .= '</div>';
        $html .= '<div class="st-add"><button class="vc_btn vc_btn-primary vc_btn-sm st-button-add" type="button">'.esc_html__('Add mission', 'news').' </button></div>';
        $html .= '<input name="'.$settings['param_name'].'" class="st-mission-value wpb_vc_param_value wpb-textinput '.$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'.$val.'">';
        return $html;
    }

    sv_add_custom_shortcode_param('add_social', 'sv_add_social', get_template_directory_uri(). '/assets/js/vc_js.js');
    
    // function social
    function sv_add_social($settings, $value)
    {
        $val = $value;
        $html = '<div class="st_add_social">';
        
        parse_str(urldecode($value), $social);
        if(is_array($social)) 
        {
            $i = 1;
            foreach ($social as $key => $value) {
                if(!isset($value['url'])) $value['url'] = '';
                $html .= '<div class="social-item" data-item="'.$i.'">';
                    $html .= '<label>'.esc_html__("Social","news").' '.$i.':</label></br><label>'.esc_html__("Icon","news").' </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-social sv_iconpicker" name="'.$i.'[social]" value="'.$value['social'].'" type="text" ></br>';
                    $html .= '<label>'.esc_html__("Link","news").' </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-social" name="'.$i.'[url]" value="'.$value['url'].'" type="text" >';
                    $html .= '<a style="color:red" href="#" class="st-del-item">'.esc_html__("Delete","news").'</a>';
                $html .= '</div>';
                $i++;
            }
        }
        $html .= '</div>';
        $html .= '<div class="st-add"><button class="vc_btn vc_btn-primary vc_btn-sm st-button-add" type="button">'.esc_html__('Add social', 'news').' </button></div>';
        $html .= '<input name="'.$settings['param_name'].'" class="st-social-value wpb_vc_param_value wpb-textinput '.$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'.$val.'">';
        return $html;
    }

    // Mutil location param

    sv_add_custom_shortcode_param('add_location_map', 'sv_add_location_map', get_template_directory_uri(). '/assets/js/vc_js.js');

    function sv_add_location_map($settings, $value)
    {
        $val = $value;
        $html = '<div class="st_add_location">';
        
        parse_str(urldecode($value), $locations);
        if(is_array($locations)) 
        {
            $i = 1;
            foreach ($locations as $key => $value) {
                $html .= '<div class="location-item" data-item="'.$i.'">';
                    $html .= '<div class="wpb_element_label">'.esc_html__("Location",'news').' '.$i.'</div>';
                    $html .= '<label>'.esc_html__("Latitude",'news').'</label><input class="st-input st-location-save st-title" name="'.$i.'[lat]" value="'.$value['lat'].'" type="text" >';
                    $html .= '<label>'.esc_html__("Longitude",'news').'</label><input class="st-input st-location-save st-des" name="'.$i.'[lon]" value="'.$value['lon'].'" type="text" >';
                    $html .= '<label>'.esc_html__("Marker Title",'news').'</label><input class="st-input st-location-save st-label" name="'.$i.'[title]" value="'.$value['title'].'" type="text" >';
                    $html .= '<label>'.esc_html__("Info Box",'news').'</label>';
                    $html .= '<label>'.esc_html__("Info Box",'news').'</label><textarea id="content'.$i.'" class="st-input st-location-save info-content" name="'.$i.'[boxinfo]">'.$value['boxinfo'].'</textarea>';
                    $html .= '<a href="#" class="st-del-item">'.esc_html__("delete","news").'</a>';
                $html .= '</div>';
                $i++;
            }
        }
        $html .= '</div>';
        $html .= '<div class="add-location"><button style="margin-top: 10px;padding: 5px 12px" class="vc_btn vc_btn-primary vc_btn-sm st-location-add-map" type="button">'.esc_html__('Add more', 'news').' </button></div>';
        $html .= '<input name="'.$settings['param_name'].'" class="st-location-value wpb_vc_param_value wpb-textinput '.$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'.$val.'">';
        return $html;
    }

    // Mutil location param

    if(!class_exists('SV_VisualComposerController'))
    {
        class  SV_VisualComposerController
        {

            static function _init()
            {
                add_filter('vc_shortcodes_css_class',array(__CLASS__,'_change_class'), 10, 2);
            }

            static function _custom_vc_param()
            {
               
            }

            static function _change_class($class_string, $tag)
            {
                if($tag=='vc_row' || $tag=='vc_row_inner') {
                    $class_string = str_replace('vc_row-fluid', '', $class_string);
                }

                if(defined ('WPB_VC_VERSION'))
                {
                    if(version_compare(WPB_VC_VERSION,'4.2.3','>'))
                    {
                        if($tag=='vc_column' || $tag=='vc_column_inner') {
                            $class_string=str_replace('vc_col', 'col', $class_string);
                        }
                    }else
                    {
                        if($tag=='vc_column' || $tag=='vc_column_inner') {
                            $class_string = preg_replace('/vc_span(\d{1,2})/', 'col-lg-$1', $class_string);
                        }
                    }
                }

                return $class_string;
            }

        }    

        SV_VisualComposerController::_init();
        SV_VisualComposerController:: _custom_vc_param(); 
    }
    
}