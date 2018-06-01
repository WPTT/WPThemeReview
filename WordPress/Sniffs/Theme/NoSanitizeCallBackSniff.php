<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPress\Sniffs\Theme;

use WordPress\Sniff;
use PHP_CodeSniffer_Tokens as Tokens;
use PHP_CodeSniffer_File as File;
/**
 * Check that sanitization is done correctly in the customizer.
 *
 * @link    https://make.wordpress.org/themes/handbook/review/required/#code
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class NoSanitizeCallbackSniff extends Sniff {
	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return array(
			T_STRING,
			T_EVAL,
		);
	}
	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param int $stackPtr  The position of the current token in the stack
	 *                       passed in $this->tokens.
	 *
	 * @return void
	 */
	public function process_token( $stackPtr ) {
		$token = $this->tokens[ $stackPtr ];
		// Exclude function definitions, static class methods, and namespaced calls.
		$prev  = $this->phpcsFile->findPrevious( T_WHITESPACE, ( $stackPtr - 1 ), null, true );
		$pprev = $this->phpcsFile->findPrevious( T_WHITESPACE, ( $prev - 1 ), null, true );
		if (
			T_STRING === $token['code']
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
			return;
		}
		if ( 'add_setting' !== $token['content'] ) {
			return;
		}
		$parameter_arg              = $this->get_function_call_parameter( $stackPtr, 2 );
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
}
