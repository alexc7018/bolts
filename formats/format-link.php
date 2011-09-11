<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<?php $link = bolts_first_link(); ?>
			
			<header>
				<?php bolts_display_post_format(); ?>
				<h1><a class="entry-link" title="<?php echo $link['title_attr']; ?>" href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a></h1>
			</header>
			
			<div class="entry-content">
				<?php bolts_before_entry(); ?>
				<p><?php echo $link['desc']; ?></p>
				<?php bolts_after_entry(); ?>
			</div><!-- .entry-content -->
			
			<footer>
				<?php bolts_post_footer(); ?>
			</footer>

		</article><!-- #post-<?php the_ID(); ?> -->
