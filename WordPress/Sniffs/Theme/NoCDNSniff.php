<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Restricts the use of the CDN URLs.
 *
 * @link https://make.wordpress.org/themes/handbook/review/required/
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class WordPress_Sniffs_Theme_NoCDNSniff extends WordPress_AbstractFunctionParameterSniff {

	/**
	 * The group name for this group of functions.
	 *
	 * @since 0.xx.0
	 *
	 * @var string
	 */
	protected $group_name = 'wp_enqueue_style';

	/**
	 * Array of functions and parameters.
	 *
	 * @since 0.xx.0
	 *
	 * @var array
	 */
	protected $target_functions = array(
		'wp_enqueue_style' => array(
			'bootstrapcdn.com' => 'bootstrapcdn.com',
			'maxcdn.com'       => 'maxcdn.com',
			'jquery.com'       => 'jquery.com',
			'cdnjs.com'        => 'cdnjs.com',
			'googlecode.com'   => 'googlecode.com',
			),
		'wp_enqueue_script' => array(
			'bootstrapcdn.com' => 'bootstrapcdn.com',
			'maxcdn.com'       => 'maxcdn.com',
			'jquery.com'       => 'jquery.com',
			'cdnjs.com'        => 'cdnjs.com',
			'googlecode.com'   => 'googlecode.com',
			),
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

		if ( ! isset( $parameters[2] ) ) {
			return;
		}

		$matched_parameter = $this->strip_quotes( $parameters[2]['raw'] );

		foreach ( $this->target_functions[ $matched_content ] as $key => $value ) {
			if ( false !== strpos( $matched_parameter, $value ) ) {
				$this->phpcsFile->addError( 'Loading resources from %s is prohibited.', $stackPtr, $matched_parameter . ' Found', array( $matched_parameter ) );
			}
		}
	}
}
