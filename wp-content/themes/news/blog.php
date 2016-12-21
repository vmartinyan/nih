<?php
/*
 * Template Name: Blog Template
 *
 *
 * */
$sidebar=sv_get_sidebar();
$sidebar_pos=$sidebar['position'];
$main_class = 'col-md-12 col-sm-12 col-xs-12 content-no-sidebar';
if($sidebar_pos != 'no') $main_class = 'col-md-9 col-sm-8 col-xs-12 blog-sidebar blog-sidebar-'.$sidebar_pos;
get_header();?>
<div id="main-content" class="main-wrapper st-default content-page">
    <div class="container">
        <div class="row">
            <?php if($sidebar_pos=='left'){ get_sidebar(); }?>
            <div class="<?php echo esc_attr($main_class); ?>">
            	<?php 
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    query_posts('post_type=post&paged='.$paged );
                ?>
                <?php if(have_posts()):?>    
    			    <?php while (have_posts()) :the_post();?>
    					<?php get_template_part('sv_templates/blog-content/content')?>
    			    <?php endwhile;?>

    			    <?php sv_paging_nav();?>

    			<?php else : ?>
    			    <?php get_template_part( 'sv_templates/blog-content/content', 'none' ); ?>
    			<?php endif;?>            
                <?php wp_reset_postdata();?>
            </div>
            <?php if($sidebar_pos=='right'){ get_sidebar(); }?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
