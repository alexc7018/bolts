<?php get_header(); ?>
	
	<div id="content" class="<?php bolts_page_layout_class(); ?>">
	
	<?php bolts_before_content(); ?>
	
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		
		<?php
		$format = get_post_format();
		if ( ! $format )
			$format = 'standard';
		
		get_template_part( 'formats/format', $format ); ?>
		
		<?php endwhile; ?>
		
		<nav class="pagination single">
			<span class="previous"><?php previous_post_link( '%link', sprintf( __( '%s Previous Post', BOLTS_TEXT_DOMAIN ), '&laquo;' ) ); ?></span>
			<span class="next"><?php next_post_link( '%link', sprintf( __( 'Next Post %s', BOLTS_TEXT_DOMAIN ), '&raquo;' ) ); ?></span>
		</nav>
		
		<?php bolts_after_singular(); ?>
		
		<?php comments_template( '', true ); ?>
		
	<?php else: ?>
	
		<?php bolts_no_posts_found(); ?>
		
	<?php endif; ?>
	
	<?php bolts_after_content(); ?>
	
	</div>
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>