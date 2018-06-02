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
use PHP_CodeSniffer_Tokens as Tokens;

/**
 * Check that sanitization is done correctly in the customizer.
 *
 * @link    https://make.wordpress.org/themes/handbook/review/required/#code
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class NoSanitizeCallbackSniff extends AbstractFunctionParameterSniff {

	/**
	 * The group name for this group of functions.
	 *
	 * @since 0.xx.0
	 *
	 * @var string
	 */
	protected $group_name = 'no_sanitize_callback';

	/**
	 * Array of functions to check.
	 *
	 * @since 0.xx.0
	 *
	 * @var array <string function name> => <int parameter position>
	 */
	protected $target_functions = array(
		'add_setting' => 2,
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
		$function_name = strtolower( $matched_content );
		$target_param  = $this->target_functions[ $function_name ];

		// Was the target parameter passed ?
		if ( ! isset( $parameters[ $target_param ] ) ) {
			return;
		}
		$parameter_arg              = $parameters[ $target_param ];
		$sanitize_callback_found    = false;
		$sanitize_js_callback_found = false;
		$sanitize_callback_key      = $parameter_arg['start'];
		while ( $sanitize_callback_key = $this->phpcsFile->findNext( array( T_CONSTANT_ENCAPSED_STRING ), $sanitize_callback_key + 1, $parameter_arg['end'] - 1, false ) ) {
			$name = trim( $this->tokens[ $sanitize_callback_key ]['content'], '\'\"' );
			if ( 'sanitize_callback' === $name ) {
				$sanitize_callback_found = true;
			}
			if ( 'sanitize_js_callback' === $name ) {
				$sanitize_js_callback_found = true;
			}
			if ( 'sanitize_callback' === $name || 'sanitize_js_callback' === $name ) {
				$sanitize_callback = $this->phpcsFile->findNext( array( T_CONSTANT_ENCAPSED_STRING ), $sanitize_callback_key + 1 );
				$value             = trim( $this->tokens[ $sanitize_callback ]['content'], '\'\"' );
				if ( empty( $value ) ) {
					$this->phpcsFile->addError(
						'The %s must not be empty.',
						$sanitize_callback,
						'SanitizeCallbackChecks',
						array( $name )
					);
				}
			}
			if ( false === $sanitize_js_callback_found || false === $sanitize_callback_found ) {
				$last = '';
				$last = $this->phpcsFile->findPrevious( array( T_CONSTANT_ENCAPSED_STRING ), $parameter_arg['end'] );
				if ( $last === $sanitize_callback_key ) {
					if ( false === $sanitize_js_callback_found && false === $sanitize_callback_found ) {
						$this->phpcsFile->addError( 'Neither sanitize_callback or sanitize_js_callback were found for this option.', $stackPtr, 'SanitizeCallbackChecks' );
					} elseif ( false === $sanitize_callback_found ) {
						// 'sanitize_callback' is required.
						$this->phpcsFile->addError( 'The sanitize_callback was not found for this option.', $stackPtr, 'SanitizeCallbackChecks' );
					}
					continue;
				}
			}
		}
	}

	/**
	 * Verify is the current token is a function call.
	 *
	 * @since 0.xx.0
	 *
	 * @param int $stackPtr The position of the current token in the stack.
	 *
	 * @return bool
	 */
	public function is_targetted_token( $stackPtr ) {

		// Exclude function definitions, static class methods, and namespaced calls.
		$prev  = $this->phpcsFile->findPrevious( T_WHITESPACE, ( $stackPtr - 1 ), null, true );
		$pprev = $this->phpcsFile->findPrevious( T_WHITESPACE, ( $prev - 1 ), null, true );
		if (
			T_STRING === $this->tokens[ $stackPtr ]['code']
			&&
			T_WHITESPACE !== $this->tokens[ $prev ]['code']
			&&
			// Skip sniffing if calling anything but class method.
			T_OBJECT_OPERATOR !== $this->tokens[ $prev ]['code']
			||
			// Skip namespaced functions, ie: \foo\bar() not \bar().
			(
				T_NS_SEPARATOR === $this->tokens[ $prev ]['code']
				&&
				T_WHITESPACE !== $this->tokens[ $pprev ]['code']
				&&
				T_STRING === $this->tokens[ $pprev ]['code']
			)
		) {
			return false;
		}

		return true;
	}
}
