<?php
/**
 * WPThemeReview Coding Standard.
 *
 * @package WPTRT\WPThemeReview
 * @link    https://github.com/WPTRT/WPThemeReview
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WPThemeReview\Sniffs\Privacy;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Detect the use of tracking code in a theme.
 *
 * @link https://make.wordpress.org/themes/handbook/review/required/#privacy
 *
 * @since 0.2.2
 */
class DisallowTrackingSniff implements Sniff {

    /**
     * Regex template
     *
     * Checks for Google search code in a theme.
     *
     * @since 0.2.2
	 *
	 * @var string
     */
    const GOOGLE_SEARCH_CODE = '/cx=[0-9]{21}:[a-z0-9]{10}/';

    /**
     * Regex template
     *
     * Checks for Google advertisement code in a theme.
     *
     * @since 0.2.2
	 *
	 * @var string
     */
    const GOOGLE_AD_CODE = '/pub-[0-9]{16}/';

	/**
	 * Supported Tokenizers.
	 *
	 * @since 0.2.2
	 *
	 * @var array
	 */
	public $supportedTokenizers = [
		'PHP',
		'CSS',
		'JS',
	];

    /**
     * A list of blacklisted ad provider URLs
     *
     * @since 0.2.2
     *
     * @var array
     */
    private $ad_providers = [
        'https://www.google-analytics.com/analytics.js',
        'https://www.facebook.com/tr',
    ];

    /**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @since 0.2.2
	 *
	 * @return array
	 */
	public function register() {
		return Tokens::$textStringTokens + [
			T_COMMENT,
			T_INLINE_HTML,
		];
	}

/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @since 0.2.2
	 *
	 * @param File $phpcsFile The PHP_CodeSniffer file where the
	 *                                               token was found.
	 * @param int                         $stackPtr  The position of the current token
	 *                                               in the stack.
	 *
	 * @return void
	 */
	public function process( File $phpcsFile, $stackPtr ) {
		$tokens  = $phpcsFile->getTokens();
		error_log( print_r( $tokens, true ) );
		$content = $tokens[ $stackPtr ]['content'];

		if ( stripos( $content, '.' ) === false ) {
			return;
		}

//		if ( preg_match_all( $this->regex, $content, $matches ) > 0 ) {
//			foreach ( $matches[0] as $matched_url ) {
//				$phpcsFile->addError(
//					self::ERROR_MSG,
//					$stackPtr,
//					'Found',
//					[ $matched_url ]
//				);
//			}
//		}
	}
}