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
 * Check if the file contains a shortened URL from the list of banned URL shortener services.
 *
 * @since 0.2.0
 */
class ShortenedURLsSniff implements Sniff {

	/**
	 * Error message template.
	 *
	 * @since 0.2.0
	 *
	 * @var string
	 */
	const ERROR_MSG = 'Shortened URLs are not allowed in the theme. Found: "%s".';

	/**
	 * Found used shortener in a file
	 *
	 * @since 0.2.0
	 *
	 * @var string
	 */
	protected $shortener;

	/**
	 * Supported Tokenizers
	 *
	 * @since 0.2.0
	 *
	 * @var array
	 */
	public $supportedTokenizers = array(
		'PHP',
		'CSS',
		'JS',
	);

	/**
	 * List of url shorteners.
	 *
	 * @since 0.2.0
	 *
	 * @var array
	 */
	protected $url_shorteners = [
		'bit.do',
		'bit.ly',
		'df.ly',
		'goo.gl',
		'is.gd',
		'lc.chat',
		'ow.ly',
		'polr.me',
		's2r.co',
		'soo.gd',
		'tiny.cc',
		'tinyurl.com',
	];

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @since 0.2.0
	 *
	 * @return array
	 */
	public function register() {
		return Tokens::$textStringTokens + array(
			T_COMMENT,
			T_DOC_COMMENT_STRING,
			T_DOC_COMMENT,
		);
	}

	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @since 0.2.0
	 *
	 * @param \PHP_CodeSniffer\Files\File $phpcsFile The PHP_CodeSniffer file where the
	 *                                               token was found.
	 * @param int                         $stackPtr  The position of the current token
	 *                                               in the stack.
	 *
	 * @return void
	 */
	public function process( File $phpcsFile, $stackPtr ) {
		$tokens  = $phpcsFile->getTokens();
		$content = $tokens[ $stackPtr ]['content'];

		if ( strpos( $content, '.' ) === false ) {
			return;
		}

		foreach ( $this->url_shorteners as $url_shortener ) {
			if ( strpos( $content, $url_shortener ) !== false ) {
				$phpcsFile->addError(
					self::ERROR_MSG,
					$stackPtr,
					'Found',
					array( $url_shortener )
				);
			}
		}
	}
}
