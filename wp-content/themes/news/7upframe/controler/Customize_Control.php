<?php   
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 17/09/15
 * Time: 10:20 AM
 */

if(!class_exists('SV_CustomizeConfig'))
{
    class SV_CustomizeConfig
    {
        public function __construct(){
            add_action( 'customize_controls_enqueue_scripts', array($this,'sv_loading_script') );
            if(class_exists('OT_Loader')){
                add_action( 'customize_register', array($this,'sv_customizer_register'));
            }
        }

        public function sv_sanitize_callback($value)
        {
            return $value;
        }

        public function sv_loading_script()
        {
            wp_enqueue_script( 'sv-customizer-js', get_template_directory_uri().'/assets/admin/js/customizer.js', array(), null, true);
        }

        public function sv_customizer_register($wp_customize){
            global $sv_config;
            $option_name = ot_options_id();
            $options = get_option( ot_options_id() );
            $sections = $sv_config['theme-option']['sections'];
            $settings = $sv_config['theme-option']['settings'];
            $wp_customize->add_panel( 'theme_option', array(
                'priority'       => 10,
                'capability'     => 'edit_theme_options',
                'title'          => 'Theme Settings',
            ) );
            foreach ($sections as $key => $section) {
                $g_title = explode('</i>', $section['title']);
                $title = $g_title[1];
                $wp_customize->add_section( $section['id'], array(
                    'priority'       => $key,
                    'capability'     => 'edit_theme_options',
                    'title'          => $title,
                    'panel'          => 'theme_option',
                ));
                
                foreach ($settings as $key2 => $setting) {
                    if($setting['section'] == $section['id'] && isset($options[$setting['id']])){
                        $wp_customize->add_setting( $option_name.'['.$setting['id'].']', array(
                            'default'           => $options[$setting['id']],
                            'capability'        => 'edit_theme_options',
                            'type'           => 'option',
                            'sanitize_callback' => array($this, 'sv_sanitize_callback')
                            )
                        );
                        switch ($setting['type']) {
                            case 'upload':
                                $wp_customize->add_control( 
                                    new WP_Customize_Image_Control( 
                                    $wp_customize, 
                                    $option_name.'['.$setting['id'].']',
                                    array(
                                        'label'      => $setting['label'],
                                        'section'    => $setting['section'],
                                        'settings'   => $option_name.'['.$setting['id'].']',
                                        'priority'   => $key.$key2
                                    ) ) 
                                );
                                break;

                            case 'textarea-simple':
                                $wp_customize->add_control(
                                    new WP_Customize_Control(
                                        $wp_customize,
                                        $option_name.'['.$setting['id'].']',
                                        array(
                                            'label'      => $setting['label'],
                                            'section'    => $setting['section'],
                                            'settings'   => $option_name.'['.$setting['id'].']',
                                            'type'       => 'textarea'
                                        )
                                    )
                                );
                                break;

                            case 'page-select':
                                $wp_customize->add_control(
                                    new WP_Customize_Control(
                                        $wp_customize,
                                        $option_name.'['.$setting['id'].']',
                                        array(
                                            'label'      => $setting['label'],
                                            'section'    => $setting['section'],
                                            'settings'   => $option_name.'['.$setting['id'].']',
                                            'type'       => 'dropdown-pages'
                                        )
                                    )
                                );
                                break;

                            case 'background':
                                $wp_customize->add_control(
                                    new SV_Customize_Bg(
                                        $wp_customize,
                                        $option_name.'['.$setting['id'].']',
                                        array(
                                            'label'      => $setting['label'],
                                            'section'    => $setting['section'],
                                            'settings1'   => $option_name.'['.$setting['id'].']',                                            
                                        )
                                    )
                                );
                                break;

                            case 'typography':
                                $wp_customize->add_control(
                                    new SV_Customize_Typography(
                                        $wp_customize,
                                        $option_name.'['.$setting['id'].']',
                                        array(
                                            'label'      => $setting['label'],
                                            'section'    => $setting['section'],
                                            'settings1'  => $option_name.'['.$setting['id'].']',
                                            'key_id'     => $setting['id'],
                                        )
                                    )
                                );
                                break;

                            case 'colorpicker':
                                $wp_customize->add_control(
                                    new WP_Customize_Color_Control(
                                        $wp_customize,
                                        $option_name.'['.$setting['id'].']',
                                        array(
                                            'label'      => $setting['label'],
                                            'section'    => $setting['section'],
                                            'settings'   => $option_name.'['.$setting['id'].']'
                                        )
                                    )
                                );
                                break;

                            case 'select':
                                $choices = $setting['choices'];
                                $customize_choices = array();
                                foreach ($choices as $choice) {
                                    $customize_choices[$choice['value']] = $choice['label'];
                                }
                                $wp_customize->add_control(
                                    new WP_Customize_Control(
                                        $wp_customize,
                                        $option_name.'['.$setting['id'].']',
                                        array(
                                            'label'      => $setting['label'],
                                            'section'    => $setting['section'],
                                            'settings'   => $option_name.'['.$setting['id'].']',
                                            'type'       => 'select',
                                            'class'       => 'select-sidebar',
                                            'choices'   => $customize_choices
                                        )
                                    )
                                );
                                unset($customize_choices);
                                break;

                            case 'sidebar-select':
                                global $wp_registered_sidebars;
                                $customize_choices = array('' => '-- Choose Sidebar --');
                                foreach ($wp_registered_sidebars as $choice) {
                                    $customize_choices[$choice['id']] = $choice['name'];
                                }
                                $wp_customize->add_control(
                                    new WP_Customize_Control(
                                        $wp_customize,
                                        $option_name.'['.$setting['id'].']',
                                        array(
                                            'label'      => $setting['label'],
                                            'section'    => $setting['section'],
                                            'settings'   => $option_name.'['.$setting['id'].']',
                                            'type'       => 'select',
                                            'choices'   => $customize_choices
                                        )
                                    )
                                );
                                unset($customize_choices);
                                break;

                            case 'on-off':
                                $wp_customize->add_control(
                                    new WP_Customize_Control(
                                        $wp_customize,
                                        $option_name.'['.$setting['id'].']',
                                        array(
                                            'label'      => $setting['label'],
                                            'section'    => $setting['section'],
                                            'settings'   => $option_name.'['.$setting['id'].']',
                                            'type'       => 'radio',
                                            'choices'    => array(
                                                'on'     => 'On',
                                                'off'    => 'Off'
                                                )
                                        )
                                    )
                                );
                                break;
                            
                            default:
                                # code...
                                break;
                        }
                    }
                    
                }
            }
        }       

    }
    new SV_CustomizeConfig;
}
if(class_exists('WP_Customize_Control')){
    class SV_Customize_Bg extends WP_Customize_Control{
        public $label;
        public $settings1;
        public function render_content() {
            if(!is_array($this->value())) $values = json_decode(urldecode($this->value()),true);
            else $values = $this->value();
            $setting_id = str_replace('[', '-', $this->settings1);
            $setting_id = str_replace(']', '', $setting_id);
            ?>
            <div class="format-setting type-background <?php echo esc_attr($setting_id);?>" data-setting="<?php echo esc_attr($this->settings1);?>">
                <?php if(!empty($this->label)) echo '<span class="customize-control-title">'.$this->label.'</span>';?>
                <div class="format-setting-inner">
                    <div class="ot-background-group">
                        <div class="option-tree-ui-colorpicker-input-wrap">
                            <input type="text" name="<?php echo esc_attr($this->settings1);?>[background-color]" id="<?php echo esc_attr($this->settings1);?>-picker" value="<?php echo esc_attr($values['background-color']);?>" class="hide-color-picker sv-background-color sv-color-picker">
                        </div>
                        <select name="<?php echo esc_attr($this->settings1);?>[background-repeat]" id="<?php echo esc_attr($this->settings1);?>-repeat" class="option-tree-ui-select sv-background-repeat">
                            <option value="" <?php if($values['background-repeat'] == '') echo'selected="selected"';?>><?php esc_html_e('background-repeat','news');?></option>
                            <option value="no-repeat" <?php if($values['background-repeat'] == 'no-repeat') echo'selected="selected"';?>><?php esc_html_e('No Repeat','news');?></option>
                            <option value="repeat" <?php if($values['background-repeat'] == 'repeat') echo'selected="selected"';?>><?php esc_html_e('Repeat All','news');?></option>
                            <option value="repeat-x" <?php if($values['background-repeat'] == 'repeat-x') echo'selected="selected"';?>><?php esc_html_e('Repeat Horizontally','news');?></option>
                            <option value="repeat-y" <?php if($values['background-repeat'] == 'repeat-y') echo'selected="selected"';?>><?php esc_html_e('Repeat Vertically','news');?></option>
                            <option value="inherit" <?php if($values['background-repeat'] == 'inherit') echo'selected="selected"';?>><?php esc_html_e('Inherit','news');?></option>
                        </select>
                        <select name="<?php echo esc_attr($this->settings1);?>[background-attachment]" id="<?php echo esc_attr($this->settings1);?>-attachment" class="option-tree-ui-select sv-background-attachment">
                            <option value="" <?php if($values['background-attachment'] == '') echo'selected="selected"';?>><?php esc_html_e('background-attachment','news');?></option>
                            <option value="fixed" <?php if($values['background-attachment'] == 'fixed') echo'selected="selected"';?>><?php esc_html_e('Fixed','news');?></option>
                            <option value="scroll" <?php if($values['background-attachment'] == 'scroll') echo'selected="selected"';?>><?php esc_html_e('Scroll','news');?></option>
                            <option value="inherit" <?php if($values['background-attachment'] == 'inherit') echo'selected="selected"';?>><?php esc_html_e('Inherit','news');?></option>
                        </select>
                        <select name="<?php echo esc_attr($this->settings1);?>[background-position]" id="<?php echo esc_attr($this->settings1);?>-position" class="option-tree-ui-select sv-background-position">
                            <option value="" <?php if($values['background-position'] == '') echo'selected="selected"';?>><?php esc_html_e('background-position','news');?></option>
                            <option value="left top" <?php if($values['background-position'] == 'left top') echo'selected="selected"';?>><?php esc_html_e('Left Top','news');?></option>
                            <option value="left center" <?php if($values['background-position'] == 'left center') echo'selected="selected"';?>><?php esc_html_e('Left Center','news');?></option>
                            <option value="left bottom" <?php if($values['background-position'] == 'left bottom') echo'selected="selected"';?>><?php esc_html_e('Left Bottom','news');?></option>
                            <option value="center top" <?php if($values['background-position'] == 'center top') echo'selected="selected"';?>><?php esc_html_e('Center Top','news');?></option>
                            <option value="center center" <?php if($values['background-position'] == 'center center') echo'selected="selected"';?>><?php esc_html_e('Center Center','news');?></option>
                            <option value="center bottom" <?php if($values['background-position'] == 'center bottom') echo'selected="selected"';?>><?php esc_html_e('Center Bottom','news');?></option>
                            <option value="right top" <?php if($values['background-position'] == 'right top') echo'selected="selected"';?>><?php esc_html_e('Right Top','news');?></option>
                            <option value="right center" <?php if($values['background-position'] == 'right center') echo'selected="selected"';?>><?php esc_html_e('Right Center','news');?></option>
                            <option value="right bottom" <?php if($values['background-position'] == 'right bottom') echo'selected="selected"';?>><?php esc_html_e('Right Bottom','news');?></option>
                        </select>
                        <input type="text" name="<?php echo esc_attr($this->settings1);?>[background-size]" id="<?php echo esc_attr($this->settings1);?>-size" value="<?php echo esc_attr($values['background-size']);?>" class="widefat ot-background-size-input option-tree-ui-input sv-background-size" placeholder="background-size">
                    </div>
                    <div class="option-tree-ui-upload-parent">
                        <img <?php if(empty($values['background-image'])) echo 'style="display:none"';?> style="margin-top:10px" src="<?php echo esc_url($values['background-image']);?>"/>
                        <input type="hidden" name="<?php echo esc_attr($this->settings1);?>[background-image]" id="<?php echo esc_attr($this->settings1);?>-image" value="<?php echo esc_attr($values['background-image']);?>" class="widefat option-tree-ui-upload-input sv-background-image" placeholder="background-image">
                        <a href="#" class="ot_upload_media option-tree-ui-button button button-primary light upload_single_image" rel="4" title="<?php esc_attr_e('Add Media','news'); ?>">
                            <span class="icon ot-icon-plus-circle"></span><?php esc_html_e('Add Media','news');?>
                        </a>
                        <a <?php if(empty($values['background-image'])) echo 'style="display:none"';?> href="#" class="ot_upload_media option-tree-ui-button button button-primary light remove_single_image" rel="4" title="<?php esc_attr_e('Add Media','news'); ?>">
                            <span class="icon ot-icon-plus-circle"></span><?php esc_html_e('Remove','news');?>
                        </a>
                    </div>
                </div>
            </div>
            <?php
        }
    }  

    class SV_Customize_Typography extends WP_Customize_Control{
        public $label;
        public $settings1;
        public $key_id;
        public function render_content() {
            if(!is_array($this->value())) $values = json_decode(urldecode($this->value()),true);
            else $values = $this->value();
            $setting_id = str_replace('[', '-', $this->settings1);
            $setting_id = str_replace(']', '', $setting_id);
            ?>
            <div class="format-setting type-typography <?php echo esc_attr($setting_id);?>" data-setting="<?php echo esc_attr($this->settings1);?>">
                <?php if(!empty($this->label)) echo '<span class="customize-control-title">'.$this->label.'</span>';?>
                <div class="format-setting-inner">
                    <div class="wp-picker-container">
                        <span style="vertical-align: top"><?php esc_html_e('Choose Color','news')?></span>
                        <input type="text" name="<?php echo esc_attr($this->settings1);?>[font-color]" value="<?php echo esc_attr($values['font-color'])?>" class="hide-color-picker sv-color-picker sv-typography-font-color">
                    </div>
                    <div class="select-wrapper">
                        <span><?php esc_html_e('Font Family','news')?></span>
                        <select name="<?php echo esc_attr($this->settings1);?>[font-family]" class="option-tree-ui-select sv-typography-font-family">
                            <option <?php if($values['font-family'] == '') echo'selected="selected"';?> value=""><?php esc_html_e('font-family','news')?></option>
                            <?php 
                            if(function_exists('ot_recognized_font_families')) $family_list = ot_recognized_font_families($this->key_id);
                            else $family_list = array();
                            if(!empty($family_list)){
                                foreach ($family_list as $key => $value) {
                                    if($values['font-family'] == $key) $selected = 'selected="selected"';
                                    else $selected = '';
                                    echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                } 
                            }
                            ?>                            
                        </select>
                    </div>
                    <div class="select-wrapper">
                        <span><?php esc_html_e('Font Size','news')?></span>
                        <select name="<?php echo esc_attr($this->settings1);?>[font-size]" class="option-tree-ui-select sv-typography-font-size">
                            <option <?php if($values['font-size'] == '') echo'selected="selected"';?> value=""><?php esc_html_e('font-size','news')?></option>
                            <?php for ($i=0; $i <= 150; $i++) { 
                                if($values['font-size'] == $i.'px') $selected = 'selected="selected"';
                                else $selected = '';
                                echo '<option value="'.$i.'px" '.$selected.'>'.$i.'px</option>';
                            }?>
                        </select>
                    </div>
                    <div class="select-wrapper">
                        <span><?php esc_html_e('Font Style','news')?></span>
                        <select name="<?php echo esc_attr($this->settings1);?>[font-style]" class="option-tree-ui-select sv-typography-font-style">
                            <option <?php if($values['font-style'] == '') echo'selected="selected"';?> value=""><?php esc_html_e('font-style','news')?></option>
                            <option <?php if($values['font-style'] == 'normal') echo'selected="selected"';?> value="normal"><?php esc_html_e('Normal','news')?></option>
                            <option <?php if($values['font-style'] == 'italic') echo'selected="selected"';?> value="italic"><?php esc_html_e('Italic','news')?></option>
                            <option <?php if($values['font-style'] == 'oblique') echo'selected="selected"';?> value="oblique"><?php esc_html_e('Oblique','news')?></option>
                            <option <?php if($values['font-style'] == 'inherit') echo'selected="selected"';?> value="inherit"><?php esc_html_e('Inherit','news')?></option>
                        </select>
                    </div>
                    <div class="select-wrapper">
                        <span><?php esc_html_e('Font Variant','news')?></span>
                        <select name="<?php echo esc_attr($this->settings1);?>[font-variant]" class="option-tree-ui-select sv-typography-font-variant">
                            <option <?php if($values['font-variant'] == '') echo'selected="selected"';?> value=""><?php esc_html_e('font-variant','news')?></option>
                            <option <?php if($values['font-variant'] == 'normal') echo'selected="selected"';?> value="normal"><?php esc_html_e('Normal','news')?></option>
                            <option <?php if($values['font-variant'] == 'small-caps') echo'selected="selected"';?> value="small-caps"><?php esc_html_e('Small Caps','news')?></option>
                            <option <?php if($values['font-variant'] == 'inherit') echo'selected="selected"';?> value="inherit"><?php esc_html_e('Inherit','news')?></option>
                        </select>
                    </div>
                    <div class="select-wrapper">
                        <span><?php esc_html_e('Font Weight','news')?></span>
                        <select name="<?php echo esc_attr($this->settings1);?>[font-weight]" class="option-tree-ui-select sv-typography-font-weight">
                            <option <?php if($values['font-weight'] == '') echo'selected="selected"';?> value=""><?php esc_html_e('font-weight','news')?></option>
                            <option <?php if($values['font-weight'] == 'normal') echo'selected="selected"';?> value="normal"><?php esc_html_e('Normal','news')?></option>
                            <option <?php if($values['font-weight'] == 'bold') echo'selected="selected"';?> value="bold"><?php esc_html_e('Bold','news')?></option>
                            <option <?php if($values['font-weight'] == 'bolder') echo'selected="selected"';?> value="bolder"><?php esc_html_e('Bolder','news')?></option>
                            <option <?php if($values['font-weight'] == 'lighter') echo'selected="selected"';?> value="lighter"><?php esc_html_e('Lighter','news')?></option>
                            <option <?php if($values['font-weight'] == '100') echo'selected="selected"';?> value="100"><?php esc_html_e('100','news')?></option>
                            <option <?php if($values['font-weight'] == '200') echo'selected="selected"';?> value="200"><?php esc_html_e('200','news')?></option>
                            <option <?php if($values['font-weight'] == '300') echo'selected="selected"';?> value="300"><?php esc_html_e('300','news')?></option>
                            <option <?php if($values['font-weight'] == '400') echo'selected="selected"';?> value="400"><?php esc_html_e('400','news')?></option>
                            <option <?php if($values['font-weight'] == '500') echo'selected="selected"';?> value="500"><?php esc_html_e('500','news')?></option>
                            <option <?php if($values['font-weight'] == '600') echo'selected="selected"';?> value="600"><?php esc_html_e('600','news')?></option>
                            <option <?php if($values['font-weight'] == '700') echo'selected="selected"';?> value="700"><?php esc_html_e('700','news')?></option>
                            <option <?php if($values['font-weight'] == '800') echo'selected="selected"';?> value="800"><?php esc_html_e('800','news')?></option>
                            <option <?php if($values['font-weight'] == '900') echo'selected="selected"';?> value="900"><?php esc_html_e('900','news')?></option>
                            <option <?php if($values['font-weight'] == 'inherit') echo'selected="selected"';?> value="inherit"><?php esc_html_e('Inherit','news')?></option>
                        </select>
                    </div>
                    <div class="select-wrapper">
                        <span><?php esc_html_e('Letter Spacing','news')?></span>
                        <select name="<?php echo esc_attr($this->settings1);?>[letter-spacing]" class="option-tree-ui-select sv-typography-letter-spacing">
                            <?php $spacing_array = array(
                                ''         => 'letter-spacing',
                                '-0.1em'   => '-0.1em',
                                '-0.09em'  => '-0.09em',
                                '-0.08em'  => '-0.08em',
                                '-0.07em'  => '-0.07em',
                                '-0.06em'  => '-0.06em',
                                '-0.05em'  => '-0.05em',
                                '-0.04em'  => '-0.04em',
                                '-0.03em'  => '-0.03em',
                                '-0.02em'  => '-0.02em',
                                '-0.01em'  => '-0.01em',
                                '0em'      => '0em',
                                '0.01em'   => '0.01em',
                                '0.02em'   => '0.02em',
                                '0.03em'   => '0.03em',
                                '0.04em'   => '0.04em',
                                '0.05em'   => '0.05em',
                                '0.06em'   => '0.06em',
                                '0.07em'   => '0.07em',
                                '0.08em'   => '0.08em',
                                '0.09em'   => '0.09em',
                                '0.1em'    => '0.1em'
                            );
                            foreach ($spacing_array as $key => $value) {
                                if($values['letter-spacing'] == $key) $selected = 'selected="selected"';
                                else $selected = '';
                                echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                            }
                            ?>                            
                        </select>
                    </div>
                    <div class="select-wrapper">
                        <span><?php esc_html_e('Line Height','news')?></span>
                        <select name="<?php echo esc_attr($this->settings1);?>[line-height]" class="option-tree-ui-select sv-typography-line-height">
                            <option <?php if($values['line-height'] == '') echo'selected="selected"';?> value=""><?php esc_html_e('line-height','news')?></option>
                            <?php for ($i=0; $i <= 150; $i++) { 
                                if($values['line-height'] == $i.'px') $selected = 'selected="selected"';
                                else $selected = '';
                                echo '<option value="'.$i.'px" '.$selected.'>'.$i.'px</option>';
                            }?>
                        </select>
                    </div>
                    <div class="select-wrapper">
                        <span><?php esc_html_e('Text Decoration','news')?></span>
                        <select name="<?php echo esc_attr($this->settings1);?>[text-decoration]" class="option-tree-ui-select sv-typography-text-decoration">
                            <?php $decoration_array = array(
                                ''              => 'text-decoration',
                                'blink'         => 'Blink',
                                'inherit'       => 'Inherit',
                                'line-through'  => 'Line Through',
                                'none'          => 'None',
                                'overline'      => 'Overline',
                                'underline'     => 'Underline'
                            );
                            foreach ($decoration_array as $key => $value) {
                                if($values['text-decoration'] == $key) $selected = 'selected="selected"';
                                else $selected = '';
                                echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="select-wrapper">
                        <span><?php esc_html_e('Text Transform','news')?></span>
                        <select name="<?php echo esc_attr($this->settings1);?>[text-transform]" class="option-tree-ui-select sv-typography-text-transform">
                            <?php $transform_array = array(
                                ''              => 'text-transform',
                                'capitalize'    => 'Capitalize',
                                'inherit'       => 'Inherit',
                                'lowercase'     => 'Lowercase',
                                'none'          => 'None',
                                'uppercase'     => 'Uppercase',
                            );
                            foreach ($transform_array as $key => $value) {
                                if($values['text-transform'] == $key) $selected = 'selected="selected"';
                                else $selected = '';
                                echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                            }
                            ?>
                            
                        </select>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}
