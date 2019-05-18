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
 * Check if the file contains a URL shortener.
 *
 * @since 0.2.0
 */
class NoUrlShortenersSniff implements Sniff {

	/**
	 * Error message template.
	 *
	 * @var string
	 */
	const ERROR_MSG = 'No URL shorteners should used in the theme. Found: "%s".';

	/**
	 * Found used shortener in a file
	 *
	 * @var string
	 */
	protected $shortener;

	/**
	 * List of url shorteners.
	 *
	 * @since 0.2.0
	 *
	 * @var array
	 */
	protected $url_shorteners = [
		'goo.gl',
		'bitly.com',
		'polrproject.org',
		'www.rebrandly.com',
		'tinyurl.com',
		'hootsuite.com/pages/owl',
		'is.gd',
		'buffer.com',
		'df.ly',
		'bit.do',
	];

	/**
	 * Supported Tokenizers
	 *
	 * @var array
	 */
	public $supportedTokenizers = array(
		'PHP',
		'CSS',
		'JS',
	);

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return array(
			\T_CONSTANT_ENCAPSED_STRING,
			\T_DOUBLE_QUOTED_STRING,
			\T_INLINE_HTML,
			\T_HEREDOC,
			\T_NOWDOC,
			\T_COMMENT,
			\T_DOC_COMMENT,
			\T_DOC_COMMENT_STAR,
			\T_DOC_COMMENT_WHITESPACE,
			\T_DOC_COMMENT_TAG,
			\T_DOC_COMMENT_OPEN_TAG,
			\T_DOC_COMMENT_CLOSE_TAG,
			\T_DOC_COMMENT_STRING,
		);
	}

	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param \PHP_CodeSniffer\Files\File $phpcsFile The PHP_CodeSniffer file where the
	 *                                               token was found.
	 * @param int                         $stackPtr  The position of the current token
	 *                                               in the stack.
	 *
	 * @return void|int Optionally returns an integer stack pointer or void to continue
	 *                  normal file processing.
	 */
	public function process( File $phpcsFile, $stackPtr ) {
		$tokens  = $phpcsFile->getTokens();
		$content = $tokens[ $stackPtr ]['content'];

		foreach ( $this->url_shorteners as $url_shortener ) {
			if ( strpos( $content, $url_shortener ) !== false ) {
				$phpcsFile->addError(
					self::ERROR_MSG,
					$stackPtr,
					'URLShorternerFound',
					array( $url_shortener )
				);
			}
		}
	}
}
