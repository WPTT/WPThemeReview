<?php
/**
 * WordPress Coding Standard.
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @link     https://make.wordpress.org/core/handbook/best-practices/coding-standards/
 */

/**
 * WordPress_Sniffs_Theme_AccessibilityTagCheckSniff.
 *
 * Check if the accessibility tag is used in the style.css file header tag list and add a warning that an accessibility review is needed.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    khacoder
 */
class WordPress_Sniffs_Theme_AccessibilityTagCheckSniff extends WordPress_AbstractThemeSniff {

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
		// get tags list from style.css.
		global $sniff_helper;
		$themetags = array();
		$themetags = $sniff_helper['theme_data']['tags'];
		if ( ! is_array( $themetags ) ) {
			return;
		}

		$tokens = $phpcsFile->getTokens();
		$token  = $tokens[ $stackPtr ];

		$fileName = basename( $phpcsFile->getFileName() );

		if ( 'style.css' === $fileName ) {
			if ( strpos( $token['content'] , 'Tags' ) !== false ) {
				if ( false !== in_array( 'accessibility-ready' , $themetags , true ) ) {
					$phpcsFile->addWarning( 'Please remove the accessibility-ready tag from the style.css file unless you have designed your theme with these features. A second review is done for accessiblity-ready themes.' , $stackPtr, 'AccessibilityTagReviewReqd' );
				}
				return count( $tokens ) + 1;
			}
		}
	}//end process()
}
