<?php
/**
 * WordPress Coding Standard.
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @link     https://make.wordpress.org/core/handbook/best-practices/coding-standards/
 */

/**
 * WordPress_Sniffs_Theme_PluginTerritoryFunctionsSniff.
 *
 * ERROR : The following three functions are not allowed (plugin territory): register_post_type(),
 * register_taxonomy(), add_shortcode(). Review this list with the Theme Review board as there might
 * be some more functions which could be added. The sniff could probably just extend the Forbidden
 * Functions sniff - though it should be kept as a separate sniff for clarity.
 *
 * @category Theme
 * @package  PHP_CodeSniffer
 * @author   khacoder
 */
class WordPress_Sniffs_Theme_PluginTerritoryFunctionsSniff extends WordPress_Sniffs_Functions_FunctionRestrictionsSniff {

	/**
	 * Groups of functions to restrict
	 *
	 * Example: groups => array(
	 * 	'lambda' => array(
	 * 		'type'      => 'error' | 'warning',
	 * 		'message'   => 'Use anonymous functions instead please!',
	 * 		'functions' => array( 'eval', 'create_function' ),
	 * 	)
	 * )
	 *
	 * @return array
	 */
	public function getGroups() {
		return array(
			'filefunctions' => array(
				'type'      => 'error',
				'message'   => '%s() is not allowed because it is considered a plugin territory function.',
				'functions' => array(
					'register_post_type',
					'register_taxonomy',
					'add_shortcode',
					'register_taxonomy_for_object_type',
					'flush_rewrite_rules',
				),
			),
		);

	}
} // end class
