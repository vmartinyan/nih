<?php

/*
Widget Name: Livemesh Posts Carousel
Description: Display blog posts or custom post types as a carousel.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/

class LVCA_Posts_Carousel {

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_posts_carousel', array($this, 'shortcode_func'));

        add_action('init', array($this, 'map_vc_element'));

    }

    function load_scripts() {

        wp_enqueue_script('lvca-post-carousel', plugin_dir_url(__FILE__) . 'js/posts-carousel' . LVCA_BUNDLE_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_script('lvca-slick-carousel', LVCA_PLUGIN_URL . 'assets/js/slick' . LVCA_BUNDLE_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_style('lvca-slick', LVCA_PLUGIN_URL . 'assets/css/slick.css', array(), LVCA_VERSION);

        wp_enqueue_style('lvca-posts-carousel', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);

    }

    public function shortcode_func($atts, $content = null, $tag) {

        $defaults = array_merge(
            array('posts_query' => '',
                  'display_title' => '',
                  'display_summary' => '',
                  'display_author' => '',
                  'display_post_date' => '',
                  'display_taxonomy' => '',
                  'taxonomy_chosen' => 'category',
                  'image_linkable' => ''),
            lvca_get_default_atts_carousel()
        );

        $settings = shortcode_atts($defaults, $atts);

        $posts_query = $settings['posts_query'];

        if (is_array($posts_query)) {
            $posts_query['post_status'] = 'publish';
        }
        else {
            $posts_query .= '|post_status:publish';
        }
        if (function_exists('vc_build_loop_query')) {
            list($args, $loop) = vc_build_loop_query($posts_query);
        }
        else {
            // just display first 10 posts if the user came directly to this shortcode
            $loop = new WP_Query(array('posts_per_page' => 10, 'ignore_sticky_posts' => 1));
        }

        $output = '';

        // Loop through the posts and do something with them.
        if ($loop->have_posts()) :

            ob_start(); ?>

            <?php

            // get me all array key value pairs except for those keys listed
            $carousel_settings = array_diff_key($settings,
                array('posts_query' => '', 'image_linkable' => '', 'display_title' => '', 'display_summary' => ''));

            ?>

            <?php $uniqueid = uniqid(); ?>

        <div id="lvca-posts-carousel-<?php echo $uniqueid; ?>"
             class="lvca-posts-carousel lvca-container"<?php foreach ($carousel_settings as $key => $val) {
            if (!empty($val)) {
                echo ' data-' . $key . '="' . esc_attr($val) . '"';
            }
        } ?>>

            <?php $taxonomy = $settings['taxonomy_chosen']; ?>

            <?php while ($loop->have_posts()) : $loop->the_post(); ?>

        <div data-id="id-<?php the_ID(); ?>" class="lvca-posts-carousel-item">

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <?php if ($thumbnail_exists = has_post_thumbnail()): ?>

                <div class="lvca-project-image">

                    <?php if ($settings['image_linkable']): ?>

                        <a href="<?php the_permalink(); ?>"> <?php the_post_thumbnail('large'); ?> </a>

                    <?php else: ?>

                        <?php the_post_thumbnail('large'); ?>

                    <?php endif; ?>

                    <div class="lvca-image-info">

                        <div class="lvca-entry-info">

                            <?php the_title('<h3 class="lvca-post-title"><a href="' . get_permalink() . '" title="' . get_the_title() . '"
                                               rel="bookmark">', '</a></h3>'); ?>

                            <?php echo lvca_get_taxonomy_info($taxonomy); ?>

                        </div>

                    </div>

                    <div class="lvca-image-overlay"></div>

                </div>

            <?php endif; ?>

            <?php if ($settings['display_title'] || $settings['display_summary']) : ?>

                <div
                    class="lvca-entry-text-wrap <?php echo($thumbnail_exists ? '' : ' nothumbnail'); ?>">

                    <?php if ($settings['display_title']) : ?>

                        <?php the_title('<h3 class="entry-title"><a href="' . get_permalink() . '" title="' . get_the_title() . '"
                                               rel="bookmark">', '</a></h3>'); ?>

                    <?php endif; ?>

                    <?php if ($settings['display_post_date'] || $settings['display_author'] || $settings['display_taxonomy']) : ?>

                        <div class="lvca-entry-meta">

                            <?php if ($settings['display_author']): ?>

                                <?php echo lvca_entry_author(); ?>

                            <?php endif; ?>

                            <?php if ($settings['display_post_date']): ?>

                                <?php echo lvca_entry_published(); ?>

                            <?php endif; ?>

                            <?php if ($settings['display_taxonomy']): ?>

                                <?php echo lvca_get_taxonomy_info($taxonomy); ?>

                            <?php endif; ?>

                        </div>

                    <?php endif; ?>

                    <?php if ($settings['display_summary']) : ?>

                        <div class="entry-summary">

                            <?php echo get_the_excerpt(); ?>

                        </div>

                    <?php endif; ?>

                </div>

            <?php endif; ?>

            </article>
            <!-- .hentry -->

            </div><!--.lvca-posts-carousel-item -->

        <?php endwhile; ?>

            <?php wp_reset_postdata(); ?>

            </div> <!-- .lvca-posts-carousel -->

            <?php  $output = ob_get_clean();

        endif;

        return $output;
    }


    function map_vc_element() {
        if (function_exists("vc_map")) {

            $carousel_params = array(

                array(
                    'type' => 'loop',
                    'param_name' => 'posts_query',
                    'heading' => __('Posts query', 'livemesh-vc-addons'),
                    'value' => 'size:10|order_by:date',
                    'settings' => array(
                        'size' => array(
                            'hidden' => false,
                            'value' => 10,
                        ),
                        'order_by' => array('value' => 'date'),
                        'post_type' => array(
                            'hidden' => false,
                            'value' => 'jetpack-portfolio',
                        ),
                    ),
                    'description' => __('Create WordPress loop, to populate content from your site.', 'livemesh-vc-addons'),
                    'admin_label' => true
                ),

                array(
                    'type' => 'checkbox',
                    'param_name' => 'image_linkable',
                    'heading' => __('Link Images to Posts?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                ),

                array(
                    'type' => 'dropdown',
                    'param_name' => 'taxonomy_chosen',
                    'heading' => __('Choose the taxonomy to display info.', 'livemesh-vc-addons'),
                    'description' => __('Choose the taxonomy to use for display of taxonomy information for posts/custom post types.', 'livemesh-vc-addons'),
                    'value' => lvca_get_taxonomies_map(),
                    'std' => 'category',
                    'group' => __('Post Info', 'livemesh-vc-addons'),
                ),
                
                array(
                    'type' => 'checkbox',
                    'param_name' => 'display_title',
                    'heading' => __('Display posts title below the post item?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    'group' => __('Post Info', 'livemesh-vc-addons'),
                ),

                array(
                    'type' => 'checkbox',
                    'param_name' => 'display_author',
                    'heading' => __('Display post author info below the post item?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    'group' => __('Post Info', 'livemesh-vc-addons'),
                ),

                array(
                    'type' => 'checkbox',
                    'param_name' => 'display_post_date',
                    'heading' => __('Display post date info below the post item?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    'group' => __('Post Info', 'livemesh-vc-addons'),
                ),


                array(
                    'type' => 'checkbox',
                    'param_name' => 'display_taxonomy',
                    'heading' => __('Display taxonomy info below the post item?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    'group' => __('Post Info', 'livemesh-vc-addons'),
                ),

                array(
                    'type' => 'checkbox',
                    'param_name' => 'display_summary',
                    'heading' => __('Display post excerpt/summary below the post item?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    'group' => __('Post Info', 'livemesh-vc-addons'),
                ),
            );

            $carousel_params = array_merge($carousel_params, lvca_get_vc_map_carousel_options('Options'));

            $carousel_params = array_merge($carousel_params, lvca_get_vc_map_carousel_display_options());

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Livemesh Posts Carousel", "livemesh-vc-addons"),
                "base" => "lvca_posts_carousel",
                "content_element" => true,
                "show_settings_on_create" => true,
                "category" => __("Livemesh VC Addons", "livemesh-vc-addons"),
                'description' => __('Display posts or post types as a carousel.', 'livemesh-vc-addons'),
                "icon" => 'icon-lvca-posts-carousel',
                "params" => $carousel_params
            ));


        }
    }

}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_posts_carousel extends WPBakeryShortCode {
    }
}