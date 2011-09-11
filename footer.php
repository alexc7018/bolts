	<?php bolts_before_footer(); ?>
	
	<footer>
		<div class="column">
			<?php if ( ! dynamic_sidebar( 'Footer Left Column' ) ) : ?>
			<section class="widget widget_text"><h1 class="widgettitle"><?php _e( 'Footer Left Column', BOLTS_TEXT_DOMAIN ); ?></h1>
				<p><?php _e( 'This theme supports widgets.', BOLTS_TEXT_DOMAIN ); ?></p>
			</section>
			<?php endif; ?>
		</div>
		
		<div class="column">
			<?php if ( ! dynamic_sidebar( 'Footer Center Column' ) ) : ?>
			<section class="widget widget_text"><h1 class="widgettitle"><?php _e( 'Footer Center Column', BOLTS_TEXT_DOMAIN ); ?></h1>
				<p><?php _e( 'This theme supports widgets.', BOLTS_TEXT_DOMAIN ); ?></p>
			</section>
			<?php endif; ?>
		</div>
		
		<div class="column last">
			<?php if ( ! dynamic_sidebar( 'Footer Right Column' ) ) : ?>
			<section class="widget widget_text"><h1 class="widgettitle"><?php _e( 'Footer Right Column', BOLTS_TEXT_DOMAIN ); ?></h1>
				<p><?php _e( 'This theme supports widgets.', BOLTS_TEXT_DOMAIN ); ?></p>
			</section>
			<?php endif; ?>
		</div>
		
		<?php bolts_menu( 'footer' ); ?>
		<?php bolts_footer(); ?>
    </footer>
    
    <?php bolts_after_footer(); ?>
    
<?php bolts_after_container(); ?>
</div>

<?php
bolts_after_html();
wp_footer();
?>
</body>
</html>