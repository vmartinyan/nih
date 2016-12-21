<?php
$data = '';
$gallery = get_post_meta(get_the_ID(), 'format_gallery', true);
if (!empty($gallery)){
    $array = explode(',', $gallery);
    if(is_array($array) && !empty($array)){
        
        $data .= '<div class="post-gallery-slider">';
        foreach ($array as $key => $item) {
            $thumbnail_url = wp_get_attachment_url($item);
            $data .='<div class="image-slider">';
            $data .= '<img src="' . esc_url($thumbnail_url) . '" alt="image-slider">';           
            $data .= '</div>';
        }
        $data .='</div>';
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