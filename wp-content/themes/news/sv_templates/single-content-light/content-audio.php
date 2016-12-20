<?php
$data = '';
if (get_post_meta(get_the_ID(), 'format_media', true)) {
    $media_url = get_post_meta(get_the_ID(), 'format_media', true);
    $data .= '<div class="audio">' . sv_remove_w3c(wp_oembed_get($media_url, array('height' => '176'))) . '</div>';
}
?>
<div class="single-leading2">
    <?php if(!empty($data)):?>
        <div class="single-leading-thumb">
            <?php echo balanceTags($data);?>
        </div>
    <?php endif;?>
    <?php sv_author_box_light()?>
</div>
<div class="main-content-single2">
    <?php the_content(); ?>
</div>