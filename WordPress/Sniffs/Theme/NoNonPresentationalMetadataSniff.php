<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * WordPress_Sniffs_Theme_NoNonPresentationalMetadataSniff.
 *
 * Warns for metadata so that a manual check can be performed.
 *
 * @link    https://make.wordpress.org/themes/handbook/review/required/theme-check-plugin/#admin-menu
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class WordPress_Sniffs_Theme_NoNonPresentationalMetadataSniff extends WordPress_Sniffs_Functions_FunctionRestrictionsSniff {

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
			'meta_data' => array(
				'type'      => 'warning',
				'message'   => 'Check that metadata is only used for presentation such as position, layout and color. Found %s.',
				'functions' => array(
					'add_metadata',
					'update_metadata',
					'add_post_meta',
					'update_post_meta',
					'add_user_meta',
					'update_user_meta',
					'add_comment_meta',
					'update_comment_meta',
				),
			),
		);
	}

} // End class.
