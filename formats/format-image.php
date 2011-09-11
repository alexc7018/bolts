<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<header>
				<?php bolts_display_post_format(); ?>
				<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
			</header>
			
			<div class="entry-content">
				<?php bolts_before_entry(); ?>
				<?php if ( has_post_thumbnail() )
				the_post_thumbnail( 'post-format-image' ); ?>
				
				<p><?php the_content(); ?></p>
				<?php bolts_after_entry(); ?>
			</div><!-- .entry-content -->

		</article><!-- #post-<?php the_ID(); ?> -->
