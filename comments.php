<?php
/**
 * Comments template
 *
 * @since 1.0
 * @package Bolts
 */

/** @todo Rewrite this code to follow my own conventions */

	if ( 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) )
		die( __( 'Please do not load this page directly.', BOLTS_TEXT_DOMAIN ) );

	if ( !post_type_supports( get_post_type(), 'comments' ) || ( !have_comments() && !comments_open() && !pings_open() ) )
		return;

	if ( post_password_required() ) : ?>

		<h3 class="comments-header"><?php _e( 'Password Protected', BOLTS_TEXT_DOMAIN ); ?></h3>

		<p class="alert password-protected">
			<?php _e( 'Enter the password to view comments.', BOLTS_TEXT_DOMAIN ); ?>
		</p><!-- .alert .password-protected -->

	<?php endif; ?>

<div id="comments-template">

	<?php if ( have_comments() ) : ?>

		<div id="comments">

			<h3 id="comments-number" class="comments-header"><?php comments_number( sprintf( __( 'No responses to %1$s', BOLTS_TEXT_DOMAIN ), the_title( '&#8220;', '&#8221;', false ) ), sprintf( __( 'One response to %1$s', BOLTS_TEXT_DOMAIN ), the_title( '&#8220;', '&#8221;', false ) ), sprintf( __( '%1$s responses to %2$s', BOLTS_TEXT_DOMAIN ), '%', the_title( '&#8220;', '&#8221;', false ) ) ); ?></h3>
			
			<?php if ( ! empty( $comments_by_type['comment'] ) ) : ?>
			
			<?php bolts_before_comment_list(); // Before comment list hook ?>

			<ol class="comment-list">
				<?php wp_list_comments( bolts_list_comments_args( 'comment' ) ); ?>
			</ol><!-- .comment-list -->
			
			<?php endif;
			
			if ( ! empty( $comments_by_type['pings'] ) ) : ?>
			
			<h4>Pings/Trackbacks</h4>
			
			<ol class="comment-list ping-list">
				<?php wp_list_comments( bolts_list_comments_args( 'pings' ) ); ?>
			</ol><!-- .comment-list -->
			
			<?php endif; ?>

			<?php bolts_after_comment_list(); // After comment list hook ?>

			<?php if ( get_option( 'page_comments' ) ) : ?>
				<div class="comment-navigation paged-navigation">
					<?php paginate_comments_links(); ?>
				</div><!-- .comment-navigation -->
			<?php endif; ?>

		</div><!-- #comments -->

	<?php else : ?>

		<?php if ( pings_open() && ! comments_open() ) : ?>

			<p class="comments-closed pings-open">
				<?php printf( __( 'Comments are closed, but <a href="%1$s" title="Trackback URL for this post">trackbacks</a> and pingbacks are open.', BOLTS_TEXT_DOMAIN ), trackback_url( '0' ) ); ?>
			</p><!-- .comments-closed .pings-open -->

		<?php elseif ( ! comments_open() ) : ?>

			<p class="comments-closed">
				<?php _e( 'Comments are closed.', BOLTS_TEXT_DOMAIN ); ?>
			</p><!-- .comments-closed -->

		<?php endif; ?>

	<?php endif; ?>

	<?php comment_form(); // Load the comment form. ?>

</div><!-- #comments-template -->