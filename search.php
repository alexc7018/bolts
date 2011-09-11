<?php get_header(); ?>

	<div id="content" class="<?php bolts_page_layout_class(); ?>">
	
		<?php bolts_before_content(); ?>
	
		<?php if ( have_posts() ) : ?>
		<h1 class="page-title"><?php printf( __( 'Search results for %s', BOLTS_TEXT_DOMAIN ), '<mark>' . get_search_query() . '</mark>' ); ?></h1>
		
		<dl class="search">
		
			<?php while ( have_posts() ) : the_post(); ?>
			
			<?php
			$title = bolts_highlight_text( get_the_title(), get_search_query() );
			$excerpt = bolts_highlight_text( strip_tags( get_the_excerpt() ), get_search_query() );
			?>
			<dt><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', BOLTS_TEXT_DOMAIN ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php echo $title; ?></a></dt>
			<dd><?php echo $excerpt; ?></dd>
			
			<?php endwhile; ?>
		
		</dl>
			
		<?php else : ?>
		
			<?php bolts_no_posts_found(); ?>
			
		<?php endif; ?>
	
		<?php bolts_paginate_links(); ?>
	
	</div>
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>