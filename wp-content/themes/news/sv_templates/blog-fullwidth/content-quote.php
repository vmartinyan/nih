<?php
$data = '';
global $post;
$sv_image_blog = get_post_meta(get_the_ID(), 'format_image', true);
if(!empty($sv_image_blog)){
    $data .='<img alt="'.$post->post_name.'" title="'.$post->post_name.'" src="' . esc_url($sv_image_blog) . '"/>';
}
else{
    if (has_post_thumbnail()) {
        $data .= get_the_post_thumbnail(get_the_ID(),'full');
    }
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