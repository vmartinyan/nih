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
get_header(); ?>
<div id="main-content" class="main-wrapper archive-event">
    <div class="container">
        <div class="list-event-post">
        	<h2><?php esc_html_e("Webdesign","news")?></h2>
	            <?php if(have_posts()):?>	            
        		<div class="row">
	                <?php while (have_posts()) :the_post();?>
	                    <?php 
	                    $event_date = get_post_meta(get_the_ID(),'event_date',true);
                        $event_time = get_post_meta(get_the_ID(),'event_time',true);
                        $event_link = get_post_meta(get_the_ID(),'event_site',true);
                        $event_location = get_post_meta(get_the_ID(),'event_location',true);
	                    $event_free = get_post_meta(get_the_ID(),'event_free',true);
	                    ?>
	                    <div class="col-md-4 col-sm-6 col-xs-12">
							<div class="item-list-post-event">
								<div class="event-popular-thumb post-thumb">
									<?php if(has_post_thumbnail()):?>
										<a href="<?php echo esc_url(get_the_permalink());?>">
											<?php the_post_thumbnail(array(370,200))?>
										</a>
										<?php 
                                            if(!empty($event_free)){
                                                echo '<label>'.$event_free.'</label>';
                                            }
                                        ?>
									<?php endif;?>
								</div>
								<div class="event-popular-info">
									<h3><a href="<?php echo esc_url(get_the_permalink());?>"><?php the_title()?></a></h3>
									<?php 
									$meta_html = 	'<ul>
	                                                    <li><a href="'.esc_url($event_link).'"><span class="lnr lnr-calendar-full"></span> '.mysql2date( 'j F Y', $event_date ).'</a></li>
	                                                    <li><a href="'.esc_url($event_link).'"><span class="lnr lnr-clock"></span> '.$event_time.'</a></li>
	                                                    <li><a href="'.esc_url($event_link).'"><span class="lnr lnr-apartment"></span> '.$event_location.'</a></li>
	                                                </ul>';
	                                echo balanceTags($meta_html);
									?>
								</div>
							</div>
						</div>
	                
	                <?php endwhile;?>

	                <?php wp_reset_postdata();?>
        		</div>
	                <?php sv_paging_nav_event();?>	            
	            <?php endif;?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
