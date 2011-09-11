<aside class="site-sidebar primary <?php bolts_page_layout_class(); ?>">
	
	<?php
	bolts_before_primary_sidebar();
	if ( ! dynamic_sidebar( 'Primary Sidebar' ) ) : ?>
	<section class="widget widget_text"><h1 class="widgettitle"><?php _e( 'Primary Sidebar', BOLTS_TEXT_DOMAIN ); ?></h1>
		<p><?php _e( 'This theme supports widgets.', BOLTS_TEXT_DOMAIN ); ?></p>
	</section>
	<?php
	endif;
	bolts_after_primary_sidebar();
	?>
	
</aside>

<aside class="site-sidebar secondary <?php bolts_page_layout_class(); ?>">
	
	<?php
	bolts_before_secondary_sidebar();
	if ( ! dynamic_sidebar( 'Secondary Sidebar' ) ) : ?>
	<section class="widget widget_text"><h1 class="widgettitle"><?php _e( 'Secondary Sidebar', BOLTS_TEXT_DOMAIN ); ?></h1>
		<p><?php _e( 'This theme supports widgets.', BOLTS_TEXT_DOMAIN ); ?></p>
	</section>
	<?php
	endif;
	bolts_after_secondary_sidebar(); ?>
	
</aside>