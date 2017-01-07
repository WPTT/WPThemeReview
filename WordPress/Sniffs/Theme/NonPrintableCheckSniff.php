<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Restricts the use of non-printable characters.
 *
 * @link    https://make.wordpress.org/themes/handbook/review/required/theme-check-plugin/#info
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class WordPress_Sniffs_Theme_NonPrintableCheckSniff extends WordPress_Sniff {

	/**
	 * A list of tokenizers this sniff supports.
	 *
	 * @var array
	 */
	public $supportedTokenizers = array(
		'PHP',
		'CSS',
		'JS',
	);

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return array_merge(
			PHP_CodeSniffer_Tokens::$emptyTokens,
			PHP_CodeSniffer_Tokens::$heredocTokens,
			PHP_CodeSniffer_Tokens::$stringTokens,
			array(
				T_STRING,
				T_INLINE_HTML,
				T_BAD_CHARACTER,
		));

	}

	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param PHP_CodeSniffer_File $phpcsFile   The file being scanned.
	 * @param int                  $stackPtr    The position of the current token in
	 *                                          the stack passed in $tokens.
	 *
	 * @return void
	 */
	public function process( PHP_CodeSniffer_File $phpcsFile, $stackPtr ) {
		$tokens   = $phpcsFile->getTokens();
		$token    = $tokens[ $stackPtr ];
		if ( preg_match( '/[\x00-\x08\x0B-\x0C\x0E-\x1F\x80-\xFF]/', $token['content'], $matches ) ) {
			$phpcsFile->addError( 'Non-printable characters were found in the file. You may want to check this file for errors.', $stackPtr, 'NonPrintableCheck' );
		}

	}

} // End class.
