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
		
	<?php else : ?>
	
		<?php bolts_no_posts_found(); ?>
		
	<?php endif; ?>
	
	<?php bolts_paginate_links(); ?>
	
	</div>
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>