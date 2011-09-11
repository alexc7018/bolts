<?php
/* Template Name: Sitemap */
get_header();
?>
	
	<div id="content" class="<?php bolts_page_layout_class(); ?>">
	
	<?php bolts_before_content(); ?>
	
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		
		<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
			<header>
				<h1><?php the_title(); ?></h1>
			</header>
			
			<?php the_content(); ?>
			
			<?php wp_page_menu(); ?>
			
		</section>
		
		<?php endwhile; ?>
		
	<?php else: ?>
	
		<?php bolts_no_posts_found(); ?>
		
	<?php endif;?>
	
	<?php bolts_after_content(); ?>
	
	</div>
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>