<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(!class_exists('SV_Trending_Widget'))
{
    class SV_Trending_Widget extends WP_Widget {


        protected $default=array();

        static function _init()
        {
            add_action( 'widgets_init', array(__CLASS__,'_add_widget') );
        }

        static function _add_widget()
        {
            register_widget( 'SV_Trending_Widget' );
        }

        function __construct() {
            // Instantiate the parent object
            parent::__construct( false, esc_html__('Trending Widget','news'),
                array( 'description' => esc_html__( 'Get Trending Post', 'news' ), ));

            $this->default=array(
                'title'     => '',
                'number'    => 6,
            );
        }

        function widget( $args, $instance ) {
            // Widget output
           echo balancetags($args['before_widget']);            
            $instance = wp_parse_args($instance,$this->default);
            extract($instance);
            $args_post = array(
                'post_type'         => 'post',
                'posts_per_page'    => $number,
            );
            $args_post['meta_query']['relation'] = 'OR';
            $args_post['meta_query'][] = array(
                    'key'     => 'trending_post',
                    'value'   => 'on',
                    'compare' => '=',
                );
            $query = new WP_Query($args_post);
            $count = 1;
            $count_query = $query->post_count;   
            $html =    '<div class="trending-box4">
                            <div class="trending-box-title">
                                '.$title.'
                            </div>
                            <div class="list-trending-box">
                                <div class="wrap-item">';
            if($query->have_posts()) {
                while($query->have_posts()) {
                    $query->the_post();
                    if($count % 3 == 1) $html .= '<div class="item">';                                            
                    $html .=            '<div class="item-trending-box">
                                            <h3><a href="'.esc_url(get_the_permalink()).'">'.$count.'. '.get_the_title().'</a></h3>
                                            <p>'.substr(get_the_excerpt(),0,60).'</p>
                                            <div class="trending-box-thumb">
                                                <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(230,130)).'</a>
                                                <span class="trending-comment">'.get_comments_number().'</span>
                                            </div>
                                        </div>';
                    if($count % 3 == 0 || $count == $count_query) $html .= '</div>';
                    $count++;
                }
            }
            wp_reset_postdata();
            $html .=            '</div>
                            </div>
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
                <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number', 'news'); ?>: </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
            </p>
            
        <?php
        }
    }

    SV_Trending_Widget::_init();

}
