<?php

/**
 * Shortcodes for extra editor GUI goodness
 * 
 * @package Bolts
 * @since 1.0
 */
class Bolts_Shortcodes {
	
	function __construct() {
		
		add_shortcode( 'divider',      array( &$this, 'divider' ) );
		add_shortcode( 'facebook',     array( &$this, 'facebook' ) );
		add_shortcode( 'twitter',      array( &$this, 'twitter' ) );
		add_shortcode( 'digg',         array( &$this, 'digg' ) );
		add_shortcode( 'google-plusone', array( &$this, 'google_plusone' ) );
		add_shortcode( 'linkedin',     array( &$this, 'linkedin' ) );
		add_shortcode( 'contact-form', array( &$this, 'form' ) );
		add_shortcode( 'toc',          array( &$this, 'table_of_contents' ) );
		add_shortcode( 'columns',      array( &$this, 'columns' ) );
		
	}
	
	/**
	 * [bolts-divider]
	 * Horizontal rule
	 *
	 * @since 1.0b1
	 */
	public function divider( $atts ) {
		
		return '<hr class="bolts-divider" />';
		
	}
	
	/**
	 * [facebook action="like/recommend" layout="button_count/box_count"
	 * font="arial/lucida grande/segoe ui/tahoma/trebuchet ms/verdana"
	 * colorscheme="light/dark"]
	 * Facebook "Like" button
	 * 
	 * Default font & color scheme based on theme; they can be
	 * overridden in the post editor.
	 *
	 * @since 1.0b1
	 */
	public function facebook( $atts ) {
		extract( shortcode_atts( array(
			'action' => 'like',
			'layout' => 'default',
			'font' => 'lucida grande',
			'colorscheme' => 'light',
			'show_faces' => 'true',
			'width' => null,
			'send' => 'true'
		), $atts ) );
		
		wp_print_scripts( 'bolts-fbml5-init' );
		
		global $post;
		
		$the_width = ( $width == null ) ? '' : ' data-width="' . $width . '"';
		
		if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0' ) !== false ) {
			return '<iframe src="http://www.facebook.com/plugins/like.php?href=' . get_permalink( $post->ID ) . '&amp;send=true&amp;layout=' . $layout . '&amp;width=' . $width . '&amp;show_faces=' . $show_faces . '&amp;action=' . $action . '&amp;colorscheme=' . $colorscheme . '&amp;font=' . $font . '&amp;height=21&amp;send=' . $send . '" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:' . $width . 'px; height:21px;" allowTransparency="true"></iframe>';
		}
		else {
			return '<embed data-fb="like" data-href="' . get_permalink( $post->ID ) . '" data-layout="' . $layout . '" data-action="' . $action . '" data-font="' . $font . '" data-show_faces="' . $show_faces . '" data-colorscheme="' . $colorscheme . '" data-send="' . $send . '"' . $the_width . ' />';
		}
		
	}
	
	/**
	 * [twitter count="vertical/horizontal/none" lang="en/es/fr/de/ja"]
	 * Tweet button
	 * 
	 * Default font & color scheme based on theme; they can be
	 * overridden in the post editor.
	 *
	 * @since 1.0b1
	 */
	public function twitter( $atts ) {
		extract( shortcode_atts( array(
			'count' => 'vertical',
			'via' => bolts_option( 'twitter' ),
			'lang' => 'en'
		), $atts ) );
		
		wp_print_scripts( 'bolts-twitter' );
		
		global $post;
		
		return '<a href="http://twitter.com/share" class="twitter-share-button" data-count="' . $count . '" data-via="' . $via . '" data-lang="' . $lang . '" data-url="' . get_permalink( $post->ID ) . '">' . __( 'Tweet', BOLTS_TEXT_DOMAIN ) . '</a>';
		
	}
	
	/**
	 * [bolts-digg layout="wide/medium/compact/icon"]
	 * Digg button
	 *
	 * @since 1.0b1
	 */
	public function digg( $atts ) {
		extract( shortcode_atts( array(
			'layout' => 'medium'
		), $atts ) );
		
		wp_print_scripts( 'bolts-digg' );
		
		global $post;
		
		return '<a style="text-decoration: none;" class="DiggThisButton Digg' . ucfirst( $layout ) . '" href="http://digg.com/submit?url=' . get_permalink( $post->ID ) . '"></a>';
		
	}
	
	/**
	 * [google-plusone size="standard|small|medium|tall" count="true|false"]
	 * Digg button
	 *
	 * @since 1.0b1
	 */
	public function google_plusone( $atts ) {
		extract( shortcode_atts( array(
			'count' => 'true',
			'size' => 'standard'
		), $atts ) );
		
		wp_print_scripts( 'bolts-google-plusone' );
		
		global $post;
		
		return '<g:plusone size="' . $size . '" count="' . $count . '" href="' . get_permalink( $post->ID ) . '"></g:plusone>';
		
	}
	
	public function linkedin( $atts ) {
		
		extract( shortcode_atts( array(
			'count' => 'top'
		), $atts ) );
		
		wp_print_scripts( 'bolts-linkedin' );
		
		global $post;
		
		return '<script type="IN/Share" data-url="' . get_permalink( $post->ID ) . '" data-counter="' . $count . '"></script>';
		
	}
	
	/**
	 * [bolts-contact-form fields="name,email,company,website,message"]
	 * Contact form
	 *
	 * @since 1.0b1
	 */
	public function form( $atts ) {
		extract( shortcode_atts( array(
			'fields' => 'name,email,website,message,copy'
		), $atts ) );
		
		wp_print_scripts( 'bolts-forms' );
		
		$f = explode( ',', $fields );
		
		$html = '';
		
		if ( isset( $_POST['bolts-form-posted'] ) ) {
		
			if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'bolts-nonce' ) ) {
			
				$html .= '<div class="bolts-callout warning"><p>' . __( 'There was an error sending the message. Please try again.', BOLTS_TEXT_DOMAIN ) . '</p></div>';
			
			}
			
			else {
			
				date_default_timezone_set( get_option( 'timezone_string' ) );
				
				$send_to_email = bolts_option( 'contact_form_email' );
			
				$subject = '[' . get_bloginfo('name') . '] ' . __( 'New Message', BOLTS_TEXT_DOMAIN );
				
				$message = '<p style="color: #999; font: 12px/17px Arial, sans-serif; width: 600px; margin: 10px auto;">' . __( sprintf( 'New message from %s ', '<strong>' . $_POST['bolts-name'] . '</strong>' ) ) . ' | ' . date( 'F j, Y g:i A' ) . '</p>';
				
				$message .= '<table border="0" cellpadding="0" cellspacing="0" style="font: 12px/17px Arial, sans-serif; width: 600px; margin: 10px auto;">';
				
				foreach ( $f as $field ) :
				
					if ( $field != 'copy' ) {
						$message .= '<tr><td style="vertical-align: top; padding: 8px; border-bottom: 1px solid #e5e5e5;"><strong>' . ucfirst( $field ) . '</strong></td>';
						$message .= '<td style="vertical-align: top; padding: 8px; border-bottom: 1px solid #e5e5e5;">' . nl2br( stripslashes( $_POST['bolts-' . $field] ) ) . '</td></tr>';
					}
				
				endforeach;
				
				$message .= '</table>';
				
				$headers = 'From: ' . get_bloginfo('name') . ' <' . get_bloginfo('admin_email') . "> \r\n";
				
				if ( isset( $_POST['bolts-email'] ) )
					$headers .= 'Reply-to: ' . $_POST['bolts-name'] . ' <' . $_POST['bolts-email'] . "> \r\n";
				
				$headers .= 'Content-type: text/html; charset=' . get_option('blog_charset') . "\r\n";
				
				if ( wp_mail( get_bloginfo('name') . ' <' . $send_to_email . '>', $subject, $message, $headers ) ) {
					
					if ( isset( $_POST['bolts-sendcopy'] ) ) {
						$subject = '[' . get_bloginfo('name') . '] ' . __( 'A Copy of Your Message', BOLTS_TEXT_DOMAIN );
						$headers = 'From: ' . get_bloginfo('name') . ' <' . get_bloginfo('admin_email') . "> \r\n";
						$headers .= 'Content-type: text/html; charset=' . get_option('blog_charset') . "\r\n";
						wp_mail( $_POST['bolts-name'] . ' <' . $_POST['bolts-email'] . '>', $subject, $message, $headers );
					}
					
					unset( $_POST );
					$html .= '<div class="bolts-callout success"><p>' . __( 'Thank you! Your message has been sent.', BOLTS_TEXT_DOMAIN ) . '</p></div>';
				}
				else {
					$html .= '<div class="bolts-callout warning"><p>' . __( 'There was an error sending the message. Please try again.', BOLTS_TEXT_DOMAIN ) . '</p></div>';
				}
				/* */
				
			} // wp_verify_nonce
			
		} // isset($_POST)
		
		$html .= '<form method="post" class="bolts-form" id="bolts-contact-form">
		<ul>';
		
		foreach ( $f as $field ) :
		
			$html .= '<li>';
			
			if ( $field != 'copy' )
				$html .= '<label for="bolts-' . $field . '">' . ucfirst( $field ) . '</label>';
			
			$existing_val = '';
			if ( isset( $_POST['bolts-' . $field] ) )
				$existing_val = $_POST['bolts-' . $field];
			
			switch ( $field ) {
			
				case 'message':
					$html .= '<textarea name="bolts-message" id="bolts-message" required="required">' . $existing_val . '</textarea>';
					break;
				
				case 'name':
					$html .= '<input type="text" name="bolts-name" id="bolts-name" value="' . $existing_val . '" required="required" />';
					break;
				
				case 'email':
					$html .= '<input type="email" name="bolts-' . $field . '" id="bolts-' . $field . '" value="' . $existing_val . '" required="required" />';
					break;
				
				case 'website':
					$html .= '<input type="url" name="bolts-website" id="bolts-website" value="' . $existing_val . '" />';
					break;
					
				case 'copy':
					$html .= '<p><label for="bolts-sendcopy"><input type="checkbox" name="bolts-sendcopy" id="bolts-sendcopy" value="on" /> ' . __( 'Send me a copy', BOLTS_TEXT_DOMAIN ) . '</label></p>';
					break;
					
				default:
					$html .= '<input type="text" name="bolts-' . $field . '" id="bolts-' . $field . '" value="' . $existing_val . '" />';
					break;
			
			} // switch
			
			$html .= '</li>';
		
		endforeach;
		
		$html .= '<li>
			<input type="hidden" name="bolts-form-posted" value="1" />
			<input type="hidden" name="_wpnonce" value="' . wp_create_nonce( 'bolts-nonce' ) . '" />
			<input type="submit" class="bolts-button" value="'. __( 'Send Message', BOLTS_TEXT_DOMAIN ) . '" />
			</li>
		
		</ul>
		</form>
		
		<script>
		jQuery(document).ready(function($) {
			$("#bolts-contact-form").submit(function() {
				$(this).children("input").focus().blur();
				
				if ($(this).has(".required").length > 0) {
				
					$(this).prev(".bolts-callout.warning").remove();
					$(this).before("<div class=\"bolts-callout warning\"><p>' . __( 'Please fill out all required fields.', BOLTS_TEXT_DOMAIN ) . '</p></div>");
					return false;
				}
				
				else if ($("#bolts-name").val() == "" || $("#bolts-email").val() == "" || $("#bolts-message").val() == "") {
					
					if ($("#bolts-name").val() == "")
						$("#bolts-name").addClass("required").parent().addClass("required");
					if ($("#bolts-email").val() == "")
						$("#bolts-email").addClass("required").parent().addClass("required");
					if ($("#bolts-message").val() == "")
						$("#bolts-message").addClass("required").parent().addClass("required");
					
					$(this).prev(".bolts-callout.warning").remove();
					$(this).before("<div class=\"bolts-callout warning\"><p>' . __( 'Please fill out all required fields.', BOLTS_TEXT_DOMAIN ) . '</p></div>");
					return false;
					
				}
				
				else {
					return true;
				}
			});
		});
		</script>';
		
		return $html;
		
	}
	
	/**
	 * [toc levels="2-6" type="numbered|bullets|mixed"]
	 * Wikipedia-style table of contents
	 *
	 * @since 1.0b2
	 */
	public function table_of_contents( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'levels' => '2-6',
			'type' => 'bullets',
			'title' => __( 'In This Article', BOLTS_TEXT_DOMAIN )
		), $atts ) );
		
		global $post;
		
		if ( $type == 'numbered' )
			$list_type = 'ol';
		elseif ( $type == 'mixed' )
			$list_type = 'mixed';
		else
			$list_type = 'ul';
		
		$toc = bolts_table_of_contents( array(
			'heading_levels' => $levels,
			'list_type' => $list_type,
			'content' => $post->post_content,
			'title' => $title
		) );
		
		return $toc['list'];
	}
	
	/**
	 * [columns across="2|3|4|5|6|etc."]Content[column-break]More content[/columns]
	 * Columnized text
	 *
	 * @since 1.0b1
	 */
	public function columns( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'across' => 2,
			'rule' => false
		), $atts ) );
		
		$final_content = '';
		
		$rule_class = '';
		if ( $rule )
			$rule_class = ' rule';
		
		$content = force_balance_tags( $content );
		
		if ( strpos( $content, '<p>[column-break]</p>' ) !== false )
			$columns = explode( '<p>[column-break]</p>', $content );
		else
			$columns = explode( '[column-break]', $content );
		
		for ( $i = 0; $i < count( $columns ); $i++ ) {
			
			if ( $i == 0 )
				$final_content .= '<div class="bolts-column' . $rule_class . ' first">' . $columns[$i] . '</div>';
			elseif ( $i == count( $columns ) - 1 )
				$final_content .= '<div class="bolts-column' . $rule_class . ' last">' . $columns[$i] . '</div>';
			else
				$final_content .= '<div class="bolts-column' . $rule_class . '">' . $columns[$i] . '</div>';
			
		}
		
		$column_script = '<script>
		jQuery(document).ready(function($) {
			$(".bolts-columns").each(function() {
				$(this).children().css("height", $(this).css("height"));
			});
		});
		</script>';
		
		return '<div class="bolts-columns across-' . $across . '">' . ( str_replace( '<p></p>', '', $final_content ) ) . '</div>' . $column_script;
	}
	
}

?>