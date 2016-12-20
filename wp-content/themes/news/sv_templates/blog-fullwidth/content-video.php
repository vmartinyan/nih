<?php
$data = '';
if (get_post_meta(get_the_ID(), 'format_media', true)) {
    $media_url = get_post_meta(get_the_ID(), 'format_media', true);
    $data .= sv_remove_w3c(wp_oembed_get($media_url),1170,600);
}
?>
<div class="item-blog-list">
    <div class="item-blog-list-video">
        <?php if(!empty($data)):
            echo balanceTags($data);?>
        <?php endif;?>
    </div>
    <div class="item-blog-list-info">
        <h3><a href="<?php echo esc_url(get_the_permalink());?>"><?php the_title();?></a></h3>
        <ul>
            <li><span class="lnr lnr-clock"></span> <?php echo get_the_time('d M Y');?></li>
            <li><?php esc_html_e("By","news")?> <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID')));?>"><?php echo get_the_author();?></a></li>
            <li><?php echo get_comments_number()?> <a href="<?php echo esc_url( get_comments_link() ); ?>"><?php esc_html_e("Comments","news")?></a></li>
        </ul>
        <p><?php echo get_the_excerpt()?></p>
        <a href="<?php echo esc_url(get_the_permalink());?>" class="readmore"><span class="lnr lnr-arrow-right-circle"></span> <?php esc_html_e("Read more","news")?></a>
    </div>
</div>