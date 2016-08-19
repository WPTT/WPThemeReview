<?php
/**
 * WordPress Coding Standard.
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @link     https://make.wordpress.org/core/handbook/best-practices/coding-standards/
 */

/**
 * WordPress_Sniffs_Theme_RecommendedStyleHeadersSniff.
 *
 * WARNING: Check in style.css for the recommended headers, Author and Theme URI.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    khacoder
 */
class WordPress_Sniffs_Theme_RecommendedStyleHeadersSniff extends WordPress_AbstractThemeSniff {

	/**
	 * A list of tokenizers this sniff supports.
	 *
	 * @var array
	 */
	public $supportedTokenizers = array(
		'CSS',
	);

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return array(
			T_COMMENT,
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

		global $sniff_helper;

		$fileName = basename( $phpcsFile->getFileName() );

		if ( 'style.css' === $fileName ) {
			if ( '' === $sniff_helper['theme_data']['uri'] && false !== strpos( $token['content'], 'Theme URI' ) ) {
				$phpcsFile->addWarning( 'Theme URI in style.css is not required but is recommended.' , $stackPtr, 'RecommendedStyleHeader' );
			}
			if ( '' === $sniff_helper['theme_data']['author_uri']  && false !== strpos( $token['content'], 'Author URI' ) ) {
				$phpcsFile->addWarning( 'Author URI in style.css is not required but is recommended.' , $stackPtr, 'RecommendedStyleHeader' );
			}
		}
	}//end process()
}
