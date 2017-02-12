<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(!class_exists('SV_Post_Tab_Widget'))
{
    class SV_Post_Tab_Widget extends WP_Widget {


        protected $default=array();

        static function _init()
        {
            add_action( 'widgets_init', array(__CLASS__,'_add_widget') );
        }

        static function _add_widget()
        {
            register_widget( 'SV_Post_Tab_Widget' );
        }

        function __construct() {
            // Instantiate the parent object
            parent::__construct( false, esc_html__('Post Tab Widget','news'),
                array( 'description' => esc_html__( 'Get post tab slider', 'news' ), ));

            $this->default=array(
                'title'     => '',
                'number'     => '',
            );
        }

        function widget( $args, $instance ) {
            // Widget output
            echo balancetags($args['before_widget']);
            if ( ! empty( $instance['title'] ) ) {
               echo balancetags($args['before_title']) . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
            }
            $instance = wp_parse_args($instance,$this->default);
            extract($instance);
            $args_post=array(
                'post_type'         => 'post',
                'posts_per_page'    => $number,
            );
            $html =    '<div class="most-read-popular">
                            <div class="title-most-read-tab">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#mostread" aria-controls="mostread" role="tab" data-toggle="tab">'.esc_html__("recent","news").'</a></li>
                                    <li role="presentation"><a href="#popularread" aria-controls="popularread" role="tab" data-toggle="tab">'.esc_html__("popular","news").'</a></li>
                                </ul>
                            </div>
                            <div class="content-most-read-tab">
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="mostread">
                                        <div class="most-read-slider">
                                            <div class="wrap-item">';        
            $query = new WP_Query($args_post);
            $count = 1;
            $count_query = $query->post_count;
            if($query->have_posts()) {
                while($query->have_posts()) {
                    $query->the_post();
                    if($count % 4 == 1) $html .=    '<div class="item">';
                    $html .=        '<div class="item-most-read clearfix">
                                        <div class="most-read-thumb">
                                            <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(120,80)).'</a>
                                        </div>
                                        <div class="most-read-info">
                                            <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                            <span class="most-read-date"><span class="lnr lnr-clock"></span> '.get_the_time('d M Y').'</span>
                                        </div>
                                    </div>';
                    if($count % 4 == 0 || $count == $count_query) $html .=    '</div>';
                    $count++;
                }
            }
            $html .=                        '</div>
                                        </div>
                                    </div>';
            $html .=                '<div role="tabpanel" class="tab-pane" id="popularread">
                                        <div class="most-read-slider">
                                            <div class="wrap-item">';
            $args_post['orderby'] = 'meta_value_num';
            $args_post['meta_key'] = 'post_views';
            $query = new WP_Query($args_post);
            $count = 1;
            $count_query = $query->post_count;
            if($query->have_posts()) {
                while($query->have_posts()) {
                    $query->the_post();
                    if($count % 4 == 1) $html .=    '<div class="item">';
                    $html .=        '<div class="item-most-read clearfix">
                                        <div class="most-read-thumb">
                                            <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(120,80)).'</a>
                                        </div>
                                        <div class="most-read-info">
                                            <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                            <span class="most-read-date"><span class="lnr lnr-clock"></span> '.get_the_time('d M Y').'</span>
                                        </div>
                                    </div>';
                    if($count % 4 == 0 || $count == $count_query) $html .=    '</div>';
                    $count++;
                }
            }
            $html .=                        '</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
            wp_reset_postdata();
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
            <p>
        <?php
        }
    }

    SV_Post_Tab_Widget::_init();

}
