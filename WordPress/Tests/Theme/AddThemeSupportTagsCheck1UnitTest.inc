<?php
	/**
	 * Error check file for AddThemeSupportTagsCheck1Sniff
	 * Note that this teat file will not work without an accompanying style.css file.
	 * This test also requires the WordPress_AbstractThemeSniff class
	 * Test procedure :
	 *   remove all tags in style.css tags list that are related to theme supports
	 *     custom-header, custom-background, custom-logo, post-formats, featured-images, featured-image-header, custom-menu
	 *   run the sniff and check that errors are displayed
	 *   add tags into style.css
	 *   run sniff and check that all errors are be gone
	 */

	echo 'this is a test file';
	//add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );
	//add_theme_support( 'custom-background' );
	//add_theme_support( 'custom-header' );
	//add_theme_support( 'custom-logo' );
	//add_theme_support( 'post-thumbnails' );
	//register_nav_menu('main-nav' , __( 'Main Menu' , 'jot' ) );
