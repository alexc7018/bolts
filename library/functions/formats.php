<?php

/**
 * Convert a chat post into a definition list based on "Name: What they said" content
 *
 * @since 1.0b1
 */
function bolts_chat_content() {
	
	global $post;
	
	$output = '<dl class="bolts-chat">';
	
	$lines = preg_split( "/(\r*?\n)+/", $post->post_content );
	
	$i = 0;
	foreach ( $lines as $line ) :
		
		$i++;
		
		if ( strpos( $line, ':' ) !== false ) {
			
			$line_pieces = explode( ':', $line, 2 );
			$name = strip_tags( trim( $line_pieces[0] ) );
			$text = force_balance_tags( strip_tags( trim( $line_pieces[1] ), '<strong><em><a><img><del><ins><span>' ) );
			
			$rowclass = ( $i % 2 == 0 ? ' class="alt"' : '' );
			
			$output .= '<dt' . $rowclass . '>' . $name . ':</dt><dd' . $rowclass . '>' . $text . '</dd>';
			
		}
		else {
			$output .= '</dl>' . $line . '<dl class="bolts-chat">';
		}
		
	endforeach;
	
	$output .= '</dl>';
	
	// Remove any empty definition lists
	$output = str_replace( '<dl class="bolts-chat"></dl>', '', $output );
	
	return apply_filters( 'the_content', $output );
	
}

/**
 * Find the first image in a post
 *
 * @since 1.0b1
 */
function bolts_first_image() {

	global $post;

	preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', $post->post_content, $matches );

	if ( isset( $matches ) )
		return $matches;
	else
		return false;
}

/**
 * Find the first link in a post (for link post formats)
 *
 * @since 1.0
 * @modified 1.1
 */
function bolts_first_link() {

	global $post;
	
	$content1 = $post->post_content;
	
	preg_match_all( '|<a.*?(title=[\'"](.*?)[\'"])*? href=[\'"](.*?)[\'"].*?>(.*?)</a>|i', $post->post_content, $matches );
	
	if ( isset( $matches ) ) {
		
		$title = apply_filters( 'post_title', $post->post_title );
		
		// link has a title attribute
		if ( isset( $matches[2][0] ) && $matches[2][0] != '' )
			$title_attribute = $matches[2][0];
		
		// link has no title, use post title
		elseif ( $post->post_title != '' )
			$title_attribute = $post->post_title;
		
		// link and post have no title, use description
		else
			$title_attribute = ( isset( $matches[4][0] ) ? $matches[4][0] : '' );
		
		$url = ( isset( $matches[3][0] ) ? $matches[3][0] : '' );
		$desc = ( isset( $matches[4][0] ) ? $matches[4][0] : '' );
		
		return array(
			'title'      => $title,
			'title_attr' => $title_attribute,
			'url'        => $url,
			'desc'       => $desc
		);
	}
	else {
		return false;
	}
}

/**
 * Display a div containing the current post's format
 *
 * @since 1.0b1
 */
function bolts_display_post_format() {
	
	$format = ucwords( get_post_format() );
	
	if ( $format == '' )
		$format = __( 'Blog', BOLTS_TEXT_DOMAIN );
	
	echo apply_filters( 'bolts_display_post_format', '<div class="post-format">' . __( $format, BOLTS_TEXT_DOMAIN ) . '</div>' );
	
}

?>