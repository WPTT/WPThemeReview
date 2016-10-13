<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Check for hardcoded favicons instead of using core implementation.
 *
 * @link    https://make.wordpress.org/themes/handbook/review/required/#core-functionality-and-features
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
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
		$tokens   = PHP_CodeSniffer_Tokens::$stringTokens;
		$tokens[] = T_INLINE_HTML;
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

		$favicon_links = array(
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
		foreach ( $favicon_links as $check ) {
			if ( false !== strpos( $token['content'], $check ) ) {
				$phpcsFile->addError( 'Code for Favicon found. Favicons are handled by the Site Icon setting in the customizer since version 4.3.' , $stackPtr, 'NoFavicon' );
			}
		}
	}

}
