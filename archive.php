<?php get_header(); ?>

	<div id="content" class="<?php bolts_page_layout_class(); ?>">
	
		<?php bolts_before_content(); ?>
		
		<h1><?php
		if ( is_category() )
			printf( __( 'Category Archives: %s', BOLTS_TEXT_DOMAIN ), single_cat_title( '', false ) );
		elseif ( is_tag() )
			printf( __( 'Tag Archives: %s', BOLTS_TEXT_DOMAIN ), single_tag_title( '', false ) );
		elseif ( is_year() )
			printf( __( 'Yearly Archives: %s', BOLTS_TEXT_DOMAIN ), get_the_date( 'Y' ) );
		elseif ( is_month() )
			printf( __( 'Monthly Archives: %s', BOLTS_TEXT_DOMAIN ), get_the_date( 'F, Y' ) );
		elseif ( is_day() )
			printf( __( 'Daily Archives: %s', BOLTS_TEXT_DOMAIN ), get_the_date( 'F j, Y' ) );
		elseif ( is_author() )
			printf( __( 'Author Archives: %s', BOLTS_TEXT_DOMAIN ), get_the_author() );
		else
			_e( 'Blog Archives', BOLTS_TEXT_DOMAIN );
		?></h1>
	
	<?php if ( have_posts() ) : ?>
		<dl class="archive">
		
		<?php while ( have_posts() ) : the_post(); ?>
		
		<dt><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', BOLTS_TEXT_DOMAIN ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></dt>
		<dd><?php the_excerpt(); ?></dd>
		
		<?php endwhile; ?>
		
		</dl>
		
	<?php else : ?>
	
		<?php bolts_no_posts_found(); ?>
		
	<?php endif; ?>
	
	<?php bolts_paginate_links(); ?>
	
	</div>
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>