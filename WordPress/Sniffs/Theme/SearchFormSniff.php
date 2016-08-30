<?php
/**
 * WordPress Coding Standard.
 * SearchFormSniff
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @link     https://make.wordpress.org/core/handbook/best-practices/coding-standards/
 */

/**
 * WordPress_Sniffs_Theme_SearchFormSniff
 *
 * ERROR : check that no include calls to searchform.php are found, if they are,
 * recommend using get_search_form() instead.
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @author   khacoder
 */
class WordPress_Sniffs_Theme_SearchFormSniff implements PHP_CodeSniffer_Sniff
{
	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return array(
			T_STRING,
			T_CONSTANT_ENCAPSED_STRING,
		);
	}//end register()

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
		if ( false !== strpos( trim( $token['content'] . '\"\'' ), 'searchform.php' ) ) {
			$phpcsFile->addError( 'Please use get_search_form()instead of including searchform.php directly.', $stackPtr, 'SanitizeCallbackChecks' );
		}
	}//end process()
}
