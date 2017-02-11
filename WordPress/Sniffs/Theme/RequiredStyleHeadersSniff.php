<?php
/**
 * WordPress Coding Standard.
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @link     https://make.wordpress.org/core/handbook/best-practices/coding-standards/
 */

/**
 * WordPress_Sniffs_Theme_RequiredStyleHeadersSniff.
 *
 * ERROR | Check specifically against style.css whether the required headers are found.
 * See Theme-Check plugin - /checks/style_needed.php for the list.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    khacoder
 */
class WordPress_Sniffs_Theme_RequiredStyleHeadersSniff extends WordPress_AbstractThemeSniff {

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
			if ( '' === $sniff_helper['theme_data']['name'] && false !== strpos( $token['content'], 'Name' ) ) {
				$phpcsFile->addError( 'Theme Name is required in header of style.css.' , $stackPtr, 'RequiredStyleHeader' );
			}
			if ( '' === $sniff_helper['theme_data']['author'] && false !== strpos( $token['content'], 'Author:' ) ) {
				$phpcsFile->addError( 'Author is required in header of style.css.' , $stackPtr, 'RequiredStyleHeader' );
			}
			if ( '' === $sniff_helper['theme_data']['description'] && false !== strpos( $token['content'], 'Description' ) ) {
				$phpcsFile->addError( 'Description is required in header of style.css.' , $stackPtr, 'RequiredStyleHeader' );
			}
			if ( '' === $sniff_helper['theme_data']['version'] && false !== strpos( $token['content'], 'Version' ) ) {
				$phpcsFile->addError( 'Version is required in header of style.css.' , $stackPtr, 'RequiredStyleHeader' );
			}
			if ( '' === $sniff_helper['theme_data']['license'] && false !== strpos( $token['content'], 'License:' ) ) {
				$phpcsFile->addError( 'License is required in header of style.css.' , $stackPtr, 'RequiredStyleHeader' );
			}
			if ( '' === $sniff_helper['theme_data']['license_uri'] && false !== strpos( $token['content'], 'License URI' ) ) {
				$phpcsFile->addError( 'License URI is required in header of style.css and it should be a URI.' , $stackPtr, 'RequiredStyleHeader' );
			}
			if ( ! is_array( $sniff_helper['theme_data']['tags'] ) && false !== strpos( $token['content'], 'Tags' ) ) {
				$phpcsFile->addError( 'A tags list is required in header of style.css.' , $stackPtr, 'RequiredStyleHeader' );
			}
		}
	}//end process()
}
