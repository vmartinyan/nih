<?php
$data = '';
global $post;
$info_class = 'col-md-12 col-sm-12 col-xs-12 no-thumbnail';
if (has_post_thumbnail()) {
    $data .=    '<div class="col-md-4 col-sm-5 col-xs-12">
                    <div class="search-light-thumb">
                        <a href="'. esc_url(get_the_permalink()) .'">'.get_the_post_thumbnail(get_the_ID(),array(300,170)).'</a>
                    </div>
                </div>';
    $info_class = 'col-md-8 col-sm-7 col-xs-12';
}
?>
<div class="item-search-light">
    <div class="row">
        <?php if(!empty($data)) echo balanceTags($data);?>
        <div class="<?php echo esc_attr($info_class)?>">
            <div class="search-light-info">
                <h3><a href="<?php echo esc_url(get_the_permalink()); ?>"><?php the_title()?></a></h3>
                <ul>
                    <li><span class="lnr lnr-clock"></span> <?php echo get_the_time('d M Y');?></li>
                    <li><?php esc_html_e("By ","news");?> <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID')));?>"><?php echo get_the_author();?></a></li>
                    <?php if(is_front_page() && is_home()):?>
                        <li><?php esc_html_e('In', 'news');?>:
                            <?php $cats = get_the_category_list(', ');?>
                            <?php if($cats) echo balanceTags($cats); else _e("No Category",'news');?>
                        </li>
                        <li><?php esc_html_e('Tags', 'news');?>:
                            <?php $cats = get_the_tag_list(' ',', ',' ');?>
                            <?php if($cats) echo balanceTags($cats); else _e("No Tag",'news');?>
                        </li>
                    <?php endif;?>
                </ul>
                <p><?php echo get_the_excerpt(); ?></p>
                <a class="btn-view-all hide-icon" href="<?php echo esc_url(get_the_permalink()); ?>"><span class="view-all-text" data-hover="<?php esc_attr_e("Read More","news")?>"><?php esc_html_e("Read More","news")?></span> </a>
            </div>
        </div>
    </div>
</div>