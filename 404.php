<?php get_header(); ?>
	
	<div id="content" class="<?php bolts_page_layout_class(); ?>">
	
	<?php bolts_before_content(); ?>
		
	<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
		<header>
			<h1><?php _e( 'Page Not Found', BOLTS_TEXT_DOMAIN ); ?></h1>
		</header>
		
		<p><?php _e( "We couldn't find the page you were looking for. We've tried searching for it below. Does something here look like what you need to find?", BOLTS_TEXT_DOMAIN ); ?></p>
		
		<?php
		$search_term = str_replace( '-', ' ', get_query_var( 'pagename' ) );
		$search_query = new WP_Query( array(
			's' => urlencode( $search_term ),
			'posts_per_page' => 5
		) );
		
		$only_one_result = false;
		$view_all_button = false;
		
		if ( $search_query->found_posts == 1 ) {
			$only_one_result = true;
		}
		elseif ( $search_query->found_posts < 5 ) {
			$found_posts = $search_query->found_posts;
		}
		else {
			$found_posts = 5;
			$view_all_button = true;
		}
		?>
		
		<?php echo do_shortcode( '[divider]' ); ?>
		
		<?php if ( $only_one_result ) : ?>
		<h2><?php printf( __( 'Search result for %s', BOLTS_TEXT_DOMAIN ), '<mark>' . $search_term . '</mark>' ); ?></h2>
		<?php elseif ( $view_all_button ) : ?>
		<h2><?php printf( __( 'Top %d search results for %s', BOLTS_TEXT_DOMAIN ), $found_posts, '<mark>' . $search_term . '</mark>' ); ?></h2>
		<?php else : ?>
		<h2><?php printf( __( '%d search results for %s', BOLTS_TEXT_DOMAIN ), $found_posts, '<mark>' . $search_term . '</mark>' ); ?></h2>
		<?php endif; ?>
		
		<?php if ( $search_query->have_posts() ) : ?>
		
			<dl class="search">
		
			<?php while ( $search_query->have_posts() ) : $search_query->the_post(); ?>
			
				<?php
				$title = bolts_highlight_text( get_the_title(), get_search_query() );
				$excerpt = bolts_highlight_text( get_the_excerpt(), get_search_query() );
				?>
				<dt><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', BOLTS_TEXT_DOMAIN ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php echo $title; ?></a></dt>
				<dd><?php echo $excerpt; ?></dd>
			
			<?php endwhile; ?>
		
			</dl>
			
			<?php if ( $view_all_button ) : ?>
			<p><a class="bolts-button" href="<?php echo home_url(); ?>/?s=<?php echo urlencode( $search_term ); ?>"><?php _e( 'View full search results', BOLTS_TEXT_DOMAIN ); ?> &rsaquo;</a></p>
			<?php endif; ?>
		
		<?php else : ?>
		
		<p><?php _e( 'No results found.', BOLTS_TEXT_DOMAIN ); ?></p>
		
		<?php endif; ?>
		
		<?php echo do_shortcode( '[divider]' ); ?>
		
		<div class="bolts-columns across-2">
			<div class="bolts-column rule first">
		
				<h2><?php _e( 'Helpful Links', BOLTS_TEXT_DOMAIN ); ?></h2>
			
				<?php bolts_menu( '404' ); ?>
			
			</div>
		
			<div class="bolts-column rule last">
			
				<h2><?php _e( 'Recent Posts', BOLTS_TEXT_DOMAIN ); ?></h2>
				
				<?php
				$recent_posts = new WP_Query( 'posts_per_page=5' );
				
				if ( $recent_posts->have_posts() ) :
				?>
				<ul>
					<?php while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>
						<li><a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Permanent link to %s', BOLTS_TEXT_DOMAIN ), '&lsquo;' . esc_attr( get_the_title() ) . '&rsquo;' ); ?>"><?php the_title(); ?></a></li>
					<?php endwhile; ?>
				</ul>
				<?php endif; ?>
			
			</div>
		
		</div>
		
	</section>
	
	<?php bolts_after_content(); ?>
	
	</div>
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>