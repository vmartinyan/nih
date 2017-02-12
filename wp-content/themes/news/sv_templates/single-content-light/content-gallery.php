<?php
$data = '';
$gallery = get_post_meta(get_the_ID(), 'format_gallery', true);
if (!empty($gallery)){
    $array = explode(',', $gallery);
    if(is_array($array) && !empty($array)){
        
        $data .= '<div class="item-blog-slider"><div class="wrap-item">';
        foreach ($array as $key => $item) {
            $thumbnail_url = wp_get_attachment_url($item);
            $data .=    '<div class="item"><div class="item-blog-list-thumb">';
            $data .=        '<img src="' . esc_url($thumbnail_url) . '" alt="image-slider">';           
            $data .=    '</div></div>';
        }
        $data .='</div></div>';
    }
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