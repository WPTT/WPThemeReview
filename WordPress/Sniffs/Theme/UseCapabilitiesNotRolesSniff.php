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
	 * Array of functions with position.
	 *
	 * The number represents the position in the function call
	 * passed variables, here the capability is to be listed.
	 *
	 * @since 0.xx.0
	 *
	 * @var array Function name with parameter position.
	 */
	protected $target_functions = array(
		'add_dashboard_page'        => 3,
		'add_posts_page'            => 3,
		'add_media_page'            => 3,
		'add_pages_page'            => 3,
		'add_comments_page'         => 3,
		'add_theme_page'            => 3,
		'add_plugins_page'          => 3,
		'add_users_page'            => 3,
		'add_management_page'       => 3,
		'add_options_page'          => 3,
		'add_menu_page'             => 3,
		'add_utility_page'          => 3,
		'add_submenu_page'          => 4,
		'current_user_can'          => 1,
		'author_can'                => 2,
		'current_user_can_for_blog' => 2,
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
	 * Array of core capabilities.
	 *
	 * @since 0.xx.0
	 *
	 * @var array Capabilities available in core.
	 */
	protected $core_capabilities = array(
		'create_sites'           => true,
		'delete_sites'           => true,
		'manage_network'         => true,
		'manage_sites'           => true,
		'manage_network_users'   => true,
		'manage_network_plugins' => true,
		'manage_network_themes'  => true,
		'manage_network_options' => true,
		'create_sites'           => true,
		'delete_sites'           => true,
		'manage_network'         => true,
		'manage_sites'           => true,
		'manage_network_users'   => true,
		'manage_network_plugins' => true,
		'manage_network_themes'  => true,
		'manage_network_options' => true,
		'activate_plugins'       => true,
		'delete_others_pages'    => true,
		'delete_others_posts'    => true,
		'delete_pages'           => true,
		'delete_posts'           => true,
		'delete_private_pages'   => true,
		'delete_private_posts'   => true,
		'delete_published_pages' => true,
		'delete_published_posts' => true,
		'edit_dashboard'         => true,
		'edit_others_pages'      => true,
		'edit_others_posts'      => true,
		'edit_pages'             => true,
		'edit_posts'             => true,
		'edit_private_pages'     => true,
		'edit_private_posts'     => true,
		'edit_published_pages'   => true,
		'edit_published_posts'   => true,
		'edit_theme_options'     => true,
		'export'                 => true,
		'import'                 => true,
		'list_users'             => true,
		'manage_categories'      => true,
		'manage_links'           => true,
		'manage_options'         => true,
		'moderate_comments'      => true,
		'promote_users'          => true,
		'publish_pages'          => true,
		'publish_posts'          => true,
		'read_private_pages'     => true,
		'read_private_posts'     => true,
		'read'                   => true,
		'remove_users'           => true,
		'switch_themes'          => true,
		'upload_files'           => true,
		'customize'              => true,
		'delete_site'            => true,
		'update_core'            => true,
		'update_plugins'         => true,
		'update_themes'          => true,
		'install_plugins'        => true,
		'install_themes'         => true,
		'upload_plugins'         => true,
		'upload_themes'          => true,
		'delete_themes'          => true,
		'delete_plugins'         => true,
		'edit_plugins'           => true,
		'edit_themes'            => true,
		'edit_files'             => true,
		'edit_users'             => true,
		'create_users'           => true,
		'delete_users'           => true,
		'unfiltered_html'        => true,
		'delete_others_pages'    => true,
		'delete_others_posts'    => true,
		'delete_pages'           => true,
		'delete_posts'           => true,
		'delete_private_pages'   => true,
		'delete_private_posts'   => true,
		'delete_published_pages' => true,
		'delete_published_posts' => true,
		'edit_others_pages'      => true,
		'edit_others_posts'      => true,
		'edit_pages'             => true,
		'edit_posts'             => true,
		'edit_private_pages'     => true,
		'edit_private_posts'     => true,
		'edit_published_pages'   => true,
		'edit_published_posts'   => true,
		'manage_categories'      => true,
		'manage_links'           => true,
		'moderate_comments'      => true,
		'publish_pages'          => true,
		'publish_posts'          => true,
		'read'                   => true,
		'read_private_pages'     => true,
		'read_private_posts'     => true,
		'upload_files'           => true,
		'delete_posts'           => true,
		'delete_published_posts' => true,
		'edit_posts'             => true,
		'edit_published_posts'   => true,
		'publish_posts'          => true,
		'read'                   => true,
		'upload_files'           => true,
		'delete_posts'           => true,
		'edit_posts'             => true,
		'read'                   => true,
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
				'Use capabilities and not roles in %s().',
				$stackPtr,
				'RoleFound',
				array( $matched_content )
			);
		} else {
			$this->phpcsFile->addWarning(
				'The parameter %s is an unknown role or capability. Check %s() to ensure it is a capability and not a role.',
				$stackPtr,
				'PossibleRoleFound',
				array( $matched_parameter, $matched_content )
			);
		}

	}

}
