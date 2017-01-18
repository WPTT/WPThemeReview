<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Check for use of iframe. Often used for malicious code.
 *
 * @link    https://make.wordpress.org/themes/handbook/review/required/#core-functionality-and-features
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class WordPress_Sniffs_Theme_DiscouragedIframeSniff implements PHP_CodeSniffer_Sniff {

	/**
	 * The regex to catch the blacklisted attributes.
	 *
	 * @var string
	 */
	protected $iframe_regex;

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		$this->iframe_regex = '/<(iframe)[^>]*>/';

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

		if ( preg_match( $this->iframe_regex, $token['content'] ) > 0 ) {
			$phpcsFile->addError( 'Usage of iframe is prohibited.' , $stackPtr, 'DiscouragedIframe' );
		}

	}

}
