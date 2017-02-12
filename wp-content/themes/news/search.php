<?php
/**
 * The template for displaying search results pages.
 *
 * @package 7up-framework
 */

get_header(); ?>
<?php
$sidebar=sv_get_sidebar();
$sidebar_pos=$sidebar['position'];
$main_class = 'main-content sidebar-'.$sidebar_pos;
$post_type = 'post';
if(isset($_GET['post_type'])) $post_type = $_GET['post_type'];
if($post_type == 'event'){
?>
<div id="main-content" class="main-wrapper archive-event event-search">
    <div class="container">
    	<div class="list-event-search-form event-search-form">
    		<?php 
    		$search_val = get_search_query();
    		$location = '';
    		$event_date = $event_location = '';
    		if(isset($_GET['event_location'])) $location = $event_location = $_GET['event_location'];
    		if(isset($_GET['event_date'])) $event_date = $_GET['event_date'];
	        if(empty($search_val)){
	            $search_val = '';
	        }
	        //Change search query
	        global $wp_query;
	        $array_add = array('posts_per_page'	=> 12);
	        if(!empty($event_location)){
	        	$array_add['meta_query']['relation'] = 'AND';
				$array_add['meta_query'][] = array(
					                'key'   => 'event_location',
					                'value' => $event_location,
					                'compare' => 'LIKE'
					            );
			}
			if(!empty($event_date)){
				$tomorrow = mktime(0, 0, 0, date("m"), date("d")+1, date("y"));
				switch ($event_date) {
					case 'tomorrow':
						$date_start = date("Y-m-d", $tomorrow);
						$date_end = $date_start;
						break;

					case 'this-week':
						$date_start = date("Y-m-d", strtotime('monday this week'));
						$date_end = date("Y-m-d", strtotime('sunday this week'));
						break;

					case 'this-weekend':
						$date_start = date("Y-m-d", strtotime('saturday this week'));
						$date_end = date("Y-m-d", strtotime('sunday this week'));
						break;

					case 'next-week':
						$date_start = date("Y-m-d", strtotime('monday this week +1 week'));
						$date_end = date("Y-m-d", strtotime('sunday this week +1 week'));
						break;

					case 'next-month':
						$date_start = date("Y-m-d", strtotime('first day of next month'));
						$date_end = date("Y-m-d", strtotime('last day of next month'));
						break;

					case 'this-month':
						$date_start = date("Y-m-d", strtotime('first day of this month'));
						$date_end = date("Y-m-d", strtotime('last day of this month'));
						break;
					
					default:
						$date_start = current_time('Y-m-d');
						$date_end = $date_start;						
						break;
				}
				$array_add['meta_query']['relation'] = 'AND';
				$array_add['meta_query'][] = array(
					                'key'   => 'event_date',
					                'value' => $date_start,
					                'compare' => '>='
					            );
				$array_add['meta_query'][] = array(
					                'key'   => 'event_date',
					                'value' => $date_end,
					                'compare' => '<='
					            );
			}			
			query_posts( array_merge($array_add,$wp_query->query) );
    		?>
			<form class="clearfix" method="get" action="<?php echo esc_url(home_url( '/' )); ?>">
				<input name="s" class="event-search-category" type="text" value="<?php echo esc_attr($search_val)?>" placeholder="<?php echo esc_html__('Event Name','news')?>">
				<input name="event_location" class="event-search-location" type="text" value="<?php echo esc_attr($location)?>" placeholder="<?php echo esc_html__('Enter city or location','news')?>">
				<select class="select-event-time">
                    <option value=""><?php esc_html_e("All Dates","news")?></option>
                    <option <?php if($event_date == 'today') echo'selected="selected"';?> value="today"><?php esc_html_e("Today","news")?></option>
                    <option <?php if($event_date == 'tomorrow') echo'selected="selected"';?> value="tomorrow"><?php esc_html_e("Tomorrow","news")?></option>
                    <option <?php if($event_date == 'this-week') echo'selected="selected"';?> value="this-week"><?php esc_html_e("This Week","news")?></option>
                    <option <?php if($event_date == 'this-weekend') echo'selected="selected"';?> value="this-weekend"><?php esc_html_e("This Weekend","news")?></option>
                    <option <?php if($event_date == 'next-week') echo'selected="selected"';?> value="next-week"><?php esc_html_e("Next Week","news")?></option>
                    <option <?php if($event_date == 'this-month') echo'selected="selected"';?> value="this-month"><?php esc_html_e("This Month","news")?></option>
                    <option <?php if($event_date == 'next-month') echo'selected="selected"';?> value="next-month"><?php esc_html_e("Next Month","news")?></option>
                </select>
				<input type="hidden" name="post_type" value="event" />
				<input type="hidden" class="event-date-value" name="event_date" value="" />
				<input class="submit-event-search-form" type="submit" value="Search">
			</form>

		</div>
        <div class="list-event-post">
        	<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'news' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
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
										<a href="<?php echo esc_url(get_the_permalink())?>">
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
									<h3><a href="<?php echo esc_url(get_the_permalink())?>"><?php the_title()?></a></h3>
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
<?php 
}
else{
	$main_class = 'col-md-12 col-sm-12 col-xs-12 search-content-light search-sidebar-'.$sidebar_pos;
    if($sidebar_pos != 'no') $main_class = 'col-md-9 col-sm-8 col-xs-12 search-content-light search-sidebar-'.$sidebar_pos;
	    ?>
	    <div id="main-content"  class="single-content main-content-blog2">
	        <div class="container">
	            <div class="row">
	                <?php if($sidebar_pos=='left'){ get_sidebar(); }?>
	                <div class="content-search-light <?php echo esc_attr($main_class); ?>">
	                	<h2><?php printf( esc_html__( 'Search Results for: %s', 'news' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
	                    <?php if ( have_posts() ) : ?>
							
							<?php 
							$search_val = get_search_query();
			                if(empty($search_val)){
			                    $search_val = esc_html__("search...","news");
			                }
							?>
							<div class="search-form-light">
								<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
									<input type="text" name ="s" value="<?php echo esc_attr($search_val);?>" onfocus="if (this.value==this.defaultValue) this.value = ''" onblur="if (this.value=='') this.value = this.defaultValue">
									<input type="submit" value="<?php esc_html_e("Search","news")?>">
								</form>
							</div>
							<div class="list-item-search-light">
								<?php while ( have_posts() ) : the_post(); ?>

									<?php get_template_part('sv_templates/blog-content/content');?>
									
								<?php endwhile; ?>
							</div>
							<?php sv_paging_nav();?>
						<?php else : ?>

							<h2><?php esc_html_e("No post for key search.","news")?></h2>

						<?php endif; ?>
	                </div>
	                <?php if($sidebar_pos=='right'){ get_sidebar(); }?>
	            </div>
	        </div>
	    </div>
	<?php }
?>
<?php get_footer(); ?>
