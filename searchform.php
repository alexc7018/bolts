<form role="search" class="bolts-form" method="get" id="searchform" action="<?php echo home_url(); ?>">
	<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" />
	<input type="submit" id="searchsubmit" class="bolts-button" value="<?php _e( 'Search', BOLTS_TEXT_DOMAIN ); ?>" />
</form>