<?php
/* Template Name: Archives */
get_header();
?>
	
	<div id="content" class="<?php bolts_page_layout_class(); ?>">
	
	<?php bolts_before_content(); ?>
	
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		
		<section id="post-<?php the_ID(); ?>" <?php post_class( 'archives' ); ?>>
		
			<header>
				<h1><?php the_title(); ?></h1>
			</header>
			
			<?php the_content(); ?>
			
			<section class="archive-group">
				<h1><?php _e( 'Monthly Archives', BOLTS_TEXT_DOMAIN ); ?></h1>
				
				<ul>
					<?php wp_get_archives( 'title_li=' ); ?>
				</ul>
			</section>
			
			<section class="archive-group">
				<h1><?php _e( 'Tag Archives', BOLTS_TEXT_DOMAIN ); ?></h1>
				
				<?php wp_tag_cloud(); ?>
			</section>
			
			<section class="archive-group">
				<h1><?php _e( 'Category Archives', BOLTS_TEXT_DOMAIN ); ?></h1>
				
				<ul>
					<?php wp_list_categories( 'title_li=' ); ?>
				</ul>
			</section>
			
		</section>
		
		<?php endwhile; ?>
		
	<?php else: ?>
	
		<?php bolts_no_posts_found(); ?>
		
	<?php endif;?>
	
	<?php bolts_after_content(); ?>
	
	</div>
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>