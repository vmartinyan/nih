<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package 7up-framework
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

if ( post_password_required() ) {
	return;
}
if(!function_exists('sv_comments_list'))
{ 
    function sv_comments_list($comment, $args, $depth) {

        $GLOBALS['comment'] = $comment;
        /* override default avatar size */
        $args['avatar_size'] = 73;
        if ('pingback' == $comment->comment_type || 'trackback' == $comment->comment_type) :
            ?>
            <li class="comment-pingback">
                <span id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>></span>
                <div class="comment-body">
                    <?php esc_html_e('Pingback:', 'news'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(esc_html__('Edit', 'news'), '<span class="edit-link"><i class="fa fa-pencil-square-o"></i>', '</span>'); ?>
                </div>
            </li>
        <?php else : ?>
            <li id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent' ); ?>>
                <div id="div-comment-<?php comment_ID(); ?>" class="single-comment-box">
                    <div class="single-comment-thumb">
                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php if (0 != $args['avatar_size']) echo get_avatar($comment, $args['avatar_size']); ?></a>
                    </div>
                    <div class="single-comment-info">
                        <h3><a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php echo get_comment_author_link()?></a></h3>
                        <?php if (comments_open()): ?>
                            <?php echo str_replace('comment-reply-link', 'single-comment-reply', get_comment_reply_link(array_merge( $args, array('reply_text' =>esc_html__('Reply','news'),'depth' => $depth, 'max_depth' => $args['max_depth'])))) ?>
                        <?php endif; ?>
                        <p><?php comment_text();?></p>
                        <div class="single-comment-date"><span class="lnr lnr-calendar-full"></span> <?php echo get_comment_time('j M Y')?></div>
                    </div>
                </div><!-- .comment-body -->
            <!-- </li> -->
        <?php
        endif;
    }
}
$cm_class = 'single-comment-list2';
$comment_form = array(
    'title_reply' => esc_html__('Leave a comments', 'news'),
    'fields' => apply_filters( 'comment_form_default_fields', array(
            'author'    =>  '<div class="row"><div class="col-md-4 col-sm-4 col-xs-12">
                                <input class="form-control input-md" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .'" placeholder="'.esc_html__( 'Name', 'news' ).'" />
                            </div>',
            'email'     =>  '<div class="col-md-4 col-sm-4 col-xs-12">
                                <input class="form-control input-md" id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) .'" placeholder="'.esc_html__( 'Email', 'news' ).'" />
                            </div>',
            'url'       =>  '<div class="col-md-4 col-sm-4 col-xs-12">
                                <input class="form-control input-md" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .'" placeholder="'.esc_html__( 'Website', 'news' ).'" />
                            </div></div>',
        )
    ),
    'comment_field' =>  '<div class="col-md-12 col-sm-12 col-xs-12 no-padding">
                            <textarea id="comment" class="form-control" rows="5" name="comment" aria-required="true" placeholder="'.esc_html__( 'Comment:', 'news' ).'"></textarea>
                        </div>',
    'must_log_in' => '<div class="must-log-in control-group"><div class="controls">' .sprintf(wp_kses_post(__( 'You must be <a href="%s">logged in</a> to post a comment.','news' )),wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )) . '</div></div >',
    'logged_in_as' => '<div class="logged-in-as control-group"><div class="controls">' .sprintf(wp_kses_post(__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>','news' )),admin_url( 'profile.php' ),$user_identity,wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )) . '</div></div>',
    'comment_notes_before' => '',
    'comment_notes_after' => '',
    'id_form'              => 'commentform',
    'id_submit'            => 'submit',
    'title_reply'          => esc_html__( 'Leave Comments','news' ),
    'title_reply_to'       => esc_html__( 'Leave a Reply %s','news' ),
    'cancel_reply_link'    => esc_html__( 'Cancel reply','news' ),
    'label_submit'         => esc_html__( 'Post comment','news' ),
    'class_submit'         => 'submit-comment submit-light',
);
?>

	<div id="comments" class="comments-area comments post-comment">

		<?php // You can start editing here -- including this comment! ?>

		<?php if ( have_comments() ) : ?>
            <div class="single-comment-list <?php echo esc_attr($cm_class)?>">
    			<h2><?php echo get_comments_number().' '. esc_html__('Comments', 'news'); ?></h2>
    	        <ol class="comments">
    	            <?php
    	            wp_list_comments(array(
    	                'style' => '',
    	                'short_ping' => true,
    	                'avatar_size' => 73,
    	                'max_depth' => '5',
    	                'callback' => 'sv_comments_list',
    	            ));
    	            ?>
    	        </ol>

    			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
    			<nav id="comment-nav-below" class="comment-navigation" role="navigation">
    				<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'news' ); ?></h1>
    				<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'news' ) ); ?></div>
    				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'news' ) ); ?></div>
    			</nav><!-- #comment-nav-below -->
    			<?php endif; // check for comment navigation ?>
            </div>
		<?php endif; ?>

		<?php
			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'news' ); ?></p>
		<?php endif; ?>

	</div><!-- #comments -->
	
<div class="leave-comments form-comment">
	<?php comment_form($comment_form); ?>
</div>
<?php

class sv_custom_comment extends Walker_Comment {
     
    /** START_LVL 
     * Starts the list before the CHILD elements are added. */
    function start_lvl( &$output, $depth = 0, $args = array() ) {       
        $GLOBALS['comment_depth'] = $depth + 1;

           $output .= '<div class="children">';
        }
 
    /** END_LVL 
     * Ends the children list of after the elements are added. */
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $GLOBALS['comment_depth'] = $depth + 1;
        $output .= '</div>';
    }
    function end_el( &$output, $object, $depth = 0, $args = array() ) {
    	$output .= '';
    }
}
?>

