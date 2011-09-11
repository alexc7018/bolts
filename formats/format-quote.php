<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<header>
				<?php bolts_display_post_format(); ?>
			</header>

			<div class="entry-content">
				<?php bolts_before_entry(); ?>
				<?php
				if ( strpos( $post->post_content, '<blockquote' ) === false )
					echo '<blockquote>';
					
				the_content();
				
				if ( strpos( $post->post_content, '<blockquote' ) === false )
					echo '</blockquote>';
				?>
				<?php bolts_after_entry(); ?>
			</div><!-- .entry-content -->

		</article><!-- #post-<?php the_ID(); ?> -->
