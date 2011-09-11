<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<header>
				<?php bolts_display_post_format(); ?>
				<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
			</header>

			<div class="entry-content">
				<?php bolts_before_entry(); ?>
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>' ) ); ?>
				<?php wp_link_pages( bolts_link_pages_args() ); ?>
				<?php bolts_after_entry(); ?>
			</div><!-- .entry-content -->

			<footer>
				<?php bolts_post_footer(); ?>
			</footer>

		</article><!-- #post-<?php the_ID(); ?> -->
