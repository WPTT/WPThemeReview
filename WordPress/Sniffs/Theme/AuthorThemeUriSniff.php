<?php
/**
 * WordPress Coding Standard.
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @link     https://make.wordpress.org/core/handbook/best-practices/coding-standards/
 */

/**
 * WordPress_Sniffs_Theme_AuthorThemeUriSniff.
 *
 * ERROR : Check in style.css for the Author URI and Theme URI and verify that these are not the same.
 * WARNING : Issue a warning id Author URI or Theme URI are not present.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    khacoder
 */
class WordPress_Sniffs_Theme_AuthorThemeUriSniff extends WordPress_AbstractThemeSniff {

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
	 * @return count($tokens) + 1;
	 */
	public function process( PHP_CodeSniffer_File $phpcsFile, $stackPtr ) {
		$tokens = $phpcsFile->getTokens();
		$token  = $tokens[ $stackPtr ];

		// Get sniff helper data.
		$sniff_helper = $this->get_sniff_helper();

		$author_uri = $sniff_helper['theme_data']['author_uri'];
		$author_uri = trim( $author_uri , '/\\' );

		$theme_uri = $sniff_helper['theme_data']['uri'];
		$theme_uri = trim( $theme_uri , '/\\' );

		$fileName = basename( $phpcsFile->getFileName() );

		if ( 'style.css' === $fileName ) {
			if ( '' !== $author_uri || '' !== $theme_uri ) {
					if ( $author_uri === $theme_uri ) {
					$phpcsFile->addError( 'Author URI can not be the same as Theme URI' , 0, 'AccessibilityTagReviewReqd' );
				}
			}
			
			if ( '' === $sniff_helper['theme_data']['uri'] ) {
				$phpcsFile->addWarning( 'Theme URI in style.css is not required but is recommended.' , 0, 'RecommendedStyleHeader' );
				$theme_uri_missing_warning = true;
			}
			if ( '' === $sniff_helper['theme_data']['author_uri'] ) {
				$phpcsFile->addWarning( 'Author URI in style.css is not required but is recommended.' , 0, 'RecommendedStyleHeader' );
			}
			return count( $tokens ) + 1;
		}
	}//end process()
}
