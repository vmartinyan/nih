<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package 7up-framework
 */
$sidebar=sv_get_sidebar();
$sidebar_pos=$sidebar['position'];
$main_class = 'col-md-12 col-sm-12 col-xs-12 content-no-sidebar';
if($sidebar_pos != 'no') $main_class = 'col-md-9 col-sm-8 col-xs-12 blog-sidebar blog-sidebar-'.$sidebar_pos;
get_header();?>
<div id="main-content" class="main-wrapper">
    <?php do_action('sv_before_main_content')?>
    <div id="tp-blog-page" class="tp-blog-page"><!-- blog-page -->
        <div class="container">
            <div class="row">
                <?php if($sidebar_pos=='left'){ get_sidebar(); }?>
                <div class="<?php echo esc_attr($main_class); ?>">
                	
                    <?php if(have_posts()):?>    
    				    <?php while (have_posts()) :the_post();?>
    						
                            <?php get_template_part('sv_templates/blog-content/content',get_post_format())?>
    					
                        <?php endwhile;?>
    				    <?php wp_reset_postdata();?>

    				    <?php sv_paging_nav();?>

    				<?php else : ?>
    				    <?php get_template_part( 'sv_templates/blog-content/content', 'none' ); ?>
    				<?php endif;?>

                </div>
                <?php if($sidebar_pos=='right'){ get_sidebar(); }?>
            </div>
        </div>
    </div>
    <?php do_action('sv_affter_main_content')?>
</div>
<?php get_footer(); ?>