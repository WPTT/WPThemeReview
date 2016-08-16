<?php
/**
 * WordPress Coding Standard.
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @link     https://make.wordpress.org/core/handbook/best-practices/coding-standards/
 */

/**
 * WordPress_Sniffs_Theme_NoHardCodedUrlsSniff Class Doc Comment
 *
 * WARNING Verify that no hard-coded URLs are found. Manual verification necessary.
 * An exception is made for the Author URI and (Theme) URI as set in the style.css header
 * as well as links to wordpress.org. Links in the text of PHP/JS comments should be
 * excluded from this check.
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @author   khacoder
 */
class WordPress_Sniffs_Theme_NoHardCodedUrlsSniff extends WordPress_AbstractThemeSniff {
	/**
	 * A list of tokenizers this sniff supports.
	 *
	 * @var array
	 */
	public $supportedTokenizers = array(
		'PHP',
		'JS',
		'CSS',
	);
	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return array(
			T_STRING,
			T_CONSTANT_ENCAPSED_STRING,
			T_INLINE_HTML,
			T_URL,
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

		// get tags list from style.css
		global $sniff_helper;

		$author_uri = $sniff_helper['theme_data']['author_uri'];

		$theme_uri = $sniff_helper['theme_data']['uri'];

		/** If the token contains this string, exclude it.
		 * ToDo - How can we account for an allowed footer link?
		 * If we require the footer link to be an Author URI or Theme URI it's possible.
		 */
		$allowed_strings = array(
				'gmpg.org',
				'wordpress.org',
				'wordpress.com',
				'schema.org',
				'fonts.googleapis',
				'cdn',// added to prevent duplication CDN sniff catches this.
		);
		// regex borrowed from themecheck (borrowed from TAC), modified for url only.
		if ( preg_match_all( '#(?:(?:http|https|ftp):)?//([[:alnum:]\-\.])+(\\.)([[:alnum:]]){2,4}([[:blank:][:alnum:]\/\+\=\%\&\_\\\.\~\?\-]*)#' , $token['content'], $matches, PREG_SET_ORDER ) ) {
			foreach ( $matches as $match ) {
				$add_warning_flag = true;
				foreach ( $allowed_strings as $string ) {
					if ( strpos( $match[0], $string ) ) {
						$add_warning_flag = false;
					}
				}
				if ( $match[0] === $author_uri ) {
					$add_warning_flag = false;
				}
				if ( $match[0] === $theme_uri ) {
					$add_warning_flag = false;
				}
				if ( true === $add_warning_flag ) {
					$phpcsFile->addWarning( 'Hardcoded URL found. Is this url acceptable? ' . $match[0], $stackPtr, 'HardCodedUrlFound' );
				}
			}
		}
	}//end process()
}
