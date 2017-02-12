<?php

/*
Widget Name: Livemesh Portfolio
Description: Display portfolio items from Jetpack custom post types in multi-column grid.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/

class LVCA_Portfolio {

    private $_taxonomy_filter;

    /**
     * Get things started
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));

        add_shortcode('lvca_portfolio', array($this, 'shortcode_func'));

        // Do it as late as possible so that all taxonomies are registered
        add_action('init', array($this, 'map_vc_element'), 9999);

    }

    private function get_chosen_terms($query_args) {

        $chosen_terms = array();

        if (empty($query_args))
            return $chosen_terms;

        if (!empty($query_args['cat'])) {
            $this->_taxonomy_filter = 'category';
            $term_ids = explode(',', $query_args['cat']);
            foreach ($term_ids as $term_id) {
                $chosen_terms[] = get_term($term_id, 'category');
            }
        }
        elseif (!empty($query_args['tag__in'])) {
            $this->_taxonomy_filter = 'post_tag';
            $term_ids = $query_args['tag__in'];
            foreach ($term_ids as $term_id) {
                $chosen_terms[] = get_term($term_id, 'post_tag');
            }
        }
        elseif (!empty($query_args['tax_query'])) {
            $terms_query = $query_args['tax_query'];
            foreach ($terms_query as $term_query) {
                if (is_array($term_query) && ($term_query['field'] == 'term_id')) {
                    $chosen_terms[] = get_term($term_query['terms'], $term_query['taxonomy']);
                    $this->_taxonomy_filter = $term_query['taxonomy'];
                }
            }
        }
        return $chosen_terms;
    }

    function load_scripts() {

        wp_enqueue_script('lvca-isotope', LVCA_PLUGIN_URL . 'assets/js/isotope.pkgd' . LVCA_BUNDLE_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_script('lvca-imagesloaded', LVCA_PLUGIN_URL . 'assets/js/imagesloaded.pkgd' . LVCA_BUNDLE_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_script('lvca-portfolio', plugin_dir_url(__FILE__) . 'js/portfolio' . LVCA_BUNDLE_JS_SUFFIX . '.js', array('jquery'), LVCA_VERSION);

        wp_enqueue_style('lvca-portfolio', plugin_dir_url(__FILE__) . 'css/style.css', array(), LVCA_VERSION);

    }

    public function shortcode_func($atts, $content = null, $tag) {

        $defaults = array_merge(
            array(
                'heading' => '',
                'posts_query' => '',
                'display_title' => '',
                'display_author' => '',
                'display_post_date' => '',
                'display_taxonomy' => '',
                'display_summary' => '',
                'image_linkable' => '',
                'filterable' => '',
                'post_type' => 'jetpack-portfolio',
                'taxonomy_filter' => 'jetpack-portfolio-type',
                'per_line' => 4,
                'layout_mode' => 'fitRows',
                'packed' => '',
                'gutter' => 20,
                'tablet_gutter' => 10,
                'tablet_width' => 800,
                'mobile_gutter' => 10,
                'mobile_width' => 480
            )

        );

        $settings = shortcode_atts($defaults, $atts);

        $current_page = get_queried_object_id();

        $posts_query = $settings['posts_query'];

        if (is_array($posts_query)) {
            $posts_query['post_status'] = 'publish';
        }
        else {
            $posts_query .= '|post_status:publish';
        }
        if (function_exists('vc_build_loop_query')) {
            list($query_args, $loop) = vc_build_loop_query($posts_query);
        }
        else {
            $query_args = array();
            // just display first 10 portfolio items if the user came directly to this shortcode
            $loop = new WP_Query(array('posts_per_page' => 8, 'post_type' => $settings['post_type']));
        }

        $output = '';

        // Loop through the posts and do something with them.
        if ($loop->have_posts()) :

            ob_start(); ?>

            <div class="lvca-portfolio-wrap lvca-container">

                <?php
                // Check if any taxonomy filter has been applied
                $chosen_terms = $this->get_chosen_terms($query_args);
                if (empty($chosen_terms))
                    $this->_taxonomy_filter = $settings['taxonomy_filter'];
                ?>

                <?php $column_style = lvca_get_column_class(intval($settings['per_line'])); ?>

                <div class="lvca-portfolio-header">

                    <?php if (!empty($settings['heading'])) ?>

                    <h3 class="lvca-heading"><?php echo wp_kses_post($settings['heading']); ?></h3>

                    <?php

                    if ($settings['filterable'])
                        echo lvca_get_taxonomy_terms_filter($this->_taxonomy_filter, $chosen_terms);

                    ?>

                </div>

                <?php $uniqueid = uniqid(); ?>

                <div id="lvca-portfolio-<?php echo $uniqueid; ?>"
                     class="lvca-portfolio js-isotope lvca-<?php echo $settings['layout_mode']; ?>"
                     data-gutter="<?php echo $settings['gutter']; ?>"
                     data-tablet_gutter="<?php echo $settings['tablet_gutter']; ?>"
                     data-tablet_width="<?php echo $settings['tablet_width']; ?>"
                     data-mobile_gutter="<?php echo $settings['mobile_gutter']; ?>"
                     data-mobile_width="<?php echo $settings['mobile_width']; ?>"
                     data-isotope-options='{ "itemSelector": ".lvca-portfolio-item", "layoutMode": "<?php echo esc_attr($settings['layout_mode']); ?>" }'>

                    <?php while ($loop->have_posts()) : $loop->the_post(); ?>

                        <?php
                        if (get_the_ID() === $current_page)
                            continue; // skip the current page since they can run into infinite loop when users choose All option in build query
                        ?>

                        <?php
                        $style = '';
                        $terms = get_the_terms(get_the_ID(), $this->_taxonomy_filter);
                        if (!empty($terms) && !is_wp_error($terms)) {
                            foreach ($terms as $term) {
                                $style .= ' term-' . $term->term_id;
                            }
                        }
                        ?>

                        <div data-id="id-<?php the_ID(); ?>"
                             class="lvca-portfolio-item <?php echo $style; ?> <?php echo $column_style; ?> lvca-zero-margin">

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

                                                <?php echo lvca_get_taxonomy_info($this->_taxonomy_filter); ?>

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

                                                    <?php echo lvca_get_taxonomy_info($this->_taxonomy_filter); ?>

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

                        </div><!--Isotope element -->

                    <?php endwhile; ?>

                    <?php wp_reset_postdata(); ?>

                </div>
                <!-- Isotope items -->

            </div>

            <?php  $output = ob_get_clean();

        endif;

        return $output;
    }


    function map_vc_element() {
        if (function_exists("vc_map")) {

            $general_params = array(

                array(
                    'type' => 'textfield',
                    'param_name' => 'heading',
                    'heading' => __('Heading for the portfolio/blog', 'livemesh-vc-addons'),
                ),

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
                    'description' => __('Create WordPress loop, to populate content from your site. After you build the query, make sure you choose the right taxonomy below to display for your posts and filter on, based on the post type selected during build query.', 'livemesh-vc-addons'),
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
                    'param_name' => 'taxonomy_filter',
                    'heading' => __('Choose the taxonomy to display and filter on.', 'livemesh-vc-addons'),
                    'description' => __('Choose the taxonomy information to display for posts/portfolio and the taxonomy that is used to filter the portfolio/post. Takes effect only if no query category/tag/taxonomy filters are specified when building query.', 'livemesh-vc-addons'),
                    'value' => lvca_get_taxonomies_map(),
                    'std' => 'jetpack-portfolio-type',
                    'group' => 'Options'
                ),

                array(
                    'type' => 'checkbox',
                    'param_name' => 'display_title',
                    'heading' => __('Display posts title below the post/portfolio item?', 'livemesh-vc-addons'),
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
                    'heading' => __('Display taxonomy info below the post/portfolio item?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    'group' => __('Post Info', 'livemesh-vc-addons'),
                ),

                array(
                    'type' => 'checkbox',
                    'param_name' => 'display_summary',
                    'heading' => __('Display post excerpt/summary below the post/portfolio item?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    'group' => __('Post Info', 'livemesh-vc-addons'),
                ),
            );

            $display_params = array(

                array(
                    'type' => 'checkbox',
                    'param_name' => 'filterable',
                    'heading' => __('Filterable?', 'livemesh-vc-addons'),
                    "value" => array(__("Yes", "livemesh-vc-addons") => 'true'),
                    'group' => 'Options'
                ),

                array(
                    'type' => 'dropdown',
                    'param_name' => 'layout_mode',
                    'heading' => __('Choose a layout for the portfolio/blog', 'livemesh-vc-addons'),
                    'value' => array(
                        __('Fit Rows', 'livemesh-vc-addons') => 'fitRows',
                        __('Masonry', 'livemesh-vc-addons') => 'masonry',
                    ),
                    'std' => 'fitRows',
                    'group' => 'Options'
                ),

                array(
                    'type' => 'lvca_number',
                    'param_name' => 'per_line',
                    'heading' => __('Columns per row', 'livemesh-vc-addons'),
                    'min' => 1,
                    'max' => 5,
                    'integer' => true,
                    'value' => 3
                ),

                array(
                    'type' => 'lvca_number',
                    'param_name' => 'gutter',
                    'heading' => __('Gutter', 'livemesh-vc-addons'),
                    'description' => __('Space between columns.', 'livemesh-vc-addons'),
                    'value' => 20,
                    'group' => 'Options'
                ),
            );

            $responsive_params = array(

                array(
                    'type' => 'lvca_number',
                    'param_name' => 'tablet_gutter',
                    'heading' => __('Gutter in Tablets', 'livemesh-vc-addons'),
                    'description' => __('Space between columns in tablets.', 'livemesh-vc-addons'),
                    'value' => 10,
                    'group' => 'Responsive'
                ),

                array(
                    'type' => 'textfield',
                    'param_name' => 'tablet_width',
                    'heading' => __('Tablet Resolution', 'livemesh-vc-addons'),
                    'description' => __('The resolution to treat as a tablet resolution.', 'livemesh-vc-addons'),
                    'std' => 800,
                    'sanitize' => 'intval',
                    'group' => 'Responsive'
                ),

                array(
                    'type' => 'lvca_number',
                    'param_name' => 'mobile_gutter',
                    'heading' => __('Gutter in Mobiles', 'livemesh-vc-addons'),
                    'description' => __('Space between columns in mobiles.', 'livemesh-vc-addons'),
                    'value' => 10,
                    'group' => 'Responsive'
                ),

                array(
                    'type' => 'textfield',
                    'param_name' => 'mobile_width',
                    'heading' => __('Mobile Resolution', 'livemesh-vc-addons'),
                    'description' => __('The resolution to treat as a mobile resolution.', 'livemesh-vc-addons'),
                    'std' => 480,
                    'sanitize' => 'intval',
                    'group' => 'Responsive'
                )
            );

            $params = array_merge($general_params, $display_params, $responsive_params);

            //Register "container" content element. It will hold all your inner (child) content elements
            vc_map(array(
                "name" => __("Livemesh Grid", "livemesh-vc-addons"),
                "base" => "lvca_portfolio",
                "content_element" => true,
                "show_settings_on_create" => true,
                "category" => __("Livemesh VC Addons", "livemesh-vc-addons"),
                'description' => __('Display work or posts with a filterable grid.', 'livemesh-vc-addons'),
                "icon" => 'icon-lvca-portfolio',
                "params" => $params
            ));


        }
    }

}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_lvca_portfolio extends WPBakeryShortCode {
    }
}