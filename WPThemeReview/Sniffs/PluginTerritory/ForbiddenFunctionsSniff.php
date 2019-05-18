<?php
/**
 * WPThemeReview Coding Standard.
 *
 * @package WPTRT\WPThemeReview
 * @link    https://github.com/WPTRT/WPThemeReview
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WPThemeReview\Sniffs\PluginTerritory;

use WordPressCS\WordPress\AbstractFunctionRestrictionsSniff;

/**
 * Restricts the use of various functions that are plugin territory.
 *
 * @link  https://make.wordpress.org/themes/handbook/review/required/#presentation-vs-functionality
 *
 * @since 0.1.0
 */
class ForbiddenFunctionsSniff extends AbstractFunctionRestrictionsSniff {

	/**
	 * Groups of functions to restrict.
	 *
	 * Example: groups => array(
	 *  'lambda' => array(
	 *      'type'      => 'error' | 'warning',
	 *      'message'   => 'Use anonymous functions instead please!',
	 *      'functions' => array( 'file_get_contents', 'create_function' ),
	 *  )
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
					'register_block_type',
					'unregister_block_type',
					'register_block_core_rss',
					'register_block_core_search',
					'register_block_core_archives',
					'register_block_core_calendar',
					'register_block_core_shortcode',
					'register_block_core_tag_cloud',
					'register_block_core_categories',
					'register_block_core_latest_posts',
				),
			),
		);
	}

}
