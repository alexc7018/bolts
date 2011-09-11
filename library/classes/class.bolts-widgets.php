<?php

/**
 * Popular posts
 * 
 * @package Bolts
 * @since 1.0
 * @modified 1.1
 */
class Bolts_Popular_Posts_Widget extends WP_Widget {
	
	function Bolts_Popular_Posts_Widget() {
		
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'popularposts', 'description' => __( 'A list of the most popular posts on your site', BOLTS_TEXT_DOMAIN ) );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'bolts-popular-posts-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'bolts-popular-posts-widget', __( 'Bolts Popular Posts', BOLTS_TEXT_DOMAIN ), $widget_ops, $control_ops );
		
	}
	
	function widget( $args, $instance ) {
		
		extract( $args );
		
		$defaults = array(
			'title' => __( 'Popular Posts', BOLTS_TEXT_DOMAIN ),
			'number_posts' => 5,
			'display' => 'thumbnail',
			'show_count' => true,
			'post_type' => 'post',
			'method' => 'comments'
		);
		
		extract( wp_parse_args( $instance, $defaults ) );
		
		global $wpdb;

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		
		echo $this->get_popular_posts( array(
			'number_posts' => $number_posts,
			'display'      => $display,
			'show_count'   => $show_count,
			'post_type'    => $post_type,
			'method'       => $method
		) );
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number_posts'] = $new_instance['number_posts'];
		$instance['display'] = $new_instance['display'];
		$instance['post_type'] = $new_instance['post_type'];
		$instance['method'] = $new_instance['method'];
		$instance['show_count'] = isset( $new_instance['show_count'] ) ? true : false;

		return $instance;
	}
	
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __( 'Popular Posts', BOLTS_TEXT_DOMAIN ), 'number_posts' => 5, 'display' => 'thumbnail', 'show_count' => true, 'post_type' => 'post' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', BOLTS_TEXT_DOMAIN ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
	
		<p>
			<label for="<?php echo $this->get_field_id( 'number_posts' ); ?>"><?php _e( 'Number of posts to show:', BOLTS_TEXT_DOMAIN ); ?></label>
			<input class="widefat" size="4" id="<?php echo $this->get_field_id( 'number_posts' ); ?>" name="<?php echo $this->get_field_name( 'number_posts' ); ?>" value="<?php echo $instance['number_posts']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'display' ); ?>"><?php _e( 'Display:', BOLTS_TEXT_DOMAIN ); ?></label>
			<select id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>" class="widefat">
				<option value="thumbnail" <?php selected( 'thumbnail', $instance['display'] ); ?>><?php _e( 'Post thumbnail', BOLTS_TEXT_DOMAIN ); ?></option>
				<option value="text" <?php selected( 'text', $instance['display'] ); ?>><?php _e( 'Text-only list', BOLTS_TEXT_DOMAIN ); ?></option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'method' ); ?>"><?php _e( 'How to determine popularity:', BOLTS_TEXT_DOMAIN ); ?></label>
			<select id="<?php echo $this->get_field_id( 'method' ); ?>" name="<?php echo $this->get_field_name( 'method' ); ?>" class="widefat">
				<option value="comments" <?php selected( 'comments', $instance['method'] ); ?>><?php _e( 'Number of comments', BOLTS_TEXT_DOMAIN ); ?></option>
				<option value="post_views" <?php selected( 'post_views', $instance['method'] ); ?>><?php _e( 'Number of post views', BOLTS_TEXT_DOMAIN ); ?></option>
				<option value="mint" <?php selected( 'mint', $instance['method'] ); ?>><?php _e( 'Mint analytics', BOLTS_TEXT_DOMAIN ); ?></option>
			</select>
		</p>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_count'], true ); ?> id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_count' ); ?>"><?php _e( 'Show view count', BOLTS_TEXT_DOMAIN ); ?></label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e( 'Post type:', BOLTS_TEXT_DOMAIN ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>" value="<?php echo $instance['post_type']; ?>" />
		</p>
		
	<?php
	}
	
	function get_popular_posts( $args = array() ) {
		
		$defaults = array(
			'number_posts' => 5,
			'display'      => 'thumbnail',
			'show_count'   => false,
			'post_type'    => 'post'
		);
		
		return bolts_popular_posts( wp_parse_args( $args, $defaults ) );
	
	}
	
}



/**
 * 125 ad space
 * 
 * @package Bolt
 * @since 1.0b1
 */
class Bolts_125_Widget extends WP_Widget {
	
	function Bolts_125_Widget() {
		
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'ads125', 'description' => __( 'Display 125x125 ads', BOLTS_TEXT_DOMAIN ) );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'bolts-125-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'bolts-125-widget', __( 'Bolts 125 Ads', BOLTS_TEXT_DOMAIN ), $widget_ops, $control_ops );
		
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		/* User-selected settings. */
		$title = apply_filters( 'widget_title', $instance['title'] );
		$number_ads = $instance['number_ads'];
		$ad_here_page = $instance['ad_here_page'];
		
		$all_ads = bolts_option( 'ads125' );
		
		if ( is_array( $all_ads ) ) {
			shuffle( $all_ads );
			$ads = array_slice( $all_ads, 0, 4 );
		}
		else {
			$ads = array();
		}

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		
		if ( !empty( $ads ) ) {
			foreach ( $ads as $ad ) {
				echo '<a href="' . $ad['link'] . '" title="' . $ad['title'] . '"><img src="' . $ad['image'] . '" width="125" height="125" border="0" alt="' . $ad['title'] . '" /></a> ';
			}
		}
		else {
			for ( $i = 0; $i < $number_ads; $i++ ) {
				if ( $ad_here_page != '' )
					echo '<a href="' . $ad_here_page . '"><img src="' . BOLTS_URI . '/images/advertise-here.png" width="125" height="125" border="0" alt="' . __( 'Advertise Here', BOLTS_TEXT_DOMAIN ) . '" /></a> ';
				else
					echo '<img src="' . BOLTS_URI . '/images/advertise-here.png" width="125" height="125" border="0" alt="' . __( 'Advertise Here', BOLTS_TEXT_DOMAIN ) . '" /> ';
			}
		}
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number_ads'] = $new_instance['number_ads'];
		$instance['ad_here_page'] = $new_instance['ad_here_page'];

		return $instance;
	}
	
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __( '', BOLTS_TEXT_DOMAIN ), 'number_ads' => 4, 'ad_here_page' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p><?php printf( __( 'Upload ads in the %s theme options%s.', BOLTS_TEXT_DOMAIN ), '<a href="themes.php?page=Bolts_Theme_Options.php#advertising">', '</a>' ); ?></p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', BOLTS_TEXT_DOMAIN ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'number_ads' ); ?>"><?php _e( 'Number of ads to show:', BOLTS_TEXT_DOMAIN ); ?></label>
			<input class="widefat" size="4" id="<?php echo $this->get_field_id( 'number_ads' ); ?>" name="<?php echo $this->get_field_name( 'number_ads' ); ?>" value="<?php echo $instance['number_ads']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'ad_here_page' ); ?>"><em><?php printf( __( 'Advertise Here %s link:', BOLTS_TEXT_DOMAIN ), '</em>' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'ad_here_page' ); ?>" name="<?php echo $this->get_field_name( 'ad_here_page' ); ?>" value="<?php echo $instance['ad_here_page']; ?>" />
		</p>
		
	<?php
	}
	
}



/**
 * Facebook Like box
 * 
 * @package Bolt
 * @since 1.0b1
 */
class Bolts_Facebook_Like_Widget extends WP_Widget {
	
	function Bolts_Facebook_Like_Widget() {
		
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'facebooklike', 'description' => __( 'Facebook Fan Page Box', BOLTS_TEXT_DOMAIN ) );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'bolts-facebooklike-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'bolts-facebooklike-widget', __( 'Bolts Facebook Fan Box', BOLTS_TEXT_DOMAIN ), $widget_ops, $control_ops );
		
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		global $wpdb;

		/* User-selected settings. */
		$title = apply_filters( 'widget_title', $instance['title'] );
		$stream = ( $instance['stream'] ? 'true' : 'false' );
		$header = ( $instance['header'] ? 'true' : 'false' );
		$show_faces = ( $instance['show_faces'] ? 'true' : 'false' );

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		
		echo '<iframe src="http://www.facebook.com/plugins/likebox.php?href=' . $instance['page_url'] . '&amp;width=' . $instance['width'] . '&amp;colorscheme=' . $instance['colorscheme'] . '&amp;show_faces=' . $show_faces . '&amp;stream=' . $stream . '&amp;header=' . $header . '" style="border:none; overflow:hidden; width:' . $instance['width'] . 'px;"></iframe>';
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['page_url'] = $new_instance['page_url'];
		$instance['width'] = $new_instance['width'];
		$instance['colorscheme'] = $new_instance['colorscheme'];
		
		$instance['show_faces'] = isset( $new_instance['show_faces'] ) ? true : false;
		$instance['stream'] = isset( $new_instance['stream'] ) ? true : false;
		$instance['header'] = isset( $new_instance['header'] ) ? true : false;

		return $instance;
	}
	
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Facebook', 'page_url' => '', 'width' => 252, 'colorscheme' => 'light', 'show_faces' => true, 'stream' => true, 'header' => true );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', BOLTS_TEXT_DOMAIN ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'page_url' ); ?>"><?php _e( 'Page URL:', BOLTS_TEXT_DOMAIN ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'page_url' ); ?>" name="<?php echo $this->get_field_name( 'page_url' ); ?>" value="<?php echo $instance['page_url']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Width of box:', BOLTS_TEXT_DOMAIN ); ?></label>
			<input class="widefat" size="8" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" value="<?php echo $instance['width']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'colorscheme' ); ?>"><?php _e( 'Color scheme:', BOLTS_TEXT_DOMAIN ); ?></label>
			<select id="<?php echo $this->get_field_id( 'colorscheme' ); ?>" name="<?php echo $this->get_field_name( 'colorscheme' ); ?>" class="widefat">
				<option <?php selected( 'light', $instance['colorscheme'] ); ?>><?php _e( 'light', BOLTS_TEXT_DOMAIN ); ?></option>
				<option <?php selected( 'dark', $instance['colorscheme'] ); ?>><?php _e( 'dark', BOLTS_TEXT_DOMAIN ); ?></option>
			</select>
		</p>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_faces'], true ); ?> id="<?php echo $this->get_field_id( 'show_faces' ); ?>" name="<?php echo $this->get_field_name( 'show_faces' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_faces' ); ?>"><?php _e( 'Show faces', BOLTS_TEXT_DOMAIN ); ?></label>
		</p>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['stream'], true ); ?> id="<?php echo $this->get_field_id( 'stream' ); ?>" name="<?php echo $this->get_field_name( 'stream' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'stream' ); ?>"><?php _e( 'Show stream', BOLTS_TEXT_DOMAIN ); ?></label>
		</p>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['header'], true ); ?> id="<?php echo $this->get_field_id( 'header' ); ?>" name="<?php echo $this->get_field_name( 'header' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'header' ); ?>"><?php _e( 'Show header', BOLTS_TEXT_DOMAIN ); ?></label>
		</p>
		
	<?php
	}
	
}



/**
 * Twitter feed
 * 
 * @package Bolt
 * @since 1.0b1
 */
class Bolts_Twitter_Widget extends WP_Widget {
	
	var $fields = array();
	
	function Bolts_Twitter_Widget() {
		
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'twitter', 'description' => __( 'Twitter Feed', BOLTS_TEXT_DOMAIN ) );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'bolts-twitter-widget' );
		
		$this->fields = array( 'number_tweets', 'avatar_size', 'loading_text' );

		/* Create the widget. */
		$this->WP_Widget( 'bolts-twitter-widget', __( 'Bolts Twitter Feed', BOLTS_TEXT_DOMAIN ), $widget_ops, $control_ops );
		
		wp_register_script( 'jquery-tweet', BOLTS_SCRIPTS . '/jquery.tweet.js', array( 'jquery' ), null, true );
		
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		global $wpdb;
		wp_print_scripts( 'jquery-tweet' );

		/* User-selected settings. */
		$title = apply_filters( 'widget_title', $instance['title'] );
		$number_tweets = $instance['number_tweets'];
		$avatar_size = $instance['avatar_size'];
		$loading_text = $instance['loading_text'];
		
		$username = bolts_option( 'twitter' );
		
		if ( $username != '' ) {
		
			/* Before widget (defined by themes). */
			echo $before_widget;
	
			/* Title of widget (before and after defined by themes). */
			if ( $title )
				echo $before_title . $title . $after_title;
			
			echo '<div class="bolts_tweet"></div>
			<script>
			    jQuery(document).ready(function($){
			        $("#' . $widget_id . ' .bolts_tweet").tweet({
			            username: "' . $username . '",
			            join_text: "auto",
			            avatar_size: ' . $avatar_size . ',
			            count: ' . $number_tweets . ',
			            auto_join_text_default: "", 
			            auto_join_text_ed: "",
			            auto_join_text_ing: "",
			            auto_join_text_reply: "",
			            auto_join_text_url: "",
			            loading_text: "' . $loading_text . '"
			        });
			    });
			</script>';
			
			/* After widget (defined by themes). */
			echo $after_widget;
			
		} // $username != ''
		
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		
		foreach ( $this->fields as $field ) {
			$instance[$field] = $new_instance[$field];
		}

		return $instance;
	}
	
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title'         => __( 'Twitter', BOLTS_TEXT_DOMAIN ),
			'number_tweets' => 4,
			'avatar_size'   => 32,
			'loading_text'  => __( 'loading tweets...', BOLTS_TEXT_DOMAIN )
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p><?php printf( __( 'Enter your Twitter username in the %s theme options%s to use this widget.', BOLTS_TEXT_DOMAIN ), '<a href="themes.php?page=bolts-options.php#social_media">', '</a>' ); ?></p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', BOLTS_TEXT_DOMAIN ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'number_tweets' ); ?>"><?php _e( 'Number of tweets to show:', BOLTS_TEXT_DOMAIN ); ?></label>
			<input type="text" class="widefat" size="4" id="<?php echo $this->get_field_id( 'number_tweets' ); ?>" name="<?php echo $this->get_field_name( 'number_tweets' ); ?>" value="<?php echo $instance['number_tweets']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'avatar_size' ); ?>"><?php _e( 'Avatar size:', BOLTS_TEXT_DOMAIN ); ?></label>
			<input type="text" class="widefat" size="4" id="<?php echo $this->get_field_id( 'avatar_size' ); ?>" name="<?php echo $this->get_field_name( 'avatar_size' ); ?>" value="<?php echo $instance['avatar_size']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'loading_text' ); ?>"><?php _e( 'Loading text:', BOLTS_TEXT_DOMAIN ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'loading_text' ); ?>" name="<?php echo $this->get_field_name( 'loading_text' ); ?>" value="<?php echo $instance['loading_text']; ?>" />
		</p>
		
	<?php
	}
	
}



/**
 * Login form widget
 * 
 * @package Bolt
 * @since 1.0b1
 */
class Bolts_Login_Form_Widget extends WP_Widget {
	
	function Bolts_Login_Form_Widget() {
		
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'loginform', 'description' => __( 'Login form widget', BOLTS_TEXT_DOMAIN ) );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'bolts-login-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'bolts-login-widget', __( 'Bolts Login Form', BOLTS_TEXT_DOMAIN ), $widget_ops, $control_ops );
		
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		global $wpdb;

		/* User-selected settings. */
		$loggedin_title = apply_filters( 'widget_title', $instance['loggedin_title'] );
		$public_title = apply_filters( 'widget_title', $instance['public_title'] );

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		// Login form
		if ( is_user_logged_in() ) {
			
			/* Title of widget (before and after defined by themes). */
			if ( $loggedin_title )
				echo $before_title . $loggedin_title . $after_title;
			
			echo '<p>
				<a href="' . wp_logout_url( $_SERVER['REQUEST_URI'] ) . '">' . __( 'Log Out', BOLTS_TEXT_DOMAIN ) . '</a> <br />
				<a href="' . site_url() . '/wp-admin/">' . __( 'Site Admin', BOLTS_TEXT_DOMAIN ) . '</a>
			</p>';
			
		} else {
			
			/* Title of widget (before and after defined by themes). */
			if ( $public_title )
				echo $before_title . $public_title . $after_title;
			
			echo '<form class="bolts-form bolts-form-small" action="' . site_url() . '/wp-login.php" method="post">';
				echo '
					<label for="log">' . __( 'Username', BOLTS_TEXT_DOMAIN ) . '</label>
					<input type="text" name="log" id="log" />
					<label for="pwd">' . __( 'Password', BOLTS_TEXT_DOMAIN ) . '</label>
					<input type="password" name="pwd" id="pwd" />
					<label for="rememberme"><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> ' . __( 'Remember me', BOLTS_TEXT_DOMAIN ) . '</label>
					<input type="submit" name="submit" value="' . __( 'Log In', BOLTS_TEXT_DOMAIN ) . '" class="bolts-button" />
					<input type="hidden" name="redirect_to" value="' . $_SERVER['REQUEST_URI'] . '" />
			</form>
			<!--<p><small><a href="' . site_url() . '/wp-login.php?action=lostpassword">' . __( 'Forgot password?', BOLTS_TEXT_DOMAIN ) . '</a></small></p>-->';
		}
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['loggedin_title'] = strip_tags( $new_instance['loggedin_title'] );
		$instance['public_title'] = strip_tags( $new_instance['public_title'] );

		return $instance;
	}
	
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'public_title' => __( 'Log In', BOLTS_TEXT_DOMAIN ), 'loggedin_title' => __( 'Welcome', BOLTS_TEXT_DOMAIN ) );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'public_title' ); ?>"><?php _e( 'Public title:', BOLTS_TEXT_DOMAIN ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'public_title' ); ?>" name="<?php echo $this->get_field_name( 'public_title' ); ?>" value="<?php echo $instance['public_title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'loggedin_title' ); ?>"><?php _e( 'Title for logged-in users:', BOLTS_TEXT_DOMAIN ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'loggedin_title' ); ?>" name="<?php echo $this->get_field_name( 'loggedin_title' ); ?>" value="<?php echo $instance['loggedin_title']; ?>" />
		</p>
		
	<?php
	}
	
}


/**
 * Contact form widget
 * 
 * @package Bolts
 * @since 1.0b1
 * @modified 1.1.1
 */
class Bolts_Contact_Form_Widget extends WP_Widget {
	
	var $show_fields;
	
	function Bolts_Contact_Form_Widget() {
		
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'contactform', 'description' => __( 'Contact form widget', BOLTS_TEXT_DOMAIN ) );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'bolts-contact-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'bolts-contact-widget', __( 'Bolts Contact Form', BOLTS_TEXT_DOMAIN ), $widget_ops, $control_ops );
		
		$this->show_fields = array(
			'name'    => __( 'Name', BOLTS_TEXT_DOMAIN ),
			'email'   => __( 'Email', BOLTS_TEXT_DOMAIN ),
			'website' => __( 'Website', BOLTS_TEXT_DOMAIN ),
			'company' => __( 'Company', BOLTS_TEXT_DOMAIN ),
			'message' => __( 'Message', BOLTS_TEXT_DOMAIN ),
			'copy'    => __( 'Send me a copy', BOLTS_TEXT_DOMAIN )
		);
		
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		global $wpdb;

		$title = apply_filters( 'widget_title', $instance['title'] );

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		
		$fields = array();
		foreach ( $this->show_fields as $id => $field ) {
			if ( $instance[$id] )
				$fields[] = $id;
		}
		$show_these = implode( ',', $fields );
		
		// Contact form
		echo '<div class="bolts-form-small">
		' . do_shortcode( '[contact-form fields="' . $show_these . '"]' ) . '
		</div>';
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		
		foreach ( $this->show_fields as $id => $name )
			$instance[$id] = isset( $new_instance[$id] ) ? true : false;

		return $instance;
	}
	
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title'   => __( 'Contact Us', BOLTS_TEXT_DOMAIN ),
			'name'    => true,
			'email'   => true,
			'message' => true,
			'website' => false,
			'company' => false,
			'copy'    => true
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p><?php printf( __( 'Set the contact email in the %s theme options%s.', BOLTS_TEXT_DOMAIN ), '<a href="themes.php?page=Bolts_Theme_Options.php#general">', '</a>' ); ?></p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', BOLTS_TEXT_DOMAIN ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p><?php _e( 'Show fields:', BOLTS_TEXT_DOMAIN ); ?></p>
		
		<p>
			<?php foreach ( $this->show_fields as $id => $name ) : ?>
				<input class="checkbox" type="checkbox" <?php checked( $instance[$id], true ); ?> id="<?php echo $this->get_field_id( $id ); ?>" name="<?php echo $this->get_field_name( $id ); ?>" />
				<label for="<?php echo $this->get_field_id( $id ); ?>"><?php _e( $name, BOLTS_TEXT_DOMAIN ); ?></label><br />
			<?php endforeach; ?>
		</p>
		
	<?php
	}
	
}

?>