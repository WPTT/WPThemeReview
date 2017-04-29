<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * WordPress_Sniffs_Theme_NoAdvertisingOrTrackingSniff
 *
 * Forbids Google search codes and Google advertising codes.
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class WordPress_Sniffs_Theme_NoAdvertisingOrTrackingSniff implements PHP_CodeSniffer_Sniff {

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		$tokens   = PHP_CodeSniffer_Tokens::$stringTokens;
		$tokens[] = T_INLINE_HTML;
		$tokens[] = T_COMMENT;
		return $tokens;
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
		$content = trim( strtolower( $token['content'] ) );
		$content = str_replace( array( '"', "'", " " ), '', $content );

		if ( preg_match( '/cx=[0-9]{21}:[a-z0-9]{10}/', $content ) > 0 ) {
			$phpcsFile->addError( 'Google search code detected', $stackPtr, 'GoogleSearchFound' );
		}

		if ( preg_match( '/pub-[0-9]{16}/', $content ) > 0 ) {
			$phpcsFile->addError( 'Google advertising code detected', $stackPtr, 'GoogleAdFound' );
		}

	} // End process().

} // End class.
