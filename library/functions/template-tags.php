<?php
/**
 * Get theme option
 *
 * @since 1.0b1
 */
function bolts_option( $option ) {
	$options = get_option( 'bolts_options' );
	if ( isset( $options[$option] ) )
		return $options[$option];
	else
		return false;
}

/**
 * Strip string of HTML and special chars
 *
 * @since 1.0b1
 */
if ( ! function_exists( 'bolts_clean' ) ) :
	function bolts_clean( $str ) {
		return esc_html( strip_tags( stripslashes( $str ) ) );
	}
endif;

/**
 * Apply class to page layout (default, sidebar, etc.)
 *
 * @since 1.0b1
 */
if ( ! function_exists( 'bolts_page_layout_class' ) ) :
	function bolts_page_layout_class() {
		
		global $post;
		
		echo 'layout-';
		
		if ( isset( $post->ID ) ) {
			if ( get_post_meta( $post->ID, 'bolts_page_layout', true ) )
				echo get_post_meta( $post->ID, 'bolts_page_layout', true );
			else
				echo 'default';
		}
		else {
			echo 'default';
		}
		
	}
endif;

function bolts_link_pages_args() {
	
	return array(
		'before'         => '<div class="pagination"><span class="page-link-meta">' . __( 'Pages:', BOLTS_TEXT_DOMAIN ) . '</span>',
		'after'          => '</div>',
		'next_or_number' => 'number',
		'link_before'    => '<span>',
		'link_after'     => '</span>'
	);
	
}

/**
 * Post pagination links
 *
 * @since 1.0b1
 */
if ( ! function_exists( 'bolts_paginate_links' ) ) :
	function bolts_paginate_links() {
		
		global $wp_rewrite, $wp_query;
		
		$current = ( $wp_query->query_vars['paged'] > 1 ? $wp_query->query_vars['paged'] : 1 );
		
		$pagination = array(
			'base' => @add_query_arg( 'paged','%#%' ),
			'format' => '',
			'total' => $wp_query->max_num_pages,
			'current' => $current,
			'show_all' => false,
			'type' => 'plain',
		);
		
		if( ! empty( $wp_query->query_vars['s'] ) )
			$pagination['add_args'] = array( 's' => get_query_var( 's' ) );
		
		echo '<nav class="pagination">' . paginate_links( $pagination ) . '</nav>';
		
	}
endif;

/**
 * Store content width for this theme in a global variable
 *
 * @since 1.0b1
 */
function bolts_content_width( $width = 600 ) {
	
	global $content_width;
	
	$content_width = $width;
	
	return true;
	
}

/**
 * Get URL of any post thumbnail, use timthumb to customize size
 *
 * @since 1.0b1
 */
if ( ! function_exists( 'bolts_post_thumbnail' ) ) :
	function bolts_post_thumbnail( $post_ID = null, $width = 150, $height = 150 ) {
		
		if ( $post_ID == null ) {
			global $post;
			$post_ID = $post->ID;
		}
		
		$image_id = get_post_thumbnail_id( $post_ID );
		$image = wp_get_attachment_image_src( $image_id, 'full' );
		//print_r( $image );
		$image_src = $image[0];
		
		$url = BOLTS_EXTENSIONS . '/timthumb.php?';
		
		$url .= 'src=' . $image_src;
		$url .= '&w=' . $width;
		$url .= '&h=' . $height;
		$url .= '&zc=1';
		
		return $url;
		
	}
endif;

/**
 * Post meta & comments link
 *
 * @since 1.0b1
 */
if ( ! function_exists( 'bolts_post_footer' ) ) :
	function bolts_post_footer() {
		
		echo '<div class="post-meta">';
		
		$format = get_post_format();
		if ( ! $format )
			$format = 'standard';
		
		printf( __( '%1$s <span class="meta-sep">by</span> %2$s' ),
			sprintf( '<span class="entry-date">%3$s</span>',
				get_permalink(),
				esc_attr( get_the_time() ),
				bolts_date( get_the_date() . ' ' . get_the_time(), 'post' )
			),
			sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
				get_author_posts_url( get_the_author_meta( 'ID' ) ),
				sprintf( esc_attr__( 'View all posts by %s', BOLTS_TEXT_DOMAIN ), get_the_author() ),
				get_the_author()
			)
		);
		
		if ( in_array( $format, array( 'chat', 'gallery', 'image', 'link', 'quote', 'standard', 'video' ) ) ) :
			
			echo ' <span class="sep">/</span> ';
		
			// Retrieves tag list of current post, separated by commas.
			$tag_list = get_the_tag_list( '', ', ' );
			if ( $tag_list ) {
				$posted_in = __( 'Posted in %1$s <span class="sep">/</span> Tagged %2$s <span class="sep">/</span> <a href="%3$s" title="Permalink to %4$s" rel="bookmark">Permalink</a>', BOLTS_TEXT_DOMAIN );
			} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
				$posted_in = __( 'Posted in %1$s <span class="sep">/</span> <a href="%3$s" title="Permalink to %4$s" rel="bookmark">Permalink</a>', BOLTS_TEXT_DOMAIN );
			} else {
				$posted_in = __( '<a href="%3$s" title="Permalink to %4$s" rel="bookmark">Permalink</a>', BOLTS_TEXT_DOMAIN );
			}
			// Prints the string, replacing the placeholders.
			printf(
				$posted_in,
				get_the_category_list( ', ' ),
				$tag_list,
				get_permalink(),
				the_title_attribute( 'echo=0' )
			);
			
		endif;
		
		edit_post_link( __( 'Edit', BOLTS_TEXT_DOMAIN ), ' <span class="sep">/</span> ', '' );
		
		echo '</div>';
		
		if ( comments_open() && ! is_single() )
			comments_popup_link( sprintf( __( 'Leave a Comment %s', BOLTS_TEXT_DOMAIN ), '&raquo;' ), sprintf( __( '1 Comment %s', BOLTS_TEXT_DOMAIN ), '&raquo;' ), sprintf( __( '%% Comments %s', BOLTS_TEXT_DOMAIN ), '&raquo;' ), 'comments-link', __( 'Comments Closed', BOLTS_TEXT_DOMAIN ) );
		
	}
endif;

/**
 * Human readable date
 * 
 * From wpcandy: http://wpcandy.com/teaches/how-to-display-human-readable-post-dates
 *
 * @since 1.0b1
 */
if ( ! function_exists( 'bolts_date' ) ) :
	function bolts_date( $date, $type = null ) {
		
		$make_it_pretty = false;
		
		if ( ! isset( $type ) || $type == 'post' ) {
			if ( bolts_option( 'human_readable_post_dates' ) )
				$make_it_pretty = true;
		}
		elseif ( $type == 'comment' ) {
			if ( bolts_option( 'human_readable_comment_dates' ) )
				$make_it_pretty = true;
		}
		
		if ( $make_it_pretty ) {
			if ( get_option( 'timezone_string' ) != '' )
				date_default_timezone_set( get_option( 'timezone_string' ) );
			
			$post_time = strtotime( $date );
			$current_time = time();
			$time_difference = $current_time - $post_time;
			
			$minute = 60;
			$hour = 3600;
			$day = 86400;
			$week = $day * 7;
			$month = $day * 31;
			$year = $day * 366;
			
			// if over 3 years
			if ( $time_difference > $year * 3 ) {
				$friendly_date = __( 'a long while ago', BOLTS_TEXT_DOMAIN );
			}
			
			// if over 2 years
			else if ( $time_difference > $year * 2 ) {
				$friendly_date =__( 'over 2 years ago', BOLTS_TEXT_DOMAIN );
			}
			
			// if over 1 year
			else if ( $time_difference > $year ) {
				$friendly_date = __( 'over a year ago', BOLTS_TEXT_DOMAIN );
			}
			
			// if over 11 months
			else if ( $time_difference >= $month * 11 ) {
				$friendly_date = __( 'about a year ago', BOLTS_TEXT_DOMAIN );
			}
			
			// if over 2 months
			else if ( $time_difference >= $month * 2 ) {
				$months = (int) $time_difference / $month;
				$friendly_date = sprintf( __( 'about %d months ago', BOLTS_TEXT_DOMAIN ), $months );
			}
			
			// if over 4 weeks ago
			else if ( $time_difference > $week * 4 ) {
				$friendly_date = __( 'about a month ago', BOLTS_TEXT_DOMAIN );
			}
			
			// if over 3 weeks ago
			else if ( $time_difference > $week * 3 ) {
				$friendly_date = __( '3 weeks ago', BOLTS_TEXT_DOMAIN );
			}
			
			// if over 2 weeks ago
			else if ( $time_difference > $week * 2 ) {
				$friendly_date = __( '2 weeks ago', BOLTS_TEXT_DOMAIN );
			}
			
			// if equal to or more than a week ago
			else if ( $time_difference >= $day * 7 ) {
				$friendly_date = __( 'about a week ago', BOLTS_TEXT_DOMAIN );
			}
			
			// if equal to or more than 2 days ago
			else if ( $time_difference >= $day * 2 ) {
				$days = (int) $time_difference / $day;
				$friendly_date = sprintf( __( 'about %d days ago', BOLTS_TEXT_DOMAIN ), $days );
			}
			
			// if equal to or more than 1 day ago
			else if ( $time_difference >= $day ) {
				$friendly_date = __( 'yesterday', BOLTS_TEXT_DOMAIN );
			}
			
			// 1 or more hours ago
			else if ( $time_difference >= $hour ) {
				$hours = (int) $time_difference / $hour;
				$friendly_date = sprintf( __( 'about %d hours ago', BOLTS_TEXT_DOMAIN ), $hours );
			}
			
			// 1 or more minutes ago
			else if ( $time_difference >= $minute * 2 ) {
				$minutes = (int) $time_difference / $minute;
				$friendly_date = sprintf( __( '%d minutes ago', BOLTS_TEXT_DOMAIN ), $minutes );
			}
			
			else {
				$friendly_date = __( 'just now', BOLTS_TEXT_DOMAIN );
			}
			
			//<time datetime="2009-11-13T20:00+00:00"> </time>
			
			return '<time title="' . $date . '" datetime="' . date( 'c', strtotime( $date ) ) . '" pubdate>' . ucfirst( $friendly_date ) . '</time>';
		}
		else {
			return $date;
		}
		
	}
endif;

/**
 * Breadcrumb
 *
 * @since 1.0b1
 */
if ( ! function_exists( 'bolts_breadcrumb' ) ) :
	function bolts_breadcrumb( $before = '', $after = '', $display = true, $sep = ' &rsaquo; ' ) {
		
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			if ( $display ) {
				yoast_breadcrumb( $before, $after );
				return;
			}
			else {
				return yoast_breadcrumb( $before, $after, false );
			}
		}
		
		if ( ! $sep )
			$sep = ' &rsaquo; ';
		
		$current_before = '<span class="breadcrumb-current">';
		$current_after = '</span>';
		
		global $post, $wp_query;
		if ( empty( $post ) && is_singular() )
			$post = get_post( $postid );
		
		$crumbs = array();
		$crumbs[] = '<a href="' . home_url() . '">' . __( 'Home', BOLTS_TEXT_DOMAIN ) . '</a>';
		
		if ( is_home() || ( is_front_page() && ! is_paged() ) )
			return;
			
		if ( is_category() ) {
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$this_cat = $cat_obj->term_id;
			$this_cat = get_category( $this_cat );
			$parent_cat = get_category( $this_cat->parent );
			
			if ( $this_cat->parent != 0 )
				$crumbs[] = get_category_parents( $parent_cat, true, $sep );
			
			$crumbs[] = $current_before . single_cat_title( '', false ) . $current_after;
		
		} elseif ( is_day() ) {
			$crumbs[] = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a>';
			$crumbs[] =  '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time('F') . '</a>';
			$crumbs[] =  $current_before . get_the_time( 'd' ) . $current_after;
		
		} elseif ( is_month() ) {
			$crumbs[] = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a>';
			$crumbs[] = $current_before . get_the_time( 'F' ) . $current_after;
		
		} elseif ( is_year() ) {
			$crumbs[] = $current_before . get_the_time( 'Y' ) . $current_after;
		
		} elseif ( is_single() && !is_attachment() ) {
			$cat = get_the_category();
			$cat = $cat[0];
			
			if ( $cat->parent != 0 )
				$crumbs[] = get_category_parents( $cat, true, $sep );
			
			$crumbs[] = $current_before . get_the_title() . $current_after;
		
		} elseif ( is_attachment() ) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category( $parent->ID );
			$cat = $cat[0];
			
			$crumbs[] = get_category_parents( $cat, TRUE, $sep );
			$crumbs[] = '<a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a>';
			$crumbs[] = $current_before . get_the_title() . $current_after;
		
		} elseif ( is_page() && !$post->post_parent ) {
			$crumbs[] = $current_before . get_the_title() . $current_after;
		
		} elseif ( is_page() && $post->post_parent ) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			
			while ( $parent_id ) {
				$page = get_page( $parent_id );
				$breadcrumbs[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
				$parent_id  = $page->post_parent;
			}
			
			$breadcrumbs = array_reverse( $breadcrumbs );
			
			foreach ( $breadcrumbs as $crumb )
				$crumbs[] = $crumb;
			
			$crumbs[] = $current_before . get_the_title() . $current_after;
		
		} elseif ( is_search() ) {
			$crumbs[] = $current_before . sprintf( __( 'Search results for %s', BOLTS_TEXT_DOMAIN ), '&lsquo;' . get_search_query() . '&rsquo;' ) . $current_after;
		
		} elseif ( is_tag() ) {
			$crumbs[] = $current_before . sprintf( __( 'Posts tagged %s', BOLTS_TEXT_DOMAIN ), '&lsquo;' . single_tag_title( '', false ) . '&rsquo;' ) . $current_after;
		
		} elseif ( is_author() ) {
			global $author;
			$userdata = get_userdata( $author );
			$crumbs[] = $current_before . sprintf( __( 'Articles posted by %s', BOLTS_TEXT_DOMAIN ), $userdata->display_name ) . $current_after;
		
		} elseif ( is_404() ) {
			$crumbs[] = $current_before . __( 'Page Not Found', BOLTS_TEXT_DOMAIN ) . $current_after;
		}
		
		if ( get_query_var('paged') ) {
			$str = '';
			
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
				$str .= ' (';
			
			$str .= __('Page') . ' ' . get_query_var('paged');
			
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
				$str .= ')';
			
			$crumbs[] = $str;
		}
		
		$breadcrumbs = '<div class="bolts-breadcrumbs">' . implode( $sep, $crumbs ) . '</div>';
		
		$breadcrumbs = str_replace( $sep . $sep, $sep, $breadcrumbs );
		
		if ( $display )
			echo $before . $breadcrumbs . $after;
		else
			return $before . $breadcrumbs . $after;
		
	}
endif;

/**
 * Highlight string (search query) in text, preserving capitalization
 *
 * @since 1.0b1
 */
function bolts_highlight_text( $haystack, $needle ) {
	
	if ( strlen( $haystack ) < 1 || strlen( $needle ) < 1 )
		return $haystack;
	
	preg_match_all( '/' . $needle . '+/i', $haystack, $matches );
	if ( is_array( $matches[0] ) && count( $matches[0] ) >= 1 ) {
		foreach ( $matches[0] as $match )
			$haystack = str_replace( $match, "<mark>$match</mark>", $haystack );
	}
	return $haystack;
}

/**
 * Displays if no posts are found in a query.
 * @since 1.0b1
 */
function bolts_no_posts_found() {
	$content = '<h1>' . sprintf( __( 'No results found for %s', BOLTS_TEXT_DOMAIN ), '<mark>' . get_search_query() . '</mark>' ) . '</h1>';
	echo apply_filters( 'bolts_no_posts_found', $content );
	get_search_form();
}

/**
 * Archive title (category/tag/etc.)
 *
 * @since 1.0b1
 */
if ( ! function_exists( 'bolts_archive_title' ) ) :
	function bolts_archive_title( $echo = true ) {
		
		global $post, $wp_query;
		if ( empty($post) && is_singular() )
			$post = get_post($postid);
		
		if ( is_category() )
			$title = sprintf( __( 'Posts in %s', BOLTS_TEXT_DOMAIN ), '&lsquo;' . single_cat_title( '', false ) . '&rsquo;' );
		elseif ( is_tag() )
			$title = sprintf( __( 'Posts tagged %s', BOLTS_TEXT_DOMAIN ), '&lsquo;' . single_tag_title( '', false ) . '&rsquo;' );
		elseif ( is_year() )
			$title = sprintf( __( 'Posts from %s', BOLTS_TEXT_DOMAIN ), get_the_date( 'Y' ) );
		elseif ( is_month() )
			$title = sprintf( __( 'Posts from %s', BOLTS_TEXT_DOMAIN ), get_the_date( 'F, Y' ) );
		elseif ( is_day() )
			$title = sprintf( __( 'Posts from %s', BOLTS_TEXT_DOMAIN ), get_the_date() );
		elseif ( is_author() )
			$title = sprintf( __( 'Posts by %s', BOLTS_TEXT_DOMAIN ), get_the_author() );
		
		if ( $echo )
			echo $title;
		else
			return $title;
		
	}
endif;

/**
 * Nav menu display
 *
 * @since 1.0b1
 */
function bolts_menu( $menu ) {
	
	call_user_func( 'bolts_before_' . $menu . '_menu' );
	
	$menuclass = 'bolts-menu';
	
	if ( $menu == 'primary' || $menu == 'secondary' )
		$menuclass .= ' bolts-drop-down-menu';
	
	echo '<nav id="' . $menu . '-menu" class="' . $menuclass . '">';
	wp_nav_menu( array(
		'theme_location' => $menu . '_menu',
		'container' => 'none',
		'fallback_cb' => 'bolts_' . $menu . '_menu_fallback'
	) );
	echo '<div class="clear"></div>';
	echo '</nav>';
	
	call_user_func( 'bolts_after_' . $menu . '_menu' );
	
}

/**
 * Primary nav default
 *
 * @since 1.0b2
 */
function bolts_primary_menu_fallback( $menu ) {
	
	wp_page_menu( array(
		'show_home' => false
	) );
	
}

/**
 * Secondary nav default
 *
 * @since 1.0b2
 */
function bolts_secondary_menu_fallback( $menu ) {
	
	echo '<ul>';
	wp_list_categories( array(
		'title_li' => ''
	) );
	echo '</ul>';
	
}

/**
 * Footer nav default
 *
 * @since 1.0b2
 */
function bolts_footer_menu_fallback( $menu ) {
	
	echo '<ul>';
	wp_list_pages( array(
		'depth' => 1,
		'title_li' => ''
	) );
	echo '</ul>';
	
}

/**
 * 404 helpful links default
 *
 * @since 1.0b2
 */
function bolts_404_menu_fallback( $menu ) {
	
	wp_page_menu( array(
		'depth' => 1,
		'title_li' => '',
		'show_home' => 1
	) );
	
}

/**
 * Section links (table of contents)
 *
 * @since 1.0b1
 */
if ( ! function_exists( 'bolts_table_of_contents' ) ) :
	function bolts_table_of_contents( $args ) {
		
		$defaults = array(
			'content'        => '',
			'heading_levels' => '2-6',
			'list_type'      => 'ul'
		);
		
		extract( wp_parse_args( $args, $defaults ) );
	
		preg_match_all( "/(<h([$heading_levels]{1})[^<>]*>)(.+)(<\/h[$heading_levels]{1}>)/", $content, $matches, PREG_SET_ORDER );
		
		if ( isset( $matches[0] ) ) :
		
			$first_heading_level = $matches[0][2];
			
			$old_section_headings = array();
			$new_section_headings = array();
			$item_ids = array();
			$repeat_headings = array();
			$item = 0;
			$last_heading_level = '';
			
			if ( $list_type == 'mixed' ) {
				$list_type = 'ol';
				$sub_list_type = 'ul';
			}
			else {
				$sub_list_type = $list_type;
			}
			
			$output = '<div class="bolts-toc">';
			
			if ( isset( $title ) )
				$output .= '<h1>' . $title . '</h1>';
			
			$output .= '<' . $list_type . '>';
			
			foreach ( $matches as $val ) :
				
				//echo '<pre>' . htmlentities( print_r( $val, true ) ) . '</pre>';
				
				$entire_heading = $val[0];         // <h2>Title Here</h2>
				$heading_open = $val[1];           // <h2>
				$current_heading_level = $val[2];  // 2
				$heading_content = $val[3];        // Title Here
				$heading_close = $val[4];          // </h2>
				
				$item_id = sanitize_title( strip_tags( $heading_content ) );
				
				if ( in_array( $item_id, $item_ids ) ) {
					$item_id .= '-2';
					
					$j = 3;
					
					while ( in_array( $item_id, $item_ids ) ) {
						$item_id = substr( $item_id, 0, -2 ) . '-' . $j;
						$j++;
					}
				
				}
				
				$item_ids[] = $item_id;
				
				$old_section_headings[$item] = $entire_heading;
				$new_section_headings[$item] = '<h' . $current_heading_level . ' id="' . $item_id . '">' . $heading_content . $heading_close;
				
				$item++;
				
				// First item: open a new <li>
				if ( ! $last_heading_level ) {
					$output .= '<li><a href="#' . $item_id . '">' . $heading_content . '</a>';
				}
				
				// Same level as the last item: close the last <li> and open a new one
				elseif ( $current_heading_level == $last_heading_level ) {
					$output .= '</li><li><a href="#' . $item_id . '">' . $heading_content . '</a>';
				}
				
				// Deeper level than the last item: open a new <ul> in the last <li>
				elseif ( $current_heading_level > $last_heading_level ) {
					for ( $i = 0; $i < $current_heading_level - $last_heading_level; $i++ )
						$output .= '<' . $sub_list_type . '><li>';
					
					$output .= '<a href="#' . $item_id . '">' . $heading_content . '</a>';
				}
				
				// More shallow level than the last item: close all <li><ol><li> and open a new <li>
				elseif ( $current_heading_level < $last_heading_level ) {
					for ( $i = 0; $i < $last_heading_level - $current_heading_level; $i++ )
						$output .= '</li></' . $sub_list_type . '>';
					
					$output .= '</li><li><a href="#' . $item_id . '">' . $heading_content . '</a>';
				}
				
				$last_heading_level = $current_heading_level;
			
			endforeach;
			
			if ( $last_heading_level > $first_heading_level ) {
				for ( $i = 0; $i < $last_heading_level - $first_heading_level; $i++ )
					$output .= '</li></' . $sub_list_type . '>';
			}
			
			$output .= '</li></' . $list_type . '></div>';
			
			$new_content = $content;
			
			for ( $i = 0; $i < count( $old_section_headings ); $i++ ) {
				$new_content = preg_replace( '/' . preg_quote( $old_section_headings[$i], '/' ) . '/', $new_section_headings[$i], $new_content, 1 );
			}
			
			return array(
				'list'    => $output,
				'content' => $new_content
			);
		
		else : // isset $matches[0]
			
			return array(
				'list' => '',
				'content' => $content
			);
			
		endif;
		
	}
endif;

/**
 * List popular posts
 *
 * @since 1.0
 */
if ( ! function_exists( 'bolts_popular_posts' ) ) :
	function bolts_popular_posts( $args = array() ) {
		$post_list = '';
		
		global $wpdb;
		
		$defaults = array(
			'number_posts' => 5,
			'display'      => 'thumbnail',
			'show_count'   => false,
			'post_type'    => 'post'
		);
		
		extract( wp_parse_args( $args, $defaults ) );
		
		$thumbnail_size = array( 100, 100 );
		$thumbnail_args = array( 'title' => '' );
		
		if ( $display == 'text' )
			$post_list .= '<ul>';
		
		// If Mint analytics is installed, use number of visits for popularity
		if ( bolts_option( 'mint_analytics' ) != ''
			&& file_exists( ABSPATH . basename( bolts_option( 'mint_analytics' ) ) ) ) :
		
			$result = $wpdb->get_results( "SELECT resource, resource_title, COUNT(resource) AS c FROM mint_visit GROUP BY resource ORDER BY c DESC LIMIT $number_posts" );
			
			foreach ( $result as $record ) :
			
				if ( $record->c > 0 ) {
					
					if ( $display == 'thumbnail' ) {
						
						$post_ID = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $record->resource_title . "' AND guid = '" . $record->resource . "'" );
						
						$post_list .= '<a href="' . $record->resource . '" title="' . $record->resource_title . '">' . get_the_post_thumbnail( $post_ID, $thumbnail_size, $thumbnail_args ) . '</a>';
					}
					
					else {
						$post_list .= '<li><a href="' . $record->resource . '" title="' . sprintf( __( 'Permanent link to %s', BOLTS_TEXT_DOMAIN ), $record->resource_title ) . '">' . $record->resource_title . '</a>';
						
						if ( $show_count )
							$post_list .= ' <small>(' . $record->c . ')</small>';
						
						$post_list .= '</li>';
					}
					
				}
			
			endforeach;
		
		// If Mint analytics is not installed, use entry views meta for popularity
		elseif ( function_exists( 'entry_views_get' ) ) :
			
			$loop = new WP_Query( array( 'post_type' => $post_type, 'posts_per_page' => $number_posts, 'meta_key' => 'Views', 'orderby' => 'meta_value_num', 'order' => 'DESC' ) );
			
			while ( $loop->have_posts() ) : $loop->the_post();
			
				if ( entry_views_get() > 0 ) {
					
					global $post;
					
					if ( $display == 'thumbnail' ) {
						$post_list .= '<a href="' . get_permalink( $post->ID ) . '" title="' . bolts_clean( get_the_title() ) . '">' . get_the_post_thumbnail( $post->ID, $thumbnail_size, $thumbnail_args ) . '</a>';
					}
					
					else {
						$post_list .= '<li><a href="' . get_permalink( $post->ID ) . '" title="' . sprintf( __( 'Permanent link to %s', BOLTS_TEXT_DOMAIN ), bolts_clean( get_the_title() ) ) . '">' . get_the_title() . '</a>';
						
						if ( $show_count )
							$post_list .= ' <small>(' . entry_views_get() . ')</small>';
						
						$post_list .= '</li>';
					}
					
				}
			
			endwhile;
		
		// If entry views meta does not exist, use comment count for popularity
		else :
		
			$result = $wpdb->get_results( "SELECT comment_count, ID, post_title FROM $wpdb->posts WHERE post_type = 'article' ORDER BY comment_count DESC LIMIT $number_posts" );
			
			foreach ( $result as $post ) :
			
				setup_postdata( $post );
				
				if ( $post->comment_count > 0 ) {
					
					if ( $display == 'thumbnail' ) {
						$post_list .= '<a href="' . get_permalink( $post->ID ) . '" title="' . bolts_clean( get_the_title() ) . '">' . get_the_post_thumbnail( $post->ID, $thumbnail_size, $thumbnail_args ) . '</a>';
					}
					
					else {
						$post_list .= '<li><a href="' . get_permalink( $post->ID ) . '" title="' . sprintf( __( 'Permanent link to %s', BOLTS_TEXT_DOMAIN ), $post->post_title ) . '">' . $post->post_title . '</a>';
						
						if ( $show_count )
							$post_list .= ' <small>(' . $post->comment_count . ')</small>';
						
						$post_list .= '</li>';
					}
					
				}
				
			endforeach;
		
		endif;
		
		if ( $display == 'text' )
			$post_list .= '</ul>';
		
		return $post_list;
		
	}
endif;

/**
 * Comments link for multiple posts display
 * 
 * @since 1.0b1
 */
function bolts_comments_link() {
	
	
	
}

/**
 * Arguments for wp_list_comments()
 *
 * @since 1.0b1
 */
if ( ! function_exists( 'bolts_list_comments_args' ) ) :
	function bolts_list_comments_args( $type = 'all' ) {
		
		return array(
			'style'        => 'ol',
			'callback'     => 'bolts_comment',
			'type'         => $type,
			'avatar_size'  => 48
		);
		
	}
endif;

/**
 * Custom comment callback
 *
 * @since 1.0b1
 */
if ( ! function_exists( 'bolts_comment' ) ) :
	function bolts_comment( $comment, $args, $depth ) {
		
		$GLOBALS['comment'] = $comment;
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>">
				<?php echo get_avatar( $comment, $size='48' ); ?>
				<div class="comment-content">
					<div class="comment-meta">
						<cite class="fn"><?php comment_author_link(); ?></cite>
						<?php echo bolts_date( get_comment_date() . ' ' . get_comment_time(), 'comment' ); ?>
						<a class="comment-permalink" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php _e( 'Link', BOLTS_TEXT_DOMAIN ); ?></a>
						<div class="comment-moderation">
							<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
							<?php if ( current_user_can( 'moderate_comments' ) ) : ?>
								<?php edit_comment_link( __( 'Edit', BOLTS_TEXT_DOMAIN ), ' / ', ' / ' ); ?>
								<a href="<?php echo admin_url( 'comment.php?action=cdc&dt=spam&c=' . get_comment_ID() ); ?>"><?php _e( 'Spam', BOLTS_TEXT_DOMAIN ); ?></a> / 
								<a href="<?php echo admin_url( 'comment.php?action=cdc&c=' . get_comment_ID() ); ?>"><?php _e( 'Trash', BOLTS_TEXT_DOMAIN ); ?></a>
							<?php endif; ?>
						</div>
					</div>
					<?php if ( $comment->comment_approved == '0' ) : ?>
					<p class="moderation"><?php _e( 'Your comment is awaiting moderation.', BOLTS_TEXT_DOMAIN ); ?></p>
					<?php endif; ?>
					
					<?php comment_text(); ?>
				</div>
			</div>
		<?php
	}
endif;
?>