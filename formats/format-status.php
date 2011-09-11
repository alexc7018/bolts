<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<header>
				<?php bolts_display_post_format(); ?>
			</header>
			
			<div class="entry-content">
				<?php bolts_before_entry(); ?>
				<?php the_content(); ?>
				<?php bolts_after_entry(); ?>
			</div><!-- .entry-content -->
			
			<footer>
				<?php bolts_post_footer(); ?>
			</footer>

		</article><!-- #post-<?php the_ID(); ?> -->
