<?php
class SV_Widget_Recent_Posts extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_recent_entries', 'description' => esc_html__( "The most recent posts on your site","news") );
        parent::__construct('recent-posts', esc_html__('Recent Posts',"news"), $widget_ops);
        $this->alt_option_name = 'widget_recent_entries';
    }

    function widget($args, $instance) {
        $cache = wp_cache_get('widget_recent_posts', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo esc_attr($cache[ $args['widget_id'] ]);
            return;
        }

        ob_start();
        extract($args);

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Recent Posts',"news");
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 10;
        if ( ! $number )
            $number = 10;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

        $r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
        if ($r->have_posts()) :
?>
        <?php echo balanceTags($before_widget); ?>
        <?php if ( $title ) echo ''.$before_title . $title . $after_title; ?>
        <div class="content-widget-latest-post">
        <?php while ( $r->have_posts() ) : $r->the_post(); ?>
        <?php 
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
        ?>
            <div class="post-item">
                <div class="post-thumb">
                    <?php if(has_post_thumbnail()) the_post_thumbnail(array(338,221));?>
                </div>
                <div class="post-info">
                    <div class="post-format">
                        <?php echo balanceTags($term_html);?>
                    </div>
                    <h3 class="post-title">
                        <a href="<?php echo esc_url(get_the_permalink()) ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a>
                    </h3>
                    <div class="number-post-comment">
                        <span class="lnr lnr-bubble"></span> <strong><?php echo get_comments_number();?></strong>
                        <?php if ( $show_date ) : ?>
                            <span class="post-date"><?php echo get_the_date('F j, Y'); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>            
        <?php endwhile; ?>
        </div>
        <?php echo balanceTags($after_widget); ?>
<?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_posts', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = (bool) $new_instance['show_date'];

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_recent_entries']) )
            delete_option('widget_recent_entries');

        return $instance;
    }

    function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
        <p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:',"news" ); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

        <p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e( 'Number of posts to show:',"news" ); ?></label>
        <input id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" /></p>

        <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_date' )); ?>" />
        <label for="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>"><?php esc_html_e( 'Display post date?',"news" ); ?></label></p>
<?php
    }
}
function sv_register_Widget_Recent_Posts() {
    register_widget( 'SV_Widget_Recent_Posts' );
}
// add_action( 'widgets_init', 'sv_register_Widget_Recent_Posts' );