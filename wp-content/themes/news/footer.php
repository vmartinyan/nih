<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package 7up-framework
 */

?>
        <?php
            $main_value = get_post_meta(sv_get_page_id(),'sv_footer_page',true);
            $page_id = sv_get_value_by_id('sv_footer_page');
            
            if(!empty($page_id)) {
                sv_get_footer_visual($page_id);
            }
            else{
                sv_get_footer_default();
            }
            sc_scroll_top()
        ?>
        </div>
    <?php wp_footer(); ?>
    </body>
</html>
