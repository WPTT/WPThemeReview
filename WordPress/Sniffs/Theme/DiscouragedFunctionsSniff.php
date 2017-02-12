<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Discouraged functions.
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class WordPress_Sniffs_Theme_DiscouragedFunctionsSniff extends WordPress_AbstractFunctionRestrictionsSniff {

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
			'site_url' => array(
				'type'      => 'warning',
				'message'   => '%s() found. Use home_url() instead.',
				'functions' => array(
					'site_url',
					'get_home_url',
				),
			),
			'archive_title' => array(
				'type'      => 'warning',
				'message'   => '%s() found. Use the_archive_title() instead.',
				'functions' => array(
					'single_cat_title',
					'single_tag_title',
				),
			),
			'archive_description' => array(
				'type'      => 'warning',
				'message'   => '%s() found. Use the_archive_description() instead.',
				'functions' => array(
					'category_description',
					'tag_description',
				),
			),
			'archive_pagination' => array(
				'type'      => 'warning',
				'message'   => '%s() found. Use the_posts_pagination() instead.',
				'functions' => array(
					'paginate_links',
				),
			),
		);

	}

} // End class.
