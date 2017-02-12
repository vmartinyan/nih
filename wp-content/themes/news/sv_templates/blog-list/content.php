<?php
$data = '';
global $post;
$data .= '<a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(850,400)).'</a>';
?>
<div class="item-blog-list">
    <div class="item-blog-list-thumb">
        <?php if(!empty($data)):
            echo balanceTags($data);?>
        <?php endif;?>
    </div>
    <div class="item-blog-list-info">
        <h3><a href="<?php echo esc_url(get_the_permalink());?>"><?php the_title();?></a></h3>
        <ul>
            <li><span class="lnr lnr-clock"></span> <?php echo get_the_time('d M Y');?></li>
            <li><?php esc_html_e("By","news")?> <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID')));?>"><?php echo get_the_author();?></a></li>
            <li><?php get_comments_number()?> <a href="#comment"><?php esc_html_e("Comments","news")?></a></li>
        </ul>
        <p><?php echo get_the_excerpt()?></p>
        <a href="<?php echo esc_url(get_the_permalink());?>" class="readmore"><span class="lnr lnr-arrow-right-circle"></span> <?php esc_html_e("Read more","news")?></a>
    </div>
</div>