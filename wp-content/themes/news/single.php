<?php
/**
 * The template for displaying all single posts.
 *
 * @package 7up-framework
 */
?>
<?php get_header();?>
<?php 
$sidebar=sv_get_sidebar();
$sidebar_pos=$sidebar['position'];
$main_class = 'col-md-12 col-sm-12 col-xs-12 content-no-sidebar';
if($sidebar_pos != 'no') $main_class = 'col-md-9 col-sm-8 col-xs-12';
    ?>
    <div id="main-content"  class="single-content main-content-blog2">
        <div class="container">
            <div class="row">
                <?php if($sidebar_pos=='left'){ get_sidebar(); }?>
                <div class="<?php echo esc_attr($main_class); ?>">
                    <?php
                    while ( have_posts() ) : the_post();
                        sv_set_post_view();
                        /*
                        * Include the post format-specific template for the content. If you want to
                        * use this in a child theme, then include a file called called content-___.php
                        * (where ___ is the post format) and that will be used instead.
                        */
                        get_template_part( 'sv_templates/single-content-light/content',get_post_format() );
                        ?>
                        <?php 
                            wp_link_pages( array(
                                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'news' ),
                                'after'  => '</div>',
                                'link_before' => '<span>',
                                'link_after'  => '</span>',
                            ) );
                        ?>
                        <div class="single-list-tags">
                            <label> <?php esc_html_e("tags:","news")?></label>
                            <?php
                                $tags = get_the_tag_list(' ',', ',' ');
                                if($tags) $tags_html = $tags;
                                else $tags_html = esc_html__("No Tags","news");
                                echo balanceTags($tags_html);
                            ?>
                        </div>
                        <?php sv_single_related_post_light();?>
                        <?php
                            if ( comments_open() || get_comments_number() ) { comments_template(); }
                        ?>
                        <?php
                            $previous_post = get_previous_post();
                            $next_post = get_next_post();
                        ?>
                        <div class="post-control2">
                            <?php if(!empty( $previous_post )):?>
                                <a href="<?php echo esc_url(get_the_permalink( $previous_post->ID )); ?>" class="prev-post"><span class="lnr lnr-arrow-left"></span> <span class="control-post-text"><?php esc_html_e("prev post","news")?></span></a>
                            <?php endif;?>
                            <?php if(!empty( $next_post )):?>
                                <a href="<?php echo esc_url(get_the_permalink( $next_post->ID )); ?>" class="next-post"><span class="control-post-text"><?php esc_html_e("next post","news")?></span> <span class="lnr lnr-arrow-right"></span></a>
                            <?php endif;?>
                        </div>
                    <?php endwhile; ?>
                </div>
                <?php if($sidebar_pos=='right'){ get_sidebar(); }?>
            </div>
        </div>
    </div>
<?php get_footer();?>