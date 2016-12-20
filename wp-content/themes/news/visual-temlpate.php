<?php
/*
 * Template Name: Visual Template
 *
 *
 * */

$sidebar=sv_get_sidebar();
$sidebar_pos=$sidebar['position'];
$main_class = 'col-md-12 col-sm-12 col-xs-12';
if($sidebar_pos != 'no') $main_class = 'col-md-9 col-sm-8 col-xs-12 blog-sidebar-'.$sidebar_pos;
get_header();
?>
    <div id="main-content" class="visual-page">
        <div class="container">
            <div class="row">
                <?php if($sidebar_pos=='left'){ get_sidebar(); }?>
                <div class="<?php echo esc_attr($main_class); ?>">
                    <?php
                    while ( have_posts() ) : the_post();

                        /*
                        * Include the post format-specific template for the content. If you want to
                        * use this in a child theme, then include a file called called content-___.php
                        * (where ___ is the post format) and that will be used instead.
                        */
                        ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <div class="entry-content">
                                    <?php the_content(); ?>
                                    <?php
                                        wp_link_pages( array(
                                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'news' ),
                                            'after'  => '</div>',
                                        ) );
                                    ?>
                                </div><!-- .entry-content -->
                            </article><!-- #post-## -->
                        <?php

                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number()) :
                            comments_template();
                        endif;



                        // End the loop.
                    endwhile; ?>
                </div>
                <?php if($sidebar_pos=='right'){ get_sidebar(); }?>
            </div>
        </div>
    </div>
<?php
get_footer();