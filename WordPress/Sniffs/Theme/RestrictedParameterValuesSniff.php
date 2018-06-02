<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPress\Sniffs\Theme;

use WordPress\AbstractFunctionParameterSniff;

/**
 * Check for usage of deprecated arguments in WP functions and provide alternative based on the parameter passed.
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class RestrictedParameterValuesSniff extends AbstractFunctionParameterSniff {

	/**
	 * The group name for this group of functions.
	 *
	 * @since 0.xx.0
	 *
	 * @var string
	 */
	protected $group_name = 'theme_restricted_parameter_values';

	/**
	 * Array of function, position, argument, and replacement function for restricted argument.
	 *
	 * @since 0.xx.0
	 *
	 * @var array Multi-dimentional array with parameter details.
	 *            @type string Function name. {
	 *                @type int target Parameter positions. {
	 *                    @type string Alternative.
	 *                }
	 *            }
	 */
	protected $target_functions = array(
		'get_bloginfo' => array(
			1 => array(
				'url' => array(
					'alt' => 'home_url()',
				),
				'wpurl' => array(
					'alt' => 'site_url()',
				),
				'rdf_url' => array(
					'alt' => "get_feed_link( 'rdf' )",
				),
				'rss_url' => array(
					'alt' => "get_feed_link( 'rss' )",
				),
				'atom_url' => array(
					'alt' => "get_feed_link( 'atom' )",
				),
				'comments_atom_url' => array(
					'alt' => "get_feed_link( 'comments_atom' )",
				),
				'comments_rss2_url' => array(
					'alt' => "get_feed_link( 'comments_rss2' )",
				),
				'stylesheet_directory' => array(
					'alt' => 'get_stylesheet_directory_uri()',
				),
				'template_directory' => array(
					'alt' => 'get_template_directory_uri()',
				),
				'template_url' => array(
					'alt' => 'get_template_directory_uri()',
				),
			),
		),
		'bloginfo' => array(
			1 => array(
				'url' => array(
					'alt' => 'home_url()',
				),
				'wpurl' => array(
					'alt' => 'site_url()',
				),
				'rdf_url' => array(
					'alt' => "get_feed_link( 'rdf' )",
				),
				'rss_url' => array(
					'alt' => "get_feed_link( 'rss' )",
				),
				'atom_url' => array(
					'alt' => "get_feed_link( 'atom' )",
				),
				'comments_atom_url' => array(
					'alt' => "get_feed_link( 'comments_atom' )",
				),
				'comments_rss2_url' => array(
					'alt' => "get_feed_link( 'comments_rss2' )",
				),
				'stylesheet_directory' => array(
					'alt' => 'get_stylesheet_directory_uri()',
				),
				'template_directory' => array(
					'alt' => 'get_template_directory_uri()',
				),
				'template_url' => array(
					'alt' => 'get_template_directory_uri()',
				),
			),
		),
		'get_option' => array(
			1 => array(
				'home' => array(
					'alt' => 'home_url()',
				),
				'site_url' => array(
					'alt' => 'site_url()',
				),
			),
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
		$paramCount = count( $parameters );
		foreach ( $this->target_functions[ $matched_content ] as $position => $parameter_args ) {
			if ( $position > $paramCount ) {
				break;
			}
			if ( ! isset( $parameters[ $position ] ) ) {
				continue;
			}
			$is_dynamic_parameter = $this->phpcsFile->findNext( array( T_CONSTANT_ENCAPSED_STRING, T_ARRAY, T_FALSE, T_TRUE, T_NULL, T_LNUMBER, T_WHITESPACE ), $parameters[ $position ]['start'], ( $parameters[ $position ]['end'] + 1 ), true, null, true );

			$matched_parameter = $this->strip_quotes( $parameters[ $position ]['raw'] );

			if ( ! $is_dynamic_parameter && ! isset( $this->target_functions[ $matched_content ][ $position ][ $matched_parameter ] ) ) {
				continue;
			}

			$message = 'The parameter [%s] at possition #%s of %s() is restricted.';
			$data    = array(
				$parameters[ $position ]['raw'],
				$position,
				$matched_content,
			);

			if ( isset( $parameter_args['alt'] ) ) {
				$message .= ' Use "%s" instead.';
				$data[]   = $parameter_args['alt'];
			}

			$this->phpcsFile->addError( $message, $stackPtr, $matched_content . 'Found', $data );
		}
	}

}
