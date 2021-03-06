<?php
$data = $st_link_post= $s_class = '';
global $post;
$sv_image_blog = get_post_meta(get_the_ID(), 'format_image', true);
if(!empty($sv_image_blog)){
    $data .='<img alt="'.$post->post_name.'" title="'.$post->post_name.'" class="blog-image" src="' . esc_url($sv_image_blog) . '"/>';
}
else{
    if (has_post_thumbnail()) {
        $data .= get_the_post_thumbnail(get_the_ID(),'full',array('class'=>'blog-image'));
    }
}
?>
<div class="single-post-detail <?php echo (is_sticky()) ? 'sticky':''?>">
    <div class="single-thumb">
        <?php if(!empty($data)):
            echo balanceTags($data);?>
            <div class="social-post">
                <a href="<?php echo esc_url("https://plus.google.com/share?url=". get_the_permalink());?>"><i class="fa fa-google-plus"></i></a>
                <a href="<?php echo esc_url("http://www.facebook.com/sharer.php?u=".get_the_permalink());?>"><i class="fa fa-facebook"></i></a>
                <a href="<?php echo esc_url("http://twitthis.com/twit?url=".get_the_permalink());?>"><i class="fa fa-twitter"></i></a>
            </div>
        <?php endif;?>
    </div>
     <?php sv_display_metabox();?>
    <h2 class="title-single">
        <?php the_title()?>
        <?php echo (is_sticky()) ? '<i class="fa fa-thumb-tack"></i>':''?>
    </h2>
    <div class="main-content-single">
        <?php the_content(); ?>
    <!-- </div>
</div> -->