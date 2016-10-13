<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Restricts the use of various functions that are plugin territory.
 *
 * @link    https://make.wordpress.org/themes/handbook/review/required/#presentation-vs-functionality
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class WordPress_Sniffs_Theme_PluginTerritoryFunctionsSniff extends WordPress_AbstractFunctionRestrictionsSniff {

	/**
	 * Groups of functions to restrict.
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
			'plugin-territory' => array(
				'type'      => 'error',
				'message'   => 'Function %s() is not allowed because it is plugin territory.',
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

} // End class.
