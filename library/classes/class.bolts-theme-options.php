<?php

/**
 * Master theme class
 * 
 * @package Bolts
 * @since 1.0
 */
class Bolts_Theme_Options {
	
	private $sections;
	private $checkboxes;
	private $settings;
	
	/**
	 * Construct
	 *
	 * @since 1.0
	 * @modified 1.1
	 */
	public function __construct() {
		
		if ( ! defined( 'BOLTS_TEXT_DOMAIN' ) )
			define( 'BOLTS_TEXT_DOMAIN', '' );
		
		// This will keep track of the checkbox options for the validate_settings function.
		$this->checkboxes = array();
		$this->settings = array();
		$this->get_settings();
		
		$this->sections['general']      = __( 'General Settings', BOLTS_TEXT_DOMAIN );
		$this->sections['appearance']   = __( 'Appearance', BOLTS_TEXT_DOMAIN );
		$this->sections['social_media'] = __( 'Social Media', BOLTS_TEXT_DOMAIN );
		//$this->sections['seo']          = __( 'SEO', BOLTS_TEXT_DOMAIN );
		//$this->sections['contact_form'] = __( 'Contact Form', BOLTS_TEXT_DOMAIN );
		$this->sections['reset']        = __( 'Reset to Defaults', BOLTS_TEXT_DOMAIN );
		$this->sections['about']        = __( 'About', BOLTS_TEXT_DOMAIN );
		
		add_action( 'admin_menu', array( &$this, 'add_pages' ) );
		add_action( 'admin_init', array( &$this, 'register_settings' ) );
		
		if ( ! get_option( 'bolts_options' ) )
			$this->initialize_settings();
		
	}
	
	/**
	 * Add options page
	 *
	 * @since 1.0
	 */
	public function add_pages() {
		
		$admin_page = add_theme_page( __( 'Theme Options', BOLTS_TEXT_DOMAIN ), __( 'Theme Options', BOLTS_TEXT_DOMAIN ), 'manage_options', 'bolts-options', array( &$this, 'display_page' ) );
		
		add_action( 'admin_print_scripts-' . $admin_page, array( &$this, 'scripts' ) );
		
	}
	
	/**
	 * Create settings field
	 *
	 * @since 1.0
	 */
	public function create_setting( $args = array() ) {
		
		$defaults = array(
			'id'      => 'default_field',
			'title'   => __( 'Default Field', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( 'This is a default description.', BOLTS_TEXT_DOMAIN ),
			'std'     => '',
			'type'    => 'text',
			'section' => 'general',
			'choices' => array(),
			'class'   => ''
		);
			
		extract( wp_parse_args( $args, $defaults ) );
		
		$field_args = array(
			'type'      => $type,
			'id'        => $id,
			'desc'      => $desc,
			'std'       => $std,
			'choices'   => $choices,
			'label_for' => $id,
			'class'     => $class
		);
		
		if ( $type == 'checkbox' )
			$this->checkboxes[] = $id;
		
		add_settings_field( $id, $title, array( $this, 'display_setting' ), 'bolts-options', $section, $field_args );
	}
	
	/**
	 * Display options page
	 *
	 * @since 1.0
	 */
	public function display_page() {
		
		echo '<div class="wrap">
	<div class="icon32" id="icon-options-general"></div>
	<h2>' . __( 'Theme Options', BOLTS_TEXT_DOMAIN ) . '</h2>';
	
		if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == true )
			echo '<div class="updated fade"><p>' . __( 'Theme options updated.', BOLTS_TEXT_DOMAIN ) . '</p></div>';
		
		echo '<form action="options.php" method="post">';
	
		settings_fields( 'bolts_options' );
		echo '<div class="ui-tabs">
			<ul class="ui-tabs-nav">';
		
		foreach ( $this->sections as $section_slug => $section )
			echo '<li><a href="#' . $section_slug . '">' . $section . '</a></li>';
		
		echo '</ul>';
		do_settings_sections( $_GET['page'] );
		
		echo '</div>
		<p class="submit"><input name="Submit" type="submit" class="button-primary" value="' . __( 'Save Changes', BOLTS_TEXT_DOMAIN ) . '" /></p>
		
	</form>';
	
	wp_print_scripts( 'bolts-cookie' );
	
	echo '<script type="text/javascript">
		jQuery(document).ready(function($) {
			var sections = [];';
			
			foreach ( $this->sections as $section_slug => $section )
				echo "sections['$section'] = '$section_slug';";
			
			echo 'var wrapped = $(".wrap h3").wrap("<div class=\"ui-tabs-panel\">");
			wrapped.each(function() {
				$(this).parent().append($(this).parent().nextUntil("div.ui-tabs-panel"));
			});
			$(".ui-tabs-panel").each(function(index) {
				$(this).attr("id", sections[$(this).children("h3").text()]);
				if (index > 0)
					$(this).addClass("ui-tabs-hide");
			});
			$(".ui-tabs").tabs({
				fx: { opacity: "toggle", duration: "fast" },
				cookie: { expires: 1 }
			});
			
			$("input[type=text], textarea").each(function() {
				if ($(this).val() == $(this).attr("placeholder") || $(this).val() == "")
					$(this).css("color", "#999");
			});
			
			$("input[type=text], textarea").focus(function() {
				if ($(this).val() == $(this).attr("placeholder") || $(this).val() == "") {
					$(this).val("");
					$(this).css("color", "#000");
				}
			}).blur(function() {
				if ($(this).val() == "" || $(this).val() == $(this).attr("placeholder")) {
					$(this).val($(this).attr("placeholder"));
					$(this).css("color", "#999");
				}
			});
			
			$(".wrap h3, .wrap table").show();
			
			$(".warning").change(function() {
				if ($(this).is(":checked"))
					$(this).parent().css("background", "#c00").css("color", "#fff").css("fontWeight", "bold");
				else
					$(this).parent().css("background", "none").css("color", "inherit").css("fontWeight", "normal");
			});
			
			if ($.browser.mozilla) 
			         $("form").attr("autocomplete", "off");
		});
	</script>
</div>';
		
	}
	
	/**
	 * Description for section
	 *
	 * @since 1.0
	 */
	public function display_section() {
		// code
	}
	
	/**
	 * Description for About section
	 *
	 * @since 1.0
	 * @modified 1.1
	 */
	public function display_about_section() {
		
		$copyright_year = ( date( 'Y' ) == '2011' ? '2011' : '2011&ndash;' . date( 'Y' ) );
		
		if ( function_exists( 'child_theme_display_about' ) )
			child_theme_display_about();
		
		echo '<h4>' . sprintf( __( 'Bolts WordPress parent theme %s version %s', BOLTS_TEXT_DOMAIN ), '<small class="quiet">', BOLTS_VERSION ) . '</small></h4>
		
		<p>&copy;' . $copyright_year . ' <a href="http://themejack.net/" title="' . __( 'Visit Themejack', BOLTS_TEXT_DOMAIN ) . '">Themejack</a>.</p>
		
		<p>' . sprintf( __( 'Bolts is licensed under the %s GNU General Public License version 3.0%s', BOLTS_TEXT_DOMAIN ), '<a href="http://www.gnu.org/licenses/gpl-3.0-standalone.html">', '</a>.</p>' );
		
		echo '<div class="credits">';
		
		echo '<h4>' . __( 'Credits', BOLTS_TEXT_DOMAIN ), '</h4>';
		
			echo '<div class="credit">' . sprintf( __( '%s by %sDev7studios%s', BOLTS_TEXT_DOMAIN ), '<a href="http://nivo.dev7studios.com/"><img src="' . THEME_URI . '/images/credits/nivo-slider.png" width="200" height="47" /></a><br />', '<a href="http://dev7studios.com/">', '</a></div>' );
			echo '<div class="credit">' . sprintf( __( '%s by %s360&deg;north%s', BOLTS_TEXT_DOMAIN ), '<a href="http://codecanyon.net/item/sliding-tabs-jquery-plugin/141774"><img src="' . THEME_URI . '/images/credits/sliding-tabs.png" width="161" height="39" /></a><br />', '<a href="http://codecanyon.net/user/360north">', '</a></div>' );
			
		echo '</div>';
		
	}
	
	/**
	 * HTML output for text field
	 *
	 * @since 1.0
	 */
	public function display_setting( $args = array() ) {
		
		extract( $args );
		
		$options = get_option( 'bolts_options' );
		
		if ( ! isset( $options[$id] ) && $type != 'checkbox' )
			$options[$id] = $std;
		elseif ( ! isset( $options[$id] ) )
			$options[$id] = 0;
		
		$field_class = '';
		if ( $class != '' )
			$field_class = ' ' . $class;
		
		switch ( $type ) {
			
			case 'heading':
				echo '</td></tr><tr valign="top"><td colspan="2">' . $desc;
				break;
			
			case 'checkbox':
				
				echo '<input class="checkbox' . $field_class . '" type="checkbox" id="' . $id . '" name="bolts_options[' . $id . ']" value="1" ' . checked( $options[$id], 1, false ) . ' /> <label for="' . $id . '">' . $desc . '</label>';
				
				break;
			
			case 'select':
				echo '<select class="select' . $field_class . '" name="bolts_options[' . $id . ']">';
				
				foreach ( $choices as $value => $label )
					echo '<option value="' . esc_attr( $value ) . '"' . selected( $options[$id], $value, false ) . '>' . $label . '</option>';
				
				echo '</select>';
				
				if ( $desc != '' )
					echo '<br /><span class="description">' . $desc . '</span>';
				
				break;
			
			case 'radio':
				$i = 0;
				foreach ( $choices as $value => $label ) {
					echo '<input class="radio' . $field_class . '" type="radio" name="bolts_options[' . $id . ']" id="' . $id . $i . '" value="' . esc_attr( $value ) . '" ' . checked( $options[$id], $value, false ) . '> <label for="' . $id . $i . '">' . $label . '</label>';
					if ( $i < count( $options ) - 1 )
						echo '<br />';
					$i++;
				}
				
				if ( $desc != '' )
					echo '<br /><span class="description">' . $desc . '</span>';
				
				break;
			
			case 'textarea':
				echo '<textarea class="' . $field_class . '" id="' . $id . '" name="bolts_options[' . $id . ']" placeholder="' . $std . '" rows="5" cols="30">' . wp_htmledit_pre( $options[$id] ) . '</textarea>';
				
				if ( $desc != '' )
					echo '<br /><span class="description">' . $desc . '</span>';
				
				break;
			
			case 'password':
				echo '<input class="regular-text' . $field_class . '" type="password" id="' . $id . '" name="bolts_options[' . $id . ']" value="' . esc_attr( $options[$id] ) . '" />';
				
				if ( $desc != '' )
					echo '<br /><span class="description">' . $desc . '</span>';
				
				break;
			
			case 'text':
			default:
		 		echo '<input class="regular-text' . $field_class . '" type="text" id="' . $id . '" name="bolts_options[' . $id . ']" placeholder="' . $std . '" value="' . esc_attr( $options[$id] ) . '" />';
		 		
		 		if ( $desc != '' )
		 			echo '<br /><span class="description">' . $desc . '</span>';
		 		
		 		break;
		 	
		}
		
	}
	
	/**
	 * Settings and defaults
	 * 
	 * @since 1.0
	 */
	public function get_settings() {
		
		// Find Color Schemes
		$schemes = array();
		if ( file_exists( CHILD_THEME_DIR . '/color-schemes' ) ) {
			if ( $handle = opendir( CHILD_THEME_DIR . '/color-schemes' ) ) {
				while ( ( $file = readdir( $handle ) ) !== false ) {
					if ( $file != '.' && $file != '..' ) {
						$content = file_get_contents( CHILD_THEME_DIR . '/color-schemes/' . $file );
						if ( strpos( $content, 'Color Scheme: ' ) !== false ) {
							$scheme_title_start = strpos( $content, 'Color Scheme: ' ) + 14;
							$scheme_title_end = strpos( $content, '*/' ) - 1;
							$scheme_title = substr( $content, $scheme_title_start, $scheme_title_end - $scheme_title_start );
							$schemes[basename( $file, '.css' )] = $scheme_title;
						}
					}
				}
				closedir( $handle );
			}
		}
		asort( $schemes );
		
		/* General Settings
		===========================================*/
		
		$this->settings['human_readable_post_dates'] = array(
			'section' => 'general',
			'title'   => __( 'Friendly Post Dates', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( 'Display human readable post dates ("2 days ago").', BOLTS_TEXT_DOMAIN ),
			'type'    => 'checkbox',
			'std'     => 1
		);
		
		$this->settings['human_readable_comment_dates'] = array(
			'section' => 'general',
			'title'   => __( 'Friendly Comment Dates', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( 'Display human readable comment dates ("2 days ago").', BOLTS_TEXT_DOMAIN ),
			'type'    => 'checkbox',
			'std'     => 1
		);
		
		$this->settings['google_analytics'] = array(
			'title'   => __( 'Google Analytics ID', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( "Enter your Google Analytics ID here to automatically insert tracking code in your site's footer.", BOLTS_TEXT_DOMAIN ),
			'std'     => 'UA-XXXXX-X',
			'type'    => 'text',
			'section' => 'general'
		);
		
		$this->settings['rss_url'] = array(
			'title'   => __( 'RSS Feed URL', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( 'If you track your feed through Feedburner or another feed service, enter that URL here.', BOLTS_TEXT_DOMAIN ),
			'std'     => get_bloginfo( 'rss2_url' ),
			'type'    => 'text',
			'section' => 'general'
		);
		
		$this->settings['mint_analytics'] = array(
			'section' => 'general',
			'title'   => __( 'Mint Install Location', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( "If you use Mint analytics, enter the URL to its installation here. Tracking code will be inserted in your site's header.", BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => ''
		);
		
		$this->settings['contact_form_email'] = array(
			'section' => 'general',
			'title'   => __( 'Contact Form Email', BOLTS_TEXT_DOMAIN ),
			'desc'    => sprintf( __( 'Enter the email address you want to use for the contact form. You can add a contact form to your page using a shortcode: %s', BOLTS_TEXT_DOMAIN ), '<code>[contact-form]</code>' ),
			'type'    => 'text',
			'std'     => get_bloginfo('admin_email')
		);
		
		$this->settings['footer_credit_link'] = array(
			'section' => 'general',
			'title'   => __( 'Credit Link in Footer', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( 'Include links to Themejack and WordPress in the footer.', BOLTS_TEXT_DOMAIN ),
			'type'    => 'checkbox',
			'std'     => 0
		);
		
		/* Appearance
		===========================================*/
		
		$this->settings['color_scheme'] = array(
			'section' => 'appearance',
			'title'   => __( 'Color Scheme', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '', BOLTS_TEXT_DOMAIN ),
			'type'    => 'select',
			'std'     => '',
			'choices' => $schemes
		);
		
		$this->settings['favicon'] = array(
			'section' => 'appearance',
			'title'   => __( 'Favicon', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( 'Enter the URL to your custom favicon. It should be 16x16 pixels in size.', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => ''
		);
		
		$this->settings['custom_css'] = array(
			'title'   => __( 'Custom Styles', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( 'Enter any custom CSS here to apply it to your theme.', BOLTS_TEXT_DOMAIN ),
			'std'     => '',
			'type'    => 'textarea',
			'section' => 'appearance',
			'class'   => 'code'
		);
		
		$this->settings['font_styles'] = array(
			'section' => 'appearance',
			'title'   => __( 'Enable Bolts Font Styles', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( 'Enable the font-family, font-weight, letter-spacing and text-transform styles in Bolts.', BOLTS_TEXT_DOMAIN ),
			'type'    => 'checkbox',
			'std'     => 1
		);
		
		$this->settings['custom_header'] = array(
			'section' => 'appearance',
			'title'   => __( 'Enable Custom Header', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( 'Enable the WordPress custom header functionality.', BOLTS_TEXT_DOMAIN ),
			'type'    => 'checkbox',
			'std'     => 1
		);
		
		$this->settings['custom_background'] = array(
			'section' => 'appearance',
			'title'   => __( 'Enable Custom Background', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( 'Enable the WordPress custom background functionality.', BOLTS_TEXT_DOMAIN ),
			'type'    => 'checkbox',
			'std'     => 1
		);
		
		/* Social Media
		===========================================*/
		
		$this->settings['facebook'] = array(
			'section' => 'social_media',
			'title'   => __( 'Facebook URL', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => ''
		);
		
		$this->settings['twitter'] = array(
			'section' => 'social_media',
			'title'   => __( 'Twitter Username', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => ''
		);
		
		$this->settings['youtube'] = array(
			'section' => 'social_media',
			'title'   => __( 'YouTube Username', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => ''
		);
		
		$this->settings['flickr'] = array(
			'section' => 'social_media',
			'title'   => __( 'Flickr Username', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => ''
		);
		
		$this->settings['floating_sharebar_heading'] = array(
			'section' => 'social_media',
			'title'   => '',
			'desc'    => '<h4>' . __( 'Floating Share Bar', BOLTS_TEXT_DOMAIN ) . '</h4>',
			'type'    => 'heading'
		);
		
		$this->settings['floating_sharebar'] = array(
			'section' => 'social_media',
			'title'   => __( 'Enable Floating Share Bar', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( 'Display the floating share bar on single posts. Includes sharing buttons for Facebook, Twitter, Google+, StumbleUpon, and Digg.', BOLTS_TEXT_DOMAIN ),
			'type'    => 'checkbox',
			'std'     => 1
		);
		
		$this->settings['facebook_meta_heading'] = array(
			'section' => 'social_media',
			'title'   => '',
			'desc'    => '<h4>' . __( 'Facebook Meta Tags', BOLTS_TEXT_DOMAIN ) . '</h4><span class="description">' . __( 'These tags determine the title, description, and thumbnail image that display when a user shares your site on Facebook.', BOLTS_TEXT_DOMAIN ) . '</span>',
			'type'    => 'heading'
		);
		
		$this->settings['facebook_meta_title_posts'] = array(
			'section' => 'social_media',
			'title'   => __( 'Title (Posts)', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => '%%post_title%% | %%site_title%%'
		);
		
		$this->settings['facebook_meta_title_other'] = array(
			'section' => 'social_media',
			'title'   => __( 'Title (Other)', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => '%%site_title%%'
		);
		
		$this->settings['facebook_meta_description_posts'] = array(
			'section' => 'social_media',
			'title'   => __( 'Description (Posts)', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => '%%post_excerpt%%'
		);
		
		$this->settings['facebook_meta_description_other'] = array(
			'section' => 'social_media',
			'title'   => __( 'Description (Other)', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => '%%site_description%%'
		);
		
		$this->settings['facebook_meta_image_posts'] = array(
			'section' => 'social_media',
			'title'   => __( 'Thumbnail Image (Posts)', BOLTS_TEXT_DOMAIN ),
			'desc'    => sprintf( __( 'Enter %s or the URL to a custom image.', BOLTS_TEXT_DOMAIN ), '<strong>%%post_thumbnail%%</strong>' ),
			'type'    => 'text',
			'std'     => '%%post_thumbnail%%'
		);
		
		$this->settings['facebook_meta_image_other'] = array(
			'section' => 'social_media',
			'title'   => __( 'Thumbnail Image (Other)', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( 'Enter the URL to a custom image.', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => ''
		);
		
		
		/* SEO
		===========================================*/
		/*
		$this->settings['using_seo_plugin'] = array(
			'section' => 'seo',
			'title'   => __( 'Turn Off Theme SEO', BOLTS_TEXT_DOMAIN ),
			'type'    => 'checkbox',
			'std'     => 0,
			'desc'    => sprintf( __( 'Check this box if you are using a plugin for SEO, such as %s WordPress SEO%s or %s Headspace%s.', BOLTS_TEXT_DOMAIN ), '<a href="http://yoast.com/wordpress/seo/" target="_blank">', '</a>', '<a href="http://urbangiraffe.com/plugins/headspace2/" target="_blank">', '</a>' )
		);
		
		$this->settings['seo_heading_title'] = array(
			'section' => 'seo',
			'title'   => __( '', BOLTS_TEXT_DOMAIN ),
			'desc'    => '<h4>' . __( 'Title Tags', BOLTS_TEXT_DOMAIN ) . '</h4>',
			'type'    => 'heading'
		);
		
		$this->settings['title_blog'] = array(
			'section' => 'seo',
			'title'   => __( 'Blog Page Title', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => '%%site_title%% | %%site_description%%'
		);
		
		$this->settings['title_home'] = array(
			'section' => 'seo',
			'title'   => __( 'Home Page Title', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => '%%site_title%% | %%site_description%%'
		);
		
		$this->settings['title_single'] = array(
			'section' => 'seo',
			'title'   => __( 'Single Post Title', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => '%%post_title%% | %%site_title%%'
		);
		
		$this->settings['title_page'] = array(
			'section' => 'seo',
			'title'   => __( 'Page Title', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => '%%post_title%% | %%site_title%%'
		);
		
		$this->settings['title_date_archive'] = array(
			'section' => 'seo',
			'title'   => __( 'Date Archive Title', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => sprintf( __( 'Posts from %s', BOLTS_TEXT_DOMAIN ), '%%archive_date%%' ) . ' | %%site_title%%'
		);
		
		$this->settings['title_category_archive'] = array(
			'section' => 'seo',
			'title'   => __( 'Category Archive Title', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => sprintf( __( 'Posts in %s', BOLTS_TEXT_DOMAIN ), "&lsquo;%%category%%&rsquo;" ) . ' | %%site_title%%'
		);
		
		$this->settings['title_tag_archive'] = array(
			'section' => 'seo',
			'title'   => __( 'Tag Archive Title', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => sprintf( __( 'Posts tagged %s', BOLTS_TEXT_DOMAIN ), "&lsquo;%%tag%%&rsquo;" ) . ' | %%site_title%%'
		);
		
		$this->settings['title_author_archive'] = array(
			'section' => 'seo',
			'title'   => __( 'Author Archive Title', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => sprintf( __( 'Posts by %s', BOLTS_TEXT_DOMAIN ), "%%author%%" ) . ' | %%site_title%%'
		);
		
		$this->settings['title_search_results'] = array(
			'section' => 'seo',
			'title'   => __( 'Search Results Title', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => sprintf( __( 'Search Results for %s', BOLTS_TEXT_DOMAIN ), "&lsquo;%%search%%&rsquo;" ) . ' | %%site_title%%'
		);
		
		$this->settings['title_404'] = array(
			'section' => 'seo',
			'title'   => __( '404 Page Title', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '' ),
			'type'    => 'text',
			'std'     => __( 'Page Not Found', BOLTS_TEXT_DOMAIN ) . ' | %%site_title%%'
		);
		
		$this->settings['title_paged'] = array(
			'section' => 'seo',
			'title'   => __( 'Multiple Pages (Post, Page, or Archive)', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( 'This will be appended onto the current title.', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => ' | ' . sprintf( __( 'Page %s of %s', BOLTS_TEXT_DOMAIN ), '%%num%%', '%%total%%' )
		);
		
		
		$this->settings['seo_heading_description'] = array(
			'section' => 'seo',
			'title'   => __( '', BOLTS_TEXT_DOMAIN ),
			'desc'    => '<h4>' . __( 'Meta Description', BOLTS_TEXT_DOMAIN ) . '</h4>',
			'type'    => 'heading'
		);
		
		$this->settings['description_home'] = array(
			'section' => 'seo',
			'title'   => __( 'Home Page Description', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => '%%site_description%%'
		);
		
		$this->settings['description_posts'] = array(
			'section' => 'seo',
			'title'   => __( 'Description for Posts & Pages', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => '%%post_excerpt%%'
		);
		
		$this->settings['description_other'] = array(
			'section' => 'seo',
			'title'   => __( 'Description for Everything Else', BOLTS_TEXT_DOMAIN ),
			'desc'    => __( '', BOLTS_TEXT_DOMAIN ),
			'type'    => 'text',
			'std'     => '%%site_description%%'
		);
		*/
		
		/* Reset
		===========================================*/
		
		$this->settings['reset_theme'] = array(
			'section' => 'reset',
			'title'   => __( 'Reset theme', BOLTS_TEXT_DOMAIN ),
			'type'    => 'checkbox',
			'std'     => 0,
			'class'   => 'warning',
			'desc'    => __( 'Check this box and click "Save Changes" below to reset theme options to their defaults.', BOLTS_TEXT_DOMAIN )
		);
		
	}
	
	/**
	 * Initialize settings to their default values
	 * 
	 * @since 1.0
	 */
	public function initialize_settings() {
		
		$default_settings = array();
		foreach ( $this->settings as $id => $setting ) {
			if ( $setting['type'] != 'heading' )
				$default_settings[$id] = $setting['std'];
		}
		
		update_option( 'bolts_options', $default_settings );
		
	}
	
	/**
	* Register settings
	*
	* @since 1.0
	*/
	public function register_settings() {
		
		register_setting( 'bolts_options', 'bolts_options', array ( &$this, 'validate_settings' ) );
		
		foreach ( $this->sections as $slug => $title ) {
			if ( $slug == 'about' )
				add_settings_section( $slug, $title, array( &$this, 'display_about_section' ), 'bolts-options' );
			else
				add_settings_section( $slug, $title, array( &$this, 'display_section' ), 'bolts-options' );
		}
		
		$this->get_settings();
		
		foreach ( $this->settings as $id => $setting ) {
			$setting['id'] = $id;
			$this->create_setting( $setting );
		}
		
	}
	
	/**
	* jQuery Tabs
	*
	* @since 1.0
	*/
	public function scripts() {
		
		wp_enqueue_script( 'jquery-ui-tabs' );
		
	}
	
	/**
	* Validate settings
	*
	* @since 1.0
	*/
	public function validate_settings( $input ) {
		
		if ( ! isset( $input['reset_theme'] ) ) {
			$options = get_option( 'bolts_options' );
			
			foreach ( $this->checkboxes as $id ) {
				if ( isset( $options[$id] ) && ! isset( $input[$id] ) )
					unset( $options[$id] );
			}
			
			return $input;
		}
		return false;
		
	}
	
}
?>