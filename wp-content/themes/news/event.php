<?php
/*
 * Template Name: Event Template
 *
 *
 * */
get_header();?>
<div id="main-content" class="main-wrapper archive-event">
    <div class="container">
        <div class="list-event-post">
            <div class="list-event-search-form event-search-form">
                <form class="clearfix" method="get" action="<?php echo esc_url(home_url( '/' )); ?>">
                    <input name="s" class="event-search-category" type="text" value="" placeholder="<?php echo esc_html__('Event Name','news')?>">
                    <input name="event_location" class="event-search-location" type="text" value="" placeholder="<?php echo esc_html__('Enter city or location','news')?>">
                    <select class="select-event-time">
                        <option value=""><?php esc_html_e("All Dates","news")?></option>
                        <option value="today"><?php esc_html_e("Today","news")?></option>
                        <option value="tomorrow"><?php esc_html_e("Tomorrow","news")?></option>
                        <option value="this-week"><?php esc_html_e("This Week","news")?></option>
                        <option value="this-weekend"><?php esc_html_e("This Weekend","news")?></option>
                        <option value="next-week"><?php esc_html_e("Next Week","news")?></option>
                        <option value="this-month"><?php esc_html_e("This Month","news")?></option>
                        <option value="next-month"><?php esc_html_e("Next Month","news")?></option>
                    </select>
                    <input type="hidden" name="post_type" value="event" />
                    <input type="hidden" class="event-date-value" name="event_date" value="" />
                    <input class="submit-event-search-form" type="submit" value="<?php esc_html_e("Search","news")?>">
                </form>
            </div>
            <h2><?php esc_html_e("Webdesign","news")?></h2>
                <?php 
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $args=array(
                        'post_type'         => 'event',
                        'posts_per_page'    => 12,
                        'paged'             => $paged,
                    );
                    $event_query = new WP_Query($args);
                ?>
                <?php if($event_query->have_posts()):?>               
                <div class="row">                    
                    <?php while ($event_query->have_posts()) :$event_query->the_post();?>
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
                                    $meta_html =    '<ul>
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
                </div>
                    <?php sv_paging_nav_event($args,$event_query);?>                
                <?php endif;?>
                <?php wp_reset_postdata();?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
