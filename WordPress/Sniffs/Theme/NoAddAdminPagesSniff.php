<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * WordPress_Sniffs_Theme_NoAddAdminPagesSniff.
 *
 * Forbids the use of add_..._page() functions within Themes with the exception of `add_theme_page()`.
 *
 * @link    https://make.wordpress.org/themes/handbook/review/required/theme-check-plugin/#admin-menu
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class WordPress_Sniffs_Theme_NoAddAdminPagesSniff extends WordPress_Sniffs_Functions_FunctionRestrictionsSniff {

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

			'add_menu_pages' => array(
				'type'      => 'error',
				'message'   => 'Themes should use <strong>add_theme_page()</strong> for adding admin pages. Found %s.',
				'functions' => array(
					// Menu Pages.
					'add_menu_page',
					'add_object_page',
					'add_utility_page',

					// SubMenu Pages.
					'add_submenu_page',

					// WordPress Administration Menus.
					'add_dashboard_page',
					'add_posts_page',
					'add_media_page',
					'add_pages_page',
					'add_comments_page',
					'add_plugins_page',
					'add_users_page',
					'add_management_page',
					'add_options_page',
				),
			),
		);
	}

} // End class.
