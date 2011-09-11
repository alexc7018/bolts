<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php wp_title(); ?></title>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
	<?php
	if ( bolts_option( 'favicon' ) && bolts_option( 'favicon' ) != '' )
		echo '<link rel="shortcut icon" href="' . bolts_option( 'favicon' ) . '" />' . "\n";
	
	bolts_head();
	wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php bolts_before_html(); ?>

	<div id="container">
	<?php bolts_before_container(); ?>
		
		<?php bolts_before_header(); ?>
		
		<header>
			<?php bolts_header(); ?>
			<hgroup>
				<h1><a href="<?php echo home_url(); ?>" title="<?php _e( 'Home', BOLTS_TEXT_DOMAIN ); ?>"><?php bloginfo('name'); ?></a></h1>
				<h2><?php bloginfo( 'description' ); ?></h2>
			</hgroup>
			<?php get_search_form(); ?>
			<a class="skip-link" href="#main" title="<?php _e( 'Skip to content', BOLTS_TEXT_DOMAIN ); ?>"><?php _e( 'Skip to content', BOLTS_TEXT_DOMAIN ); ?></a>
		</header>
		
		<?php bolts_after_header(); ?>
		
		<?php bolts_menu( 'primary' ); ?>
		<?php
		// To enable a secondary menu that defaults to a list of categories, uncomment the following line:
		//bolts_menu( 'secondary' );
		?>
		
		<?php bolts_after_nav(); ?>