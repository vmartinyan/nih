<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(!class_exists('SV_Mailchimp_Widget'))
{
    class SV_Mailchimp_Widget extends WP_Widget {


        protected $default=array();

        static function _init()
        {
            add_action( 'widgets_init', array(__CLASS__,'_add_widget') );
        }

        static function _add_widget()
        {
            register_widget( 'SV_Mailchimp_Widget' );
        }

        function __construct() {
            // Instantiate the parent object
            parent::__construct( false, esc_html__('Mailchimp Widget','news'),
                array( 'description' => esc_html__( 'Get Mailchimp Form', 'news' ), ));

            $this->default=array(
                'title'     => '',
                'form_id'     => '',
                'des1'    => '',
            );
        }

        function widget( $args, $instance ) {
            // Widget output
           echo balancetags($args['before_widget']);            
            $instance = wp_parse_args($instance,$this->default);
            extract($instance);
            $form_html = apply_filters('sv_remove_autofill',do_shortcode('[mc4wp_form id="'.$form_id.'"]'));
            $html =    '<div class="newsletter4">
                            <h2>'.$title.'</h2>
                            <p>'.$des1.'</p>
                            '.$form_html.'
                        </div>';
            echo balancetags($html);
            echo balancetags($args['after_widget']);
        }

        function update( $new_instance, $old_instance ) {

            // Save widget options
            $instance=array();
            $instance=wp_parse_args($instance,$this->default);
            $new_instance=wp_parse_args($new_instance,$instance);

            return $new_instance;
        }

        function form( $instance ) {
            // Output admin widget options form

            $instance=wp_parse_args($instance,$this->default);
            extract($instance);
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:' ,'news'); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('form_id')); ?>"><?php esc_html_e('Form ID', 'news'); ?>: </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('form_id')); ?>" name="<?php echo esc_attr($this->get_field_name('form_id')); ?>" type="text" value="<?php echo esc_attr($form_id); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('des1')); ?>"><?php esc_html_e('Description 1', 'news'); ?>: </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('des1')); ?>" name="<?php echo esc_attr($this->get_field_name('des1')); ?>" type="text" value="<?php echo esc_attr($des1); ?>" />
            </p>
        <?php
        }
    }

    SV_Mailchimp_Widget::_init();

}
