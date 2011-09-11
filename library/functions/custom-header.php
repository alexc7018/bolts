<?php

if ( bolts_option( 'custom_background' ) )
	add_custom_background();

if ( bolts_option( 'custom_header' ) ) :

	define( 'HEADER_TEXTCOLOR', '0099cc' );
	define( 'HEADER_IMAGE', THEME_URI . '/images/headers/bolts.jpg' );
	define( 'HEADER_IMAGE_WIDTH', 950 ); // use width and height appropriate for your theme
	define( 'HEADER_IMAGE_HEIGHT', 200 );
	
	function header_style() {
	    echo '<' . 'style type="text/css">
	        #container > header {
	            background: url(' . get_header_image() . ');
	        }';
	        
	    if ( get_header_textcolor() == 'blank' ) {
	    	echo '#container > header h1,
	    	#container > header h2 {
	    		display: none;
	    	}';
	    }
	    else {
	    	if ( get_header_textcolor() == 'ffffff' || get_header_textcolor() == 'FFFFFF' )
	    		$shadow = '0 -1px 0 rgba(0, 0, 0, 0.25)';
	    	else
	    		$shadow = '0 1px 0 rgba(255, 255, 255, 0.6)';
	    	
	    	echo '#container > header h1 a,
	    	#container > header h2 {
	    		color: #' . get_header_textcolor() . ';
	    		text-shadow: ' . $shadow . ';
	    	}';
	    }
	    echo '</style>';
	}

	function admin_header_style() {
		
		if ( get_header_textcolor() == 'ffffff' || get_header_textcolor() == 'FFFFFF' )
			$shadow = '0 -1px 0 rgba(0, 0, 0, 0.25)';
		else
			$shadow = '0 1px 0 rgba(255, 255, 255, 0.6)';
		
	    echo '<' . 'style type="text/css">
	        #headimg {
	            width: ' . HEADER_IMAGE_WIDTH . 'px;
	            height: ' . HEADER_IMAGE_HEIGHT . 'px;
	            position: relative;
	        }
	        #headimg h1 a {
	        	font: 60px Georgia;
	        	line-height: 1;
	        	position: absolute;
	        	bottom: 25px;
	        	left: 10px;
	        	text-decoration: none;
	        	text-shadow: ' . $shadow . ';
	        }
	        #headimg #desc {
	        	font: bold 12px "Helvetica Neue", Helvetica, Arial, sans-serif;
	        	line-height: 1;
	        	position: absolute;
	        	bottom: 12px;
	        	left: 10px;
	        	text-shadow: ' . $shadow . ';
	        }
		</style>';
	}

	add_custom_image_header( 'header_style', 'admin_header_style' );

	register_default_headers( array(
		'bolts' => array(
			'url' => '%s/images/headers/bolts.jpg',
			'thumbnail_url' => '%s/images/headers/bolts-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Bolts' )
		),
		'orange-dots' => array(
			'url' => '%s/images/headers/orange-dots.jpg',
			'thumbnail_url' => '%s/images/headers/orange-dots-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Orange Dots' )
		),
		'blue-dots' => array(
			'url' => '%s/images/headers/blue-dots.jpg',
			'thumbnail_url' => '%s/images/headers/blue-dots-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Blue Dots' )
		),
		'light' => array(
			'url' => '%s/images/headers/light.jpg',
			'thumbnail_url' => '%s/images/headers/light-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Light' )
		)
	) );

endif;
?>