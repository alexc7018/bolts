<?php
/**
 * Bolts Theme for WordPress
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

/**
 * Bolts
 * 
 * Master theme class
 * 
 * This file is what powers the entire theme. It sets theme constants;
 * initializes theme options; adds theme support for thumbnails, menus,
 * and post formats; initializes shortcodes; enables the custom background;
 * sets up admin area additions & modifications; handles SEO and meta tags;
 * tweaks the comment form; and a lot of other stuff.
 * 
 * This file is required by functions.php, where the $bolts global variable
 * is created as an instance of this class.
 * 
 * @package    Bolts
 * @author     Alison Barrett <alison@themejack.net>
 * @copyright  Copyright (c) 2011, Themejack
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 * @since      1.0
 * @modified   1.0
 */
class Bolts {
	
	/**
	 * Construct
	 * 
	 * Create a Bolts object and start the party.
	 * 
	 * @param     void
	 * @return    void
	 * 
	 * @uses      THEME_URI
	 * @uses      THEME_DIR
	 * @uses      BOLTS_DIR
	 * @uses      BOLTS_URI
	 * @uses      BOLTS_CLASSES
	 * @uses      Bolts_Theme_Options
	 * @uses      Bolts_Shortcodes
	 * @uses      Bolts::wp_hooks()
	 * 
	 * @access    public
	 * @since     1.0
	 * @modified  1.1.1
	 */
	public function __construct() {
		
		define( 'BOLTS_VERSION',        '1.2' );
		if ( ! defined( 'THEME_VERSION' ) )
			define( 'THEME_VERSION',    BOLTS_VERSION );
		
		if ( ! defined( 'THEME_NAME' ) )
			define( 'THEME_NAME',       'Bolts' );
		
		define( 'THEME_URI',            get_template_directory_uri() );
		define( 'THEME_DIR',            get_template_directory() );
		
		define( 'CHILD_THEME_URI',      get_stylesheet_directory_uri() );
		define( 'CHILD_THEME_DIR',      get_stylesheet_directory() );
		
		define( 'BOLTS_URI',            trailingslashit( THEME_URI ) . basename( dirname( __FILE__ ) ) );
		define( 'BOLTS_DIR',            trailingslashit( THEME_DIR ) . basename( dirname( __FILE__ ) ) );
		
		define( 'BOLTS_CLASSES',        BOLTS_DIR . '/classes' );
		define( 'BOLTS_FUNCTIONS',      BOLTS_DIR . '/functions' );
		define( 'BOLTS_EXTENSIONS',     BOLTS_DIR . '/extensions' );
		define( 'BOLTS_EXTENSIONS_URI', BOLTS_URI . '/extensions' );
		define( 'BOLTS_STYLES',         BOLTS_URI . '/styles' );
		define( 'BOLTS_SCRIPTS',        BOLTS_URI . '/scripts' );
		
		define( 'BOLTS_TEXT_DOMAIN',    'Bolts' );
				
		// Require class files
		require_once( BOLTS_CLASSES . '/class.bolts-widgets.php' );
		require_once( BOLTS_CLASSES . '/class.bolts-shortcodes.php' );
		require_once( BOLTS_CLASSES . '/class.bolts-theme-options.php' );
		
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_theme_support( 'editor-style' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );
		
		$theme_options = new Bolts_Theme_Options();
		$shortcodes = new Bolts_Shortcodes();
		
		$this->wp_hooks();
	}

	/**
	 * Admin notices
	 *
	 * Ability to remotely add notices to the admin screen. This is to alert users
	 * to downloadable updates, etc. since the theme doesn't live in the WP repository.
	 *
	 * @param     void
	 * @return    void
	 *
	 * @access    public
	 * @since     1.2
	 * @modified  1.2
	 */
	public function admin_notices() {

		$message_file = wp_remote_get( 'http://themejack.net/update-messages.txt' );
		$messages = explode( "\n", $message_file['body'] );

		$current_child = get_option( 'stylesheet' );
		$current_parent = get_option( 'template' );

		foreach ( $messages as $message ) {
			$m = explode( '|', $message );
			if ( $m[0] == 'bolts' && $current_parent == 'bolts' ) {
				if ( $m[1] != BOLTS_VERSION ) {
					echo '<div class="updated"><p>There is a new version of Bolts available.';
					if ( $m[2] != '' ) {
						echo ' ' . $m[2];
					}
					echo ' <a class="button" href="https://github.com/aliso/bolts/zipball/master">Download Bolts ' . $m[1] . '</a></p></div>';
				}
			}
			elseif ( $current_parent == $m[0] || $current_child == $m[0] ) {
				if ( $m[1] != THEME_VERSION ) {
					echo '<div class="updated fade"><p>There is a new version of ' . ucwords( $m[0] ) . ' available. ' .  $m[2];
					echo ' <a class="button" href="http://themejack.net/my-account/">Download ' . ucwords( $m[0] ) . ' ' . $m[1] . '</a></p></div>';
				}
			}
		}

	}

	/**
	 * Admin style
	 * 
	 * Puts the admin stylesheet in <head> when on the 'bolts-options' page.
	 * This keeps the theme options page looking all nice and pretty.
	 * 
	 * @param     void
	 * @return    void
	 * 
	 * @uses      BOLTS_STYLES
	 * 
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 */
	public function admin_style() {
		
		if ( isset( $_GET['page'] ) && $_GET['page'] == 'bolts-options' )
			echo '<link rel="stylesheet" href="' . BOLTS_STYLES . '/admin-options.css" />' . "\n";
		
	}
	
	/**
	 * Admin footer text
	 * 
	 * This replaces the default footer text in the admin with custom links
	 * to the Themejack home page, support forums, and documentation.
	 * 
	 * @param     void
	 * @return    void
	 * 
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 */
	public function admin_footer_text() {
		return 'Powered by <a href="http://themejack.net/">Themejack</a> and <a href="http://wordpress.org/">WordPress</a>.';
	}
	
	/**
	 * Comment count
	 * 
	 * Filters out the pingbacks/trackbacks and counts only real comments for a
	 * more accurate comment count in the front-end.
	 * 
	 * @param     int    $count    Default comment count
	 * @return    int              Improved comment count (or default if in the admin area)
	 * 
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 */
	public function comment_count( $count ) {
		if ( ! is_admin() ) {
			global $id;
			$comments_by_type = separate_comments( get_comments( 'status=approve&post_id=' . $id ) );
			return count( $comments_by_type['comment'] );
		}
		else {
			if ( isset( $count ) )
				return $count;
			else
				return 0;
		}
	}
	
	/**
	 * Comment fields
	 * 
	 * Bolts form labels are set to display as block elements. This
	 * makes it necessary to move the asterisks for required fields
	 * into the <label> tag, so they don't display on the following
	 * line to the left of the form field.
	 * 
	 * @param     array    $fields    Default array of comment form fields HTML
	 * @return    array               Customized array of comment form fields HTML
	 * 
	 * @uses      BOLTS_TEXT_DOMAIN
	 * 
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 */
	public function comment_fields( $fields ) {
		
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		
		$fields['author'] = '<p class="comment-form-author">
			<label for="author">' . __( 'Name', BOLTS_TEXT_DOMAIN ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label>
			<input id="author" name="author" type="text" value="' . ( isset( $commenter['comment_author'] ) ? esc_attr( $commenter['comment_author'] ) : '' ) . '" size="30" ' . $aria_req . ' />
		</p>';
		
		$fields['email'] = '<p class="comment-form-email">
			<label for="email">' . __( 'Email', BOLTS_TEXT_DOMAIN ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label>
			<input id="email" name="email" type="email" value="' . ( isset( $commenter['comment_author_email'] ) ? esc_attr( $commenter['comment_author_email'] ) : '' ) . '" size="30" ' . $aria_req . ' />
		</p>';
		
		return $fields;
		
	}
	
	/**
	 * Content validation
	 * 
	 * Some things in WordPress (particularly the embed media functionality
	 * in the post content editor) output invalid code. This does a few simple
	 * search-and-replace operations to fix that code so the page can validate.
	 * 
	 * @param     string    $content    Post content
	 * @return    string                Modified post content
	 *
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 */
	public function content_validation( $content ) {
		
		$content = str_replace( array( '<b>', '</b>' ), array( '<strong>', '</strong>' ), $content );
		
		$content = str_replace( '></param>', ' />', $content );
		$content = str_replace( '></embed>', ' />', $content );
		$content = str_replace( '<object', '<object type="video/flv"', $content );
		
		return $content;
		
	}
	
	/**
	 * Custom style
	 * 
	 * If a user has inserted custom CSS in the theme options, output
	 * that CSS in the <head>.
	 * 
	 * @param     void
	 * @return    void
	 * 
	 * @uses      bolts_option()
	 * 
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 */
	public function custom_style() {
		
		if ( bolts_option( 'custom_style' ) != '' ) {
			
			echo '
<style>
' . bolts_option( 'custom_style' ) . '
</style>' . "\n";
			
		}
		
	}
	
	/**
	 * Display helper tags
	 * 
	 * This displays the table of 'helper tags' for the Social Media
	 * & SEO tabs of the theme options page. (Helper tags: %%date%%,
	 * %%site_title%%, etc.)
	 * 
	 * @param     void
	 * @return    string    HTML to display table of helper tags & definitions
	 * 
	 * @uses      Bolts::get_helper_tags()
	 * 
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 */
	public function display_helper_tags() {
		
		$help = '<table class="sw-help">
			<thead>
				<tr>
				<td colspan="2"><p>' . __( 'You can use the following tags in the options above:', BOLTS_TEXT_DOMAIN ) . '</p></td>
				</tr>
			</thead>
			<tbody>';
		
		$tmp = $this->get_helper_tags();
		ksort( $tmp );
		
		$i = 0;
		
		foreach ( $tmp as $tag => $info ) {
			$i++;
			$rowclass = '';
			if ( $i % 2 == 0 )
				$rowclass = ' class="alt"';
			
			$help .= '<tr' . $rowclass . '>
				<th>' . $tag . '</th>
				<td>' . $info['desc'] . '</td>
			</tr>';
		}
		
		$help .= '</tbody>
		</table>';
		
		return $help;
		
	}
	
	/**
	 * TinyMCE stylesheet
	 * 
	 * Style the content in the TinyMCE editor to match the theme.
	 * 
	 * @param     void
	 * @return    void
	 * 
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 */
	public function editor_style() {
		
		add_editor_style( 'library/styles/editor.css' );
		
	}
	
	/**
	 * Extensions
	 * 
	 * The Entry Views extension powers the Popular Posts widget if
	 * Mint analytics are not installed. The Cleaner Gallery extension
	 * replaced the default WordPress [gallery] output with valid code.
	 * 
	 * @param     void
	 * @return    void
	 * 
	 * @uses      BOLTS_TEXT_DOMAIN
	 * 
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 */
	public function extensions() {
		
		// Entry Views - by Justin Tadlock
		require_once( BOLTS_EXTENSIONS . '/entry-views.php' );
		add_post_type_support( 'post', array( 'entry-views' ) );
		
		// Cleaner Gallery - by Justin Tadlock
		require_once( BOLTS_EXTENSIONS . '/cleaner-gallery/cleaner-gallery.php' );
		
	}
			
	/**
	 * Facebook meta
	 * 
	 * This outputs Open Graph tags in the <head> to customize what
	 * is displayed when a user shares the page on Facebook.
	 * 
	 * @param     void
	 * @return    void
	 * 
	 * @uses      BOLTS_TEXT_DOMAIN
	 * @uses      bolts_option()
	 * @uses      bolts_clean()
	 * 
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 */
	public function facebook_meta() {
		
		if ( strpos( $_SERVER["HTTP_USER_AGENT"], 'facebook' ) === false )
			return;
		
		global $post, $wp_query;
		if ( empty( $post ) && is_singular() )
			$post = get_post( $postid );
		
		if ( ! empty( $post ) ) :
			
			setup_postdata( $post );
			
			// Title
			if ( is_single() || is_page() )
				$title = bolts_option( 'facebook_meta_title_posts' );
			else
				$title = bolts_option( 'facebook_meta_title_other' );
			
			foreach ( $this->get_helper_tags() as $tag => $info ) {
				if ( $tag == '%%archive_date%%' ) {
					if ( is_year() )
						$title = str_ireplace( $tag, get_the_date( 'Y' ), $title );
					elseif ( is_month() )
						$title = str_ireplace( $tag, get_the_date( 'F, Y' ), $title );
					elseif ( is_day() )
						$title = str_ireplace( $tag, get_the_date(), $title );
				}
				else {
					$title = str_ireplace( $tag, $info['value'], $title );
				}
			}
			
			// Description
			if ( is_single() || is_page() )
				$description = bolts_option( 'facebook_meta_description_posts' );
			else
				$description = bolts_option( 'facebook_meta_description_other' );
			
			foreach ( $this->get_helper_tags() as $tag => $info ) {
				if ( $tag == '%%archive_date%%' ) {
					if ( is_year() )
						$description = str_ireplace( $tag, get_the_date( 'Y' ), $description );
					elseif ( is_month() )
						$description = str_ireplace( $tag, get_the_date( 'F, Y' ), $description );
					elseif ( is_day() )
						$description = str_ireplace( $tag, get_the_date(), $description );
				}
				else {
					$description = str_ireplace( $tag, $info['value'], $description );
				}
			}
			
			// Thumbnail
			if ( is_single() || is_page() )
				$thumbnail = bolts_option( 'facebook_meta_image_posts' );
			else
				$thumbnail = bolts_option( 'facebook_meta_image_other' );
			
			if ( strpos( $thumbnail, '%%post_thumbnail%%' ) !== false )
				$thumbnail = $this->get_post_thumbnail_url( $post->ID );
			
			// Echo the good stuff
			echo "<!-- " . __( 'Facebook meta tags', BOLTS_TEXT_DOMAIN ) . " -->\n" . '<meta property="og:title" content="' . bolts_clean( $title ) . '" />
	<meta property="og:description" content="' . bolts_clean( $description ) . '" />
	<meta property="og:image" content="' . $thumbnail . '" />
	<link rel="image_src" href="' . $thumbnail . '" />' . "\n<!-- " . __( 'End Facebook meta tags', BOLTS_TEXT_DOMAIN ) . " -->\n";
		
		endif;
		
	}
	
	/**
	 * Floating Share Bar on single posts
	 * 
	 * Displays a sweet floating toolbar next to single posts
	 * with a variety of social media action buttons.
	 * 
	 * @param     void
	 * @return    void
	 * 
	 * @access    public
	 * @since     1.1
	 * @modified  1.1
	 */
	public function floating_sharebar() {
		
		if ( bolts_option( 'floating_sharebar' ) && is_single() )
			get_template_part( 'sharebar' );
		
	}
	
	/**
	 * Footer credit link
	 * 
	 * Display the opt-in footer credit links to Themejack and WordPress.
	 * 
	 * @param     void
	 * @return    void
	 * 
	 * @uses      THEME_NAME
	 * @uses      BOLTS_TEXT_DOMAIN
	 * 
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 */
	public function footer_credit_link() {
		
		if ( bolts_option( 'footer_credit_link' ) )
			echo '<p class="bolts-credit-link">' . sprintf( __( '%s theme by %sThemejack%s. Powered by %sWordPress%s.', BOLTS_TEXT_DOMAIN ), THEME_NAME, '<a href="http://themejack.net/" target="_blank" title="' . __( 'Visit Themejack', BOLTS_TEXT_DOMAIN ) . '">', '</a>', '<a href="http://wordpress.org/" target="_blank" title="' . __( 'Visit WordPress.org', BOLTS_TEXT_DOMAIN ) . '">', '</a>' ) . '</p>';
		
	}
	
	/**
	 * Get helper tags
	 * 
	 * Set the values of each of the SEO/Social Media helper tags
	 * (%%site_title%%, etc).
	 * 
	 * @param     void
	 * @return    array    Helper tags with descriptions and values
	 * 
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 */
	public function get_helper_tags() {
		global $post, $wp_query;
	
		return array(
			'%%site_title%%' => array(
				'desc' => __( 'Website title (set in Settings &rsaquo; General)', BOLTS_TEXT_DOMAIN ),
				'value' => get_bloginfo('name')
			),
			'%%site_description%%' => array(
				'desc' => __( 'Website tagline (set in Settings &rsaquo; General)', BOLTS_TEXT_DOMAIN ),
				'value' => get_bloginfo('description')
			),
			'%%post_title%%' => array(
				'desc' => __( 'Title of post/page', BOLTS_TEXT_DOMAIN ),
				'value' => is_object( $post ) ? $post->post_title : ''
			),
			'%%post_excerpt%%' => array(
				'desc' => __( 'Post excerpt', BOLTS_TEXT_DOMAIN ),
				'value' => ( ! is_object( $post ) || get_the_excerpt() == '' ) ? get_bloginfo('description') : get_the_excerpt()
			),
			'%%category%%' => array(
				'desc' => __( 'Category name', BOLTS_TEXT_DOMAIN ),
				'value' => is_object( $post ) ? single_cat_title( '', false ) : ''
			),
			'%%tag%%' => array(
				'desc' => __( 'Tag name', BOLTS_TEXT_DOMAIN ),
				'value' => is_object( $post ) ? single_tag_title( '', false ) : ''
			),
			'%%search%%' => array(
				'desc' => __( 'Current search term', BOLTS_TEXT_DOMAIN ),
				'value' => get_search_query()
			),
			'%%date%%' => array(
				'desc' => __( 'Date of the post/page', BOLTS_TEXT_DOMAIN ),
				'value' => is_object( $post ) ? get_the_date() : date( get_option( 'date_format' ) )
			),
			'%%archive_date%%' => array(
				'desc' => __( 'Day/Month/Year of the displayed archive', BOLTS_TEXT_DOMAIN ),
				'value' => is_object( $post ) ? get_the_date() : date( get_option( 'date_format' ) )
			),
			'%%num%%' => array(
				'desc' => __( 'Current page number', BOLTS_TEXT_DOMAIN ),
				'value' => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1
			),
			'%%total%%' => array(
				'desc' => __( 'Current page total', BOLTS_TEXT_DOMAIN ),
				'value' => is_object( $wp_query ) ? $wp_query->max_num_pages : ''
			),
			'%%author%%' => array(
				'desc' => __( 'Author (nickname) of the post/page', BOLTS_TEXT_DOMAIN ),
				'value' => is_object( $post ) ? get_the_author() : ''
			)
		);
	
	}
	
	/**
	 * Get post thumbnail URL
	 * 
	 * Gets the URI of post thumbnail for use in PHP.
	 * 
	 * @param     int      $post_id    ID of post
	 * @param     string   $size       Size of image to return
	 * @return    string               URI of post thumbnail
	 * 
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 */
	public function get_post_thumbnail_url( $post_id, $size = 'thumbnail' ) {
		$image_id = get_post_thumbnail_id( $post_id );  
		$image_url = wp_get_attachment_image_src( $image_id, $size );  
		return $image_url[0];
	}
	
	/**
	 * Google Analytics
	 * 
	 * If the user has defined a Google Analytics UA code in the
	 * theme options, display the appropriate Javascript code in
	 * the footer of the site.
	 * 
	 * @param     void
	 * @return    void
	 * 
	 * @uses      bolts_option()
	 * 
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 */
	public function google_analytics() {
		
		$ga = bolts_option( 'google_analytics' );
		
		if ( $ga != 'UA-XXXXX-X' && $ga != '' ) {
			
			echo '<script type="text/javascript">
			
			  var _gaq = _gaq || [];
			  _gaq.push(["_setAccount", "' . $ga . '"]);
			  _gaq.push(["_trackPageview"]);
			
			  (function() {
			    var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
			    ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
			    var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
			  })();
			
			</script>';
			
		}
		
	}
	
	/**
	 * Login style
	 * 
	 * Apply a custom login stylesheet on the login page (wp-login.php).
	 * 
	 * @param     void
	 * @return    void
	 * 
	 * @uses      BOLTS_STYLES
	 * 
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 */
	public function login_style() {
		
		echo '<link rel="stylesheet" href="' . BOLTS_STYLES . '/login.css" />' . "\n";
		
	}
	
	/**
	 * MCE Buttons
	 * 
	 * Show the "styles" drop-down on the TinyMCE toolbar.
	 * 
	 * @param     array    $settings  Buttons to show on TinyMCE toolbar
	 * @return    array               Adjusted buttons to show on TinyMCE toolbar
	 * 
	 * @uses      BOLTS_STYLES
	 * 
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 */
	public function mce_before_init( $settings ) {
	    $style_formats = array(
	    	array(
	    		'title' => 'Download Link',
	    		'selector' => 'a',
	    		'classes' => 'bolts-download-link'
	    	),
	    	array(
	    		'title' => 'Button',
	    		'selector' => 'a',
	    		'classes' => 'bolts-button'
	    	),
	    	array(
	    		'title' => 'Primary Button',
	    		'selector' => 'a',
	    		'classes' => 'bolts-button primary'
	    	),
	    	array(
	    		'title' => 'Cancel Button',
	    		'selector' => 'a',
	    		'classes' => 'bolts-button cancel'
	    	),
	    	array(
	    		'title' => 'Disabled Button',
	    		'selector' => 'a',
	    		'classes' => 'bolts-button disabled'
	    	),
	        array(
	        	'title' => 'Note Box',
	        	'block' => 'div',
	        	'classes' => 'bolts-callout note',
	        	'wrapper' => true
	        ),
	        array(
	        	'title' => 'Info Box',
	        	'block' => 'div',
	        	'classes' => 'bolts-callout info',
	        	'wrapper' => true
	        ),
	        array(
	        	'title' => 'Success Box',
	        	'block' => 'div',
	        	'classes' => 'bolts-callout success',
	        	'wrapper' => true
	        ),
	        array(
	        	'title' => 'Alert Box',
	        	'block' => 'div',
	        	'classes' => 'bolts-callout alert',
	        	'wrapper' => true
	        ),
	        array(
	        	'title' => 'Warning Box',
	        	'block' => 'div',
	        	'classes' => 'bolts-callout warning',
	        	'wrapper' => true
	        )
	    );
	    $settings['style_formats'] = json_encode( $style_formats );
	
	    return $settings;
	}
	
	/**
	 * MCE Buttons
	 * 
	 * Show the "styles" drop-down on the TinyMCE toolbar.
	 * 
	 * @param     array    $buttons  Buttons to show on TinyMCE toolbar
	 * @return    array              Adjusted buttons to show on TinyMCE toolbar
	 * 
	 * @uses      BOLTS_STYLES
	 * 
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 */
	public function mce_buttons_2( $buttons ) {
	    array_unshift( $buttons, 'styleselect' );
	    return $buttons;
	}
	
	/**
	 * Meta box display
	 * 
	 * Display a custom meta box on the edit post screen.
	 * 
	 * @param     object   $post    Post object
	 * @param     array    $args    Arguments for the meta box
	 * @return    void
	 * 
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 * 
	 * @todo      Remove? Where am I using this?
	 */
	public function meta_box_display( $post, $args ) {
	
		global $post;
		
		$meta_box_varname = $post->post_type . '_meta_box';
		
		$meta_box = $args['callback'][0]->$meta_box_varname;
		
		echo '<input type="hidden" name="bolts_meta_box_nonce" value="', wp_create_nonce( basename( __FILE__ ) ), '" />';
	    echo '<table class="form-table">';
	
	    foreach ( $meta_box['fields'] as $field ) {
			// get current post meta data
				
			$desc = '';
			$std = '';
			if ( isset( $field['desc'] ) )
				$desc = $field['desc'];
			if ( isset( $field['std'] ) )
				$std = $field['std'];
			
			$meta = get_post_meta( $post->ID, $field['id'], true );
			if ( isset( $meta ) )
				$value = $meta;
			else
				$value = $std;
			
			echo '
			<tr>
				<th scope="row"><label for="' . $field['id'] . '">' . $field['name'] . '</label></th>
				<td>';
			
			switch ( $field['type'] ) {
			
				case 'text':
					
					echo '
					<input type="text" class="widefat" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . esc_attr( $value ) . '" /><br />
					<small>' . $field['desc'] . '</small>';
					
					break;
				
				case 'textarea':
				
					echo '
					<textarea name="' . $field['id'] . '" id="' . $field['id'] . '" rows="10" cols="56">' . wp_htmledit_pre( $value ) . '</textarea><br />
					<small>' . $field['desc'] . '</small>';
					
					break;
				
				case 'select':
				
					echo '
					<select name="' . $field['id'] . '" id="' . $field['id'] . '">';
					
					foreach ( $field['options'] as $option_value => $option ) {
						echo '
						<option value="' . esc_attr( $option_value ) . '"' . selected( $value, $option_value, false ) . '>' . $option . '</option>';
					}
					
					echo '
					</select><br />
					<small>' . $field['desc'] . '</small>';
					
					break;
				
				case 'radio':
				
					foreach ( $field['options'] as $option_value => $option ) {
						echo '
						<input type="radio" name="' . $field['id'] . '" value="' . esc_attr( $option_value ) . '"' . checked( $value, $option_value, false ) . ' />' . $option;
					}
					
					echo '
					<br /><small>'.$field['desc'].'</small>';
					
					break;
				
				case 'checkbox':
				
					echo '
					<input type="checkbox" name="' . $field['id'] . '" id="' . $field['id'] . '" value="1"' . checked( $value, 1, false ) . ' /> <label for="' . $field['id'] . '">' . $field['label'] . '</label><br />
					<small>' . $field['desc'] . '</small>';
					
					break;
			}
			echo '
				</td>
			</tr>';
		}
			
		echo '</table>';

	}
	
	/**
	 * Meta box save
	 * 
	 * Save the values from the custom meta box.
	 * 
	 * @param     int      $post_id    Post ID
	 * @return    int                  Post ID
	 * 
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 * 
	 * @todo      Remove? Where am I using this?
	 */
	public function meta_box_save( $post_id ) {
	
		$meta_box_name = $_POST['post_type'] . '_meta_box';
		$meta_box = $this->$meta_box_name;
	    
	    // verify nonce
	    if ( ! wp_verify_nonce( $_POST['bolts_meta_box_nonce'], basename( __FILE__ ) ) ) {
	        return $post_id;
	    }
	
	    // check autosave
	    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
	        return $post_id;
	    }
	
	    // check permissions
	    if ( 'page' == $_POST['post_type'] ) {
	        if ( ! current_user_can( 'edit_page', $post_id ) )
	            return $post_id;
	    }
	    elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
	        return $post_id;
	    }
	    
	    foreach ( $meta_box['fields'] as $field ) {
	    
	    	$new = $_POST[ $field['id'] ];
	    	
	        $old = get_post_meta( $post_id, $field['id'], true );
	        
	        if ( isset( $new ) && $new != $old )
	            update_post_meta( $post_id, $field['id'], $new );
	        elseif ( '' == $new && $old )
	            delete_post_meta( $post_id, $field['id'], $old );
	    }

	}
	
	/**
	 * Prep Table of Contents
	 * 
	 * Assign IDs to all heading tags so Table of Contents shortcode can be used.
	 * All heading tags (h1-h6) will be given an id attribute that is a sanitized
	 * version of their text content.
	 * 
	 * @param     string    $content           Post content
	 * @return    string                       Modified post content
	 * 
	 * @uses      bolts_table_of_contents()
	 * 
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 */
	public function prep_toc( $content ) {
		
		$toc = bolts_table_of_contents( array(
			'heading_levels' => '1-6',
			'content' => $content
		) );
		
		return $toc['content'];
		
	}
	
	/**
	 * Register default theme menus
	 * 
	 * @param     void
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 */
	public function register_menus() {
		
		register_nav_menus( array(
			'primary_menu'   => 'Primary Menu',
			'secondary_menu' => 'Secondary Menu',
			'footer_menu'    => 'Footer Menu',
			'404_menu'       => '404 Helpful Links'
		) );
		
	}
	
	/**
	 * Register default theme sidebars
	 * 
	 * @param     void
	 * @access    public
	 * @since     1.0
	 * @modified  1.2
	 */
	public function register_sidebars() {

		do_action( 'bolts_before_sidebars' );

		register_sidebar( array(
			'name'          => __( 'Primary Sidebar' ),
			'id'            => 'primary',
			'description'   => __( '' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h1 class="widgettitle">',
			'after_title'   => '</h1>'
		) );

		register_sidebar( array(
			'name'          => __( 'Secondary Sidebar' ),
			'id'            => 'secondary',
			'description'   => __( '' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h1 class="widgettitle">',
			'after_title'   => '</h1>'
		) );

		register_sidebar( array(
			'name'          => __( 'Footer Left Column' ),
			'id'            => 'footer-left',
			'description'   => __( '' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h1 class="widgettitle">',
			'after_title'   => '</h1>'
		) );

		register_sidebar( array(
			'name'          => __( 'Footer Center Column' ),
			'id'            => 'footer-center',
			'description'   => __( '' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h1 class="widgettitle">',
			'after_title'   => '</h1>'
		) );

		register_sidebar( array(
			'name'          => __( 'Footer Right Column' ),
			'id'            => 'footer-right',
			'description'   => __( '' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h1 class="widgettitle">',
			'after_title'   => '</h1>'
		) );

		do_action( 'bolts_after_sidebars' );
		
	}
	
	/**
	 * Queue up jQuery (and other theme scripts) for the non-admin pages
	 * 
	 * @param     void
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 */
	public function scripts() {
		
		// wp_register_script( ID, URI, dependencies, version, in_footer )
		wp_register_script( 'bolts-html5', 'http://html5shiv.googlecode.com/svn/trunk/html5.js', null, null, false );
		wp_register_script( 'bolts-facebook', 'http://connect.facebook.net/en_US/all.js#xfbml=1', null, null, true );
		wp_register_script( 'bolts-twitter', 'http://platform.twitter.com/widgets.js', null, null, true );
		wp_register_script( 'bolts-digg', 'http://widgets.digg.com/buttons.js', null, null, true );
		wp_register_script( 'bolts-google-plusone', 'https://apis.google.com/js/plusone.js', null, null, true );
		wp_register_script( 'bolts-linkedin', 'http://platform.linkedin.com/in.js', null, null, true );
		wp_register_script( 'bolts-forms', BOLTS_SCRIPTS . '/html5-forms.js', array( 'jquery' ), null, false );
		wp_register_script( 'bolts-cycle', BOLTS_SCRIPTS . '/jquery.cycle.js', array( 'jquery' ), '2.88', true );
		wp_register_script( 'bolts-easing', BOLTS_SCRIPTS . '/jquery.easing.js', array( 'jquery' ), '1.3', true );
		wp_register_script( 'bolts-cookie', BOLTS_SCRIPTS . '/jquery.cookie.js', array( 'jquery' ), '1.0', true );
		
		// FBML5 Javascript extension
		wp_register_script( 'bolts-fbml5', BOLTS_SCRIPTS . '/fbml5.js', array( 'bolts-facebook' ), null, true );
		wp_register_script( 'bolts-fbml5-init', BOLTS_SCRIPTS . '/fbml5.init.js', array( 'bolts-facebook', 'bolts-fbml5' ), null, true );
		
		if ( ! is_admin() ) {
			wp_enqueue_script( 'bolts-html5' );
			
			wp_enqueue_script( 'jquery' );
			
			wp_enqueue_script( 'bolts-cycle' );
			wp_enqueue_script( 'bolts-easing' );
			
			if ( is_single() )
				wp_enqueue_script( 'comment-reply' );
		}
		
	}
	
	/**
	 * Enqueue styles (color scheme and custom.css if it exists)
	 * 
	 * @param     void
	 * @access    public
	 * @since     1.0
	 * @modified  1.1
	 */
	public function styles() {
		
		if ( ! is_admin() ) {

			wp_register_style( 'bolts-reset', BOLTS_STYLES . '/reset.css', null, BOLTS_VERSION );
			wp_register_style( 'bolts-main-styles', BOLTS_STYLES . '/main.css', array( 'bolts-reset' ), BOLTS_VERSION );
			wp_register_style( 'bolts-wordpress-styles', BOLTS_STYLES . '/wordpress.css', array( 'bolts-main-styles' ), BOLTS_VERSION );
			wp_register_style( 'bolts-proprietary-styles', BOLTS_STYLES . '/bolts.css', array( 'bolts-wordpress-styles' ), BOLTS_VERSION );
			wp_enqueue_style( 'bolts-proprietary-styles' );
		
			if ( bolts_option( 'font_styles' ) ) {
				wp_register_style( 'bolts-font-styles', BOLTS_STYLES . '/fonts.css', null, BOLTS_VERSION );
				wp_enqueue_style( 'bolts-font-styles' );
			}
			
			if ( bolts_option( 'color_scheme' ) ) {
				if ( file_exists( CHILD_THEME_DIR . '/color-schemes/' . bolts_option( 'color_scheme' ) . '.css' ) ) {
					wp_register_style( 'bolts-color-scheme', CHILD_THEME_URI . '/color-schemes/' . bolts_option( 'color_scheme' ) . '.css', null, THEME_VERSION );
					wp_enqueue_style( 'bolts-color-scheme' );
				}
			}
			
			if ( bolts_option( 'floating_sharebar' ) ) {
				wp_register_style( 'bolts-sharebar', BOLTS_STYLES . '/sharebar.css', null, BOLTS_VERSION );
				wp_enqueue_style( 'bolts-sharebar' );
			}

            // Load child theme stylesheets after Bolts to override Bolts defaults
            if ( file_exists( CHILD_THEME_DIR . '/style.css' ) ) {
                // Compare child style.css to parent style.css, if they're the same, Bolts is active theme (not parent)
                // and there's no need to load the stylesheet again
                if ( md5( CHILD_THEME_DIR . '/style.css' ) !== md5_file( THEME_DIR . '/style.css' ) ) {
                    wp_register_style( 'child-theme-styles', CHILD_THEME_URI . '/style.css', array( 'bolts-proprietary-styles' ), THEME_VERSION );
                    wp_enqueue_style( 'child-theme-styles' );
                }
            }
			
			// Load custom stylesheets last so they override everything
			if ( file_exists( THEME_DIR . '/custom-style.css' ) ) {
				wp_register_style( 'bolts-custom-css', THEME_URI . '/custom-style.css', null, THEME_VERSION );
				wp_enqueue_style( 'bolts-custom-css' );
			}
			
			// Load custom stylesheets last so they override everything
			if ( file_exists( CHILD_THEME_DIR . '/custom-style.css' ) ) {
				wp_register_style( 'bolts-custom-child-css', CHILD_THEME_URI . '/custom-style.css', null, THEME_VERSION );
				wp_enqueue_style( 'bolts-custom-child-css' );
			}
			
		}
	}
	
	/**
	 * Add custom widgets
	 * 
	 * @param     void
	 * @access    public
	 * @since     1.0
	 * @modified  1.0
	 */
	public function widgets() {
		
		register_widget( 'Bolts_Popular_Posts_Widget' );
		//register_widget( 'Bolts_125_Widget' );
		register_widget( 'Bolts_Facebook_Like_Widget' );
		register_widget( 'Bolts_Twitter_Widget' );
		register_widget( 'Bolts_Login_Form_Widget' );
		register_widget( 'Bolts_Contact_Form_Widget' );
		
	}
	
	/**
	 * Add WordPress hooks
	 * 
	 * @param     void
	 * @access    public
	 * @since     1.0
	 * @modified  1.1
	 */
	public function wp_hooks() {
		
		add_action( 'init',                 array( &$this, 'scripts' ) );
		add_action( 'init',                 array( &$this, 'styles' ) );
		add_action( 'init',                 array( &$this, 'extensions' ) );
		add_action( 'init',                 array( &$this, 'register_menus' ) );
		add_action( 'init',                 array( &$this, 'register_sidebars' ) );
		add_action( 'widgets_init',         array( &$this, 'widgets' ) );
		add_filter( 'the_content',          array( &$this, 'content_validation' ) );
		add_filter( 'get_comments_number',  array( &$this, 'comment_count' ), 0 );
		add_filter( 'the_content',          array( &$this, 'prep_toc' ) );
		
		add_filter( 'admin_init',           array( &$this, 'editor_style' ) );
		add_filter( 'mce_buttons_2',        array( &$this, 'mce_buttons_2' ) );
		add_filter( 'tiny_mce_before_init', array( &$this, 'mce_before_init' ) );
		
		add_filter( 'comment_form_default_fields', array( &$this, 'comment_fields' ) );
		
		//add_filter( 'wp_title',             array( &$this, 'meta_title' ) );
		//add_action( 'wp_head',              array( &$this, 'meta_description' ) );
		add_action( 'wp_head',              array( &$this, 'facebook_meta' ) );
		
		add_action( 'bolts_after_nav',      array( &$this, 'floating_sharebar' ) );
		
		add_action( 'bolts_footer',         array( &$this, 'footer_credit_link' ) );
		
		add_action( 'wp_print_styles',      array( &$this, 'custom_style' ) );
		add_action( 'wp_footer',            array( &$this, 'google_analytics' ) );
		
		add_action( 'admin_notices',        array( &$this, 'admin_notices' ) );

		add_action( 'admin_head',           array( &$this, 'admin_style' ) );
		add_filter( 'admin_footer_text',    array( &$this, 'admin_footer_text' ) );
		add_action( 'login_head',           array( &$this, 'login_style' ) );
		
		add_action( 'admin_init', 'flush_rewrite_rules' );
		
	}
	
}

?>