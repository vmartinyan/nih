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
<div class="single-leading2">
    <?php if(!empty($data)):?>
        <div class="single-leading-thumb">
            <a href="<?php echo esc_url(get_the_permalink());?>"><?php echo balanceTags($data);?></a>
        </div>
    <?php endif;?>
    <?php sv_author_box_light()?>
</div>
<div class="main-content-single2">
    <?php the_content(); ?>
</div>