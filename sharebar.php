<div id="sharing-wrapper">
	<div id="sharing">
		<div id="sharing-inner">
			<div class="share twitter"><?php echo do_shortcode( '[twitter count="vertical"]' ); ?></div>
			<div class="share google"><?php echo do_shortcode( '[google-plusone count="true" size="tall"]' ); ?></div>
			<div class="share facebook"><?php echo do_shortcode( '[facebook layout="box_count" send="true"]' ); ?></div>
			<div class="share stumble"><script src="http://www.stumbleupon.com/hostedbadge.php?s=5"></script></div>
			<div class="share digg"><?php echo do_shortcode( '[digg]' ); ?></div>
			<script type="text/javascript">
			jQuery(document).ready(function ($) {  
				var top = $('#sharing').offset().top - parseFloat($('#sharing').css('marginTop').replace(/auto/, 0));
				var left = $('#sharing').offset().left;
				$(window).scroll(function (event) {
					var y = $(this).scrollTop();
					if (y >= top - 140) {
						// if so, ad the fixed class
						$('#sharing').css('position', 'fixed !important').css('top', '100px !important').css('left', left + 'px !important');
					}
					else {
						$('#sharing').css('position', 'static !important').css('top', 'inherit !important').css('left', 'inherit !important');
					}
				});
				
				var column_height = Math.max($('#content').height(), $('.site-sidebar.primary').height() + $('.site-sidebar.secondary').height() + 48);
				$('#content').height(column_height);
			});
			</script>
		</div>
	</div>
</div>