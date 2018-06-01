<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPress\Sniffs\Theme;

use WordPress\Sniff;
use PHP_CodeSniffer_Tokens as Tokens;

/**
 * Check for use of iframe. Often used for malicious code.
 *
 * @link    https://make.wordpress.org/themes/handbook/review/required/#core-functionality-and-features
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class ForbiddenIframeSniff extends Sniff {

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

		return Tokens::$textStringTokens;
	}

	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param int $stackPtr The position of the current token in the stack.
	 *
	 * @return void
	 */
	public function process_token( $stackPtr ) {
		$token  = $this->tokens[ $stackPtr ];

		if ( preg_match( $this->iframe_regex, $token['content'] ) > 0 ) {
			$this->phpcsFile->addError( 'Usage of iframe is prohibited.' , $stackPtr, 'DiscouragedIframe' );
		}
	}

}
