<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * User capabilities should be used not roles.
 *
 * @link    https://make.wordpress.org/themes/handbook/review/required/#options-and-settings
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class WordPress_Sniffs_Theme_UseCapabilitiesNotRolesSniff extends WordPress_AbstractFunctionParameterSniff {

	/**
	 * The group name for this group of functions.
	 *
	 * @since 0.xx.0
	 *
	 * @var string
	 */
	protected $group_name = 'caps_not_roles';

	/**
	 * Array of functions that accept roles and capabilities as an agrument.
	 *
	 * The number represents the position in the function call
	 * passed variables, here the capability is to be listed.
	 * The list is sorted alphabetically.
	 *
	 * @since 0.xx.0
	 *
	 * @var array Function name with parameter position.
	 */
	protected $target_functions = array(
		'add_comments_page'         => 3,
		'add_dashboard_page'        => 3,
		'add_management_page'       => 3,
		'add_media_page'            => 3,
		'add_menu_page'             => 3,
		'add_object_page'           => 3,
		'add_options_page'          => 3,
		'add_pages_page'            => 3,
		'add_plugins_page'          => 3,
		'add_posts_page'            => 3,
		'add_submenu_page'          => 4,
		'add_theme_page'            => 3,
		'add_users_page'            => 3,
		'add_utility_page'          => 3,
		'author_can'                => 2,
		'current_user_can'          => 1,
		'current_user_can_for_blog' => 2,
		'user_can'                  => 2,

	);

	/**
	 * Array of core capabilities.
	 *
	 * @link https://github.com/WordPress/wordpress-develop/blob/master/tests/phpunit/tests/user/capabilities.php
	 *
	 * @since 0.xx.0
	 *
	 * @var array Capabilities available in core.
	 */
	protected $core_capabilities = array(
		'unfiltered_html'        => true,
		'activate_plugins'       => true,
		'create_users'           => true,
		'delete_plugins'         => true,
		'delete_themes'          => true,
		'delete_users'           => true,
		'edit_files'             => true,
		'edit_plugins'           => true,
		'edit_themes'            => true,
		'edit_users'             => true,
		'install_plugins'        => true,
		'install_themes'         => true,
		'update_core'            => true,
		'update_plugins'         => true,
		'update_themes'          => true,
		'edit_theme_options'     => true,
		'export'                 => true,
		'import'                 => true,
		'list_users'             => true,
		'manage_options'         => true,
		'promote_users'          => true,
		'remove_users'           => true,
		'switch_themes'          => true,
		'edit_dashboard'         => true,
		'moderate_comments'      => true,
		'manage_categories'      => true,
		'edit_others_posts'      => true,
		'edit_pages'             => true,
		'edit_others_pages'      => true,
		'edit_published_pages'   => true,
		'publish_pages'          => true,
		'delete_pages'           => true,
		'delete_others_pages'    => true,
		'delete_published_pages' => true,
		'delete_others_posts'    => true,
		'delete_private_posts'   => true,
		'edit_private_posts'     => true,
		'read_private_posts'     => true,
		'delete_private_pages'   => true,
		'edit_private_pages'     => true,
		'read_private_pages'     => true,
		'edit_published_posts'   => true,
		'upload_files'           => true,
		'publish_posts'          => true,
		'delete_published_posts' => true,
		'edit_posts'             => true,
		'delete_posts'           => true,
		'read'                   => true,
		'level_10'               => true,
		'level_9'                => true,
		'level_8'                => true,
		'level_7'                => true,
		'level_6'                => true,
		'level_5'                => true,
		'level_4'                => true,
		'level_3'                => true,
		'level_2'                => true,
		'level_1'                => true,
		'level_0'                => true,
	);

	/**
	 * Array of core roles.
	 *
	 * @since 0.xx.0
	 *
	 * @var array Role available in core.
	 */
	protected $core_roles = array(
		'super_admin'   => true,
		'administrator' => true,
		'editor'        => true,
		'author'        => true,
		'contributor'   => true,
		'subscriber'    => true,
	);

	/**
	 * Process the parameters of a matched function.
	 *
	 * @since 0.xx.0
	 *
	 * @param int    $stackPtr        The position of the current token in the stack.
	 * @param array  $group_name      The name of the group which was matched.
	 * @param string $matched_content The token content (function name) which was matched.
	 * @param array  $parameters      Array with information about the parameters.
	 *
	 * @return void
	 */
	public function process_parameters( $stackPtr, $group_name, $matched_content, $parameters ) {

		$position = $this->target_functions[ $matched_content ];
		if ( ! isset( $parameters[ $position ] ) ) {
			return;
		}

		$matched_parameter = $this->strip_quotes( $parameters[ $position ]['raw'] );
		if ( isset( $this->core_capabilities[ $matched_parameter ] ) ) {
			return;
		}

		if ( isset( $this->core_roles[ $matched_parameter ] ) ) {
			$this->phpcsFile->addError(
				'Capabilities should be used instead of roles. Found "%s" in function "%s"',
				$stackPtr,
				'RoleFound',
				array(
					$matched_parameter,
					$matched_content,
				)
			);
		} else {
			$this->phpcsFile->addWarning(
				'"%s" is an unknown role or capability. Check the "%s()" function call to ensure it is a capability and not a role.',
				$stackPtr,
				'UnknownCapabilityFound',
				array(
					$matched_parameter,
					$matched_content
				)
			);
		}

	}

}
