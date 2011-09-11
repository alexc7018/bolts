<?php
/**
 * Hook functions
 * Modeled after those in Hybrid by Justin Tadlock.
 *
 * @since 1.0b1
 * @package Bolts
 * @subpackage Functions
 */
 
/**
 * Before HTML.  Loaded just after <body> but before any content is displayed.
 * @since 1.0b1
 */
function bolts_before_html() {
	do_action( 'bolts_before_html' );
}

/**
 * After HTML.
 * Loaded just before </body> and after all content.
 * @since 1.0b1
 */
function bolts_after_html() {
	do_action( 'bolts_after_html' );
}

/**
 * Added to the header before wp_head().
 * @since 1.0b1
 */
function bolts_head() {
	do_action( 'bolts_head' );
}

/**
 * Before the header.
 * @since 1.0b1
 */
function bolts_before_header() {
	do_action( 'bolts_before_header' );
}

/**
 * Header.
 * @since 1.0b1
 */
function bolts_header() {
	do_action( 'bolts_header' );
}

/**
 * After the header.
 * @since 1.0b1
 */
function bolts_after_header() {
	do_action( 'bolts_after_header' );
}

/**
 * Before primary menu.
 * @since 0.8
 */
function bolts_before_primary_menu() {
	do_action( 'bolts_before_primary_menu' );
}

/**
 * After primary menu.
 * @since 0.8
 */
function bolts_after_primary_menu() {
	do_action( 'bolts_after_primary_menu' );
}

/**
 * Before secondary menu.
 * @since 0.8
 */
function bolts_before_secondary_menu() {
	do_action( 'bolts_before_secondary_menu' );
}

/**
 * After secondary menu.
 * @since 0.8
 */
function bolts_after_secondary_menu() {
	do_action( 'bolts_after_secondary_menu' );
}

/**
 * Before footer menu.
 * @since 0.8
 */
function bolts_before_footer_menu() {
	do_action( 'bolts_before_footer_menu' );
}

/**
 * After footer menu.
 * @since 0.8
 */
function bolts_after_footer_menu() {
	do_action( 'bolts_after_footer_menu' );
}

/**
 * Before footer menu.
 * @since 0.8
 */
function bolts_before_404_menu() {
	do_action( 'bolts_before_404_menu' );
}

/**
 * After footer menu.
 * @since 0.8
 */
function bolts_after_404_menu() {
	do_action( 'bolts_after_404_menu' );
}

/**
 * After main navigation (primary/secondary menus).
 * @since 1.1
 */
function bolts_after_nav() {
	do_action( 'bolts_after_nav' );
}

/**
 * Before the container.
 * @since 1.0b1
 */
function bolts_before_container() {
	do_action( 'bolts_before_container' );
}

/**
 * Before the content.
 * @since 1.0b1
 */
function bolts_before_content() {
	do_action( 'bolts_before_content' );
}

/**
 * After the content.
 * @since 1.0b1
 */
function bolts_after_content() {
	do_action( 'bolts_after_content' );
}

/**
 * Before each entry.
 * @since 1.0b1
 */
function bolts_before_entry() {
	do_action( 'bolts_before_entry' );
}

/**
 * After each entry.
 * @since 1.0b1
 */
function bolts_after_entry() {
	do_action( 'bolts_after_entry' );
}

/**
 * Before the primary sidebar.
 * @since 1.0b1
 */
function bolts_before_primary_sidebar() {
	do_action( 'bolts_before_primary_sidebar' );
}

/**
 * After the primary sidebar.
 * @since 1.0b1
 */
function bolts_after_primary_sidebar() {
	do_action( 'bolts_after_primary_sidebar' );
}

/**
 * Before the secondary sidebar.
 * @since 1.0b1
 */
function bolts_before_secondary_sidebar() {
	do_action( 'bolts_before_secondary_sidebar' );
}

/**
 * After the secondary sidebar.
 * @since 1.0b1
 */
function bolts_after_secondary_sidebar() {
	do_action( 'bolts_after_secondary_sidebar' );
}

/**
 * After singular views but before the comments template.
 * @since 0.7
 */
function bolts_after_singular() {
	do_action( 'bolts_after_singular' );
}

/**
 * After the container area.
 * @since 1.0b1
 */
function bolts_after_container() {
	do_action( 'bolts_after_container' );
}

/**
 * Before the footer.
 * @since 1.0b1
 */
function bolts_before_footer() {
	do_action( 'bolts_before_footer' );
}

/**
 * The footer.
 * @since 1.0b1
 */
function bolts_footer() {
	do_action( 'bolts_footer' );
}

/**
 * After the footer.
 * @since 1.0b1
 */
function bolts_after_footer() {
	do_action( 'bolts_after_footer' );
}

/**
 * Fires before each comment's information.
 * @since 1.0b1
 */
function bolts_before_comment() {
	do_action( 'bolts_before_comment' );
}

/**
 * Fires after each comment's information.
 * @since 1.0b1
 */
function bolts_after_comment() {
	do_action( 'bolts_after_comment' );
}

/**
 * Fires before the comment list.
 * @since 1.0b1
 */
function bolts_before_comment_list() {
	do_action( 'bolts_before_comment_list' );
}

/**
 * Fires after the comment list.
 * @since 1.0b1
 */
function bolts_after_comment_list() {
	do_action( 'bolts_after_comment_list' );
}

?>