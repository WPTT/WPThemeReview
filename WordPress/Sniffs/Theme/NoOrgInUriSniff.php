<?php
/**
 * WordPress Coding Standard.
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @link     https://make.wordpress.org/core/handbook/best-practices/coding-standards/
 */

/**
 * WordPress_Sniffs_Theme_WordPress_Sniffs_Theme_NoOrgInUriSniff.
 *
 * Error : Verify in style.css that the Theme URI does not point to wordpress.org
 * (with predefined list of themes which are exempt and live under the
 * wordpressdotorg user or have a check based on Author name.
 * We allow .org user profiles as Author URI, so only check the Theme URI.
 * We also allow WordPress.com links.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    khacoder
 */
class WordPress_Sniffs_Theme_NoOrgInUriSniff extends WordPress_AbstractThemeSniff {

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
		global $sniff_helper;

		$tokens = $phpcsFile->getTokens();
		$token  = $tokens[ $stackPtr ];

		$fileName = basename( $phpcsFile->getFileName() );

		if ( 'style.css' === $fileName ) {
			global $sniff_helper;

			$fileName = basename( $phpcsFile->getFileName() );
			
			$theme_uri = $sniff_helper['theme_data']['uri'];
			$theme_author = $sniff_helper['theme_data']['author'];

			if ( 'style.css' === $fileName ) {
				if ( '' !== $theme_uri && false !== strpos( $token['content'], 'Theme URI' ) ) {
					if ( false !== strpos( strtolower( $theme_uri ), 'wordpress.org' ) && 'the wordpress team' !== strtolower( $theme_author )
					|| false !== strpos( strtolower( $theme_uri ), 'w.org' ) && 'the wordpress team' !== strtolower( $theme_author ) ) {
						$phpcsFile->addError( 'Using a WordPress.org Theme URI is reserved for official themes.' , $stackPtr, 'NoOrgInThemeUri' );
					}
				}
			}
		}
	}//end process()
}
