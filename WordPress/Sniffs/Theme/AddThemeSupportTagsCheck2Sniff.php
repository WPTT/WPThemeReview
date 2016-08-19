<?php
/**
 * WordPress Coding Standard.
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @link     https://make.wordpress.org/core/handbook/best-practices/coding-standards/
 */

/**
 * WordPress_Sniffs_Theme_ThemeSupportTagMatch2Sniff.
 *
 * Verify that an add_theme_support() call is made for any feature the
 * theme has been tagged with from the following list: custom-background,
 * custom-header, custom-menu, featured-images/post-thumbnails, post-formats,
 * custom-logo.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    khacoder
 */
class WordPress_Sniffs_Theme_AddThemeSupportTagsCheck2Sniff extends WordPress_AbstractThemeSniff {

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

		if ( null === $sniff_helper['theme_supports'] ) {
			return count( $tokens ) + 1;
		} else {
			$tags_supported = $sniff_helper['theme_supports'];
		}

		$fileName = basename( $phpcsFile->getFileName() );

		if ( 'style.css' === $fileName ) {
			if ( strpos( $token['content'] , 'Tags' ) !== false ) {
				foreach ( $themetags as $tag ) {
					if ( isset( $tags_supported[ $tag ] ) && true !== $tags_supported[ $tag ] ) {
						$phpcsFile->addError( $tag . ' exists in the style.css tags list but it appears this feature is not supported.' , $stackPtr, 'TagAddThemeSupport' );
					}
				}
				return count( $tokens ) + 1;
			}
		}
	}//end process()
}
