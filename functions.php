<?php
/**
 * Functions
 *
 * Initializes the theme class and includes support functions files,
 * including template tags and the WordPress custom header code.
 *
 * @package Bolts
 * @subpackage Functions
 */

global $bolts;

require_once( TEMPLATEPATH . '/library/bolts.php' );
$bolts = new Bolts();

require_once( BOLTS_FUNCTIONS . '/hooks.php' );
require_once( BOLTS_FUNCTIONS . '/template-tags.php' );
require_once( BOLTS_FUNCTIONS . '/formats.php' );
require_once( BOLTS_FUNCTIONS . '/custom-header.php' );

?>