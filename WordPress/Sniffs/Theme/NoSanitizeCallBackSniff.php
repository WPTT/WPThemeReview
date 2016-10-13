<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Check thatsanitization is done correctly in the customizer.
 *
 * @link    https://make.wordpress.org/themes/handbook/review/required/#code
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class WordPress_Sniffs_Theme_NoSanitizeCallbackSniff implements PHP_CodeSniffer_Sniff {

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return array(
			T_STRING,
			T_CONSTANT_ENCAPSED_STRING,
			T_VARIABLE,
			T_LNUMBER,
			T_SEMICOLON,
		);
	}

	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
	 * @param int                  $stackPtr  The position of the current token
	 *                                        in the stack passed in $tokens.
	 *
	 * @return void
	 */
	public function process( PHP_CodeSniffer_File $phpcsFile, $stackPtr ) {

		$tokens = $phpcsFile->getTokens();
		$token  = $tokens[ $stackPtr ];
		$types  = array( T_STRING, T_CONSTANT_ENCAPSED_STRING, T_VARIABLE, T_LNUMBER, T_SEMICOLON );

		if ( '$wp_customize' === $token['content'] ) {
			$nextStackPtr = $phpcsFile->findNext( $types , $stackPtr + 1 );
			if ( 'add_setting' === $tokens[ $nextStackPtr ]['content'] ) {
				$sanitize_callback_found = false;
				$sanitize_js_callback_found = false;
				$empty_callback = true;
				$empty_js_callback = true;
				while ( ';' !== $tokens[ $nextStackPtr ]['content'] ) {
					$nextStackPtr = $phpcsFile->findNext( $types , $nextStackPtr + 1 );
					if ( 'sanitize_callback' === trim( $tokens[ $nextStackPtr ]['content'], '\'\"' ) ) {
						$sanitize_callback_found = true;
						$nextnextStackPtr = $phpcsFile->findNext( $types , $nextStackPtr + 1 );
						if ( '' === trim( $tokens[ $nextnextStackPtr ]['content'], '\'\"' ) ) {
							$empty_callback = true;
						} else {
							$empty_callback = false;
						}
					}
					if ( 'sanitize_js_callback' === trim( $tokens[ $nextStackPtr ]['content'], '\'\"' ) ) {
						$sanitize_js_callback_found = true;
						$nextnextStackPtr = $phpcsFile->findNext( $types , $nextStackPtr + 1 );
						if ( '' === trim( $tokens[ $nextnextStackPtr ]['content'], '\'\"' ) ) {
							$empty_js_callback = true;
						} else {
							$empty_js_callback = false;
						}
					}
				}
				if ( false === $sanitize_callback_found && false === $sanitize_js_callback_found ) {
					$phpcsFile->addError( 'Neither sanitize_callback or sanitize_js_callback were found for this option.', $stackPtr, 'SanitizeCallbackChecks' );
				}
				if ( false !== $sanitize_callback_found && false !== $empty_callback && true === $sanitize_js_callback_found && true === $empty_js_callback ) {
					$phpcsFile->addError( 'Either sanitize_callback or sanitize_js_callback must not be empty.', $stackPtr, 'SanitizeCallbackChecks' );
				}
				if ( false === $sanitize_callback_found && false !== $sanitize_js_callback_found ) {
					$phpcsFile->addWarning( 'Found sanitize_js_callback but not sanitize_callback - is that intended?', $stackPtr, 'SanitizeCallbackChecks' );
				}
				if ( true === $sanitize_callback_found && true === $empty_callback && false === $empty_js_callback ) {
					$phpcsFile->addWarning( 'Found sanitize_js_callback not empty and sanitize_callback is empty - is that intended?', $stackPtr, 'SanitizeCallbackChecks' );
				}
			}
		}
	}
}
