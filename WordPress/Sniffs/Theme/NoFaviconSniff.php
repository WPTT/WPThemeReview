<?php
/**
 * WordPress Coding Standard.
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @link     https://make.wordpress.org/core/handbook/best-practices/coding-standards/
 */

/**
 * WordPress_Sniffs_Theme_NoFaviconSniff.
 *
 * ERROR | Verify that no favicon / Apple icon / Windows tile / Android whatever they
 * call it is being added from the theme. The current check is in Theme-Check plugin is
 * favicon.php, but could definitely use some fine-tuning and improvement.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    khacoder
 */
class WordPress_Sniffs_Theme_NoFaviconSniff implements PHP_CodeSniffer_Sniff {

	/**
	 * A list of tokenizers this sniff supports.
	 *
	 * @var array
	 */
	public $supportedTokenizers = array(
		'PHP',
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

		$checks = array(
			'<link rel="shortcut icon"',
			"<link rel='shortcut icon'",
			'<link rel="icon"',
			"<link rel='icon'",
			'<link rel="apple-touch-icon"',
			"<link rel='apple-touch-icon'",
			'<link rel="apple-touch-icon-precomposed"',
			"<link rel='apple-touch-icon-precomposed'",
			'<meta name="msapplication-TileImage"',
			"<meta name='msapplication-TileImage'",
		);
		foreach ( $checks as $check ) {
			if ( false !== strpos( $token['content'], $check ) ) {
				$phpcsFile->addError( 'Possible Favicon found. Favicons are handled by the Site Icon setting in the customizer since version 4.3.' , $stackPtr, 'NoFavicon' );
			}
		}
	}//end process()
}
