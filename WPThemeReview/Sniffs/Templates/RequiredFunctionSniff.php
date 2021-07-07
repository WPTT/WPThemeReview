<?php
/**
 * WPThemeReview Coding Standard.
 *
 * @package WPTRT\WPThemeReview
 * @link    https://github.com/WPTRT/WPThemeReview
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WPThemeReview\Sniffs\Templates;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Ensures functions are called within HTML tags.
 *
 * Ex: <body <?php body_class(); ?>>
 *
 * @link  https://make.wordpress.org/themes/handbook/review/required/#templates
 *
 * @since 0.2.0
 */
class RequiredFunctionSniff implements Sniff {

	/**
	 * Sniff Settings
	 *
	 * @var array
	 */
	public $tagsConfig = array(
		'body' => array(
			'function'  => 'body_class',
			'attribute' => 'class',
		),
		'html' => array(
			'function'  => 'language_attributes',
			'attribute' => 'lang',
		),
	);

	/**
	 * Supported Tokenizers
	 *
	 * Currently this sniff is only useful in PHP as the required
	 * functions to call are done in PHP. In testing various
	 * themes - some had inline comments including `<html>`, and
	 * were tokenized as T_INLINE_HTML throwing some false positives.
	 *
	 * @var array
	 */
	public $supportedTokenizers = array( 'PHP' );

	/**
	 * Tag being searched.
	 *
	 * @var array
	 */
	protected $tag;

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return Tokens::$textStringTokens;
	}

	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param \PHP_CodeSniffer\Files\File $phpcsFile The PHP_CodeSniffer file where the
	 *                                               token was found.
	 * @param int                         $stackPtr  The position of the current token
	 *                                               in the stack.
	 *
	 * @return void
	 */
	public function process( File $phpcsFile, $stackPtr ) {

		$tokens   = $phpcsFile->getTokens();
		$content  = $this->clean_str( $tokens[ $stackPtr ]['content'] );
		$filename = $phpcsFile->getFileName();

		// Set to false if it is the first time this sniff is run on a file.
		if ( ! isset( $this->tag[ $filename ] ) ) {
			$this->tag[ $filename ] = false;
		}

		// Skip on empty.
		if ( '' === $content ) {
			return;
		}

		// Set tag class property.
		foreach ( $this->tagsConfig as $tag => $settings ) {

			// HTML case should be insensitive.
			if ( false !== stripos( $content, '<' . $tag ) ) {
				$this->tag[ $filename ]        = $this->tagsConfig[ $tag ];
				$this->tag[ $filename ]['tag'] = $tag;
				break;
			}
		}

		// Skip if not a tag.
		if ( false === $this->tag[ $filename ] ) {
			return;
		}

		// Set vars used for reference.
		$tagName        = $this->tag[ $filename ]['tag'];
		$tagFn          = $this->tag[ $filename ]['function'];
		$tagAttr        = $this->tag[ $filename ]['attribute'];
		$pascal         = str_replace( ' ', '', ucwords( str_replace( '_', ' ', $tagFn ) ) );
		$nextPtr        = $stackPtr;
		$foundFunction  = false;
		$foundAttribute = false;
		$foundEnd       = false;

		do {
			$nextPtrContent = $this->clean_str( $tokens[ $nextPtr ]['content'] );
			$nextPtrCode    = $tokens[ $nextPtr ]['code'];

			// Check for attribute not allowed.
			if (
				false === $foundAttribute &&
				isset( Tokens::$textStringTokens[ $nextPtrCode ] ) &&
				false !== stripos( $nextPtrContent, $tagAttr . '=' )
			) {
				$foundAttribute = true;
			}

			// Check for required function call.
			if (
				false === $foundFunction &&
				isset( Tokens::$functionNameTokens[ $nextPtrCode ] ) &&
				false !== strpos( $nextPtrContent, $tagFn )
			) {

				// Check next non-whitespace token for opening parens.
				$next = $phpcsFile->findNext( Tokens::$emptyTokens, ( $nextPtr + 1 ), null, true );

				if ( ! $next || ! isset( $tokens[ $next ] ) ) {
					break; // Nothing left.
				}

				// Verify function( $param = 'optional' ) type.
				if ( 'PHPCS_T_OPEN_PARENTHESIS' === $tokens[ $next ]['code'] ) {

					// Skip over contents to closing parens in stack.
					if ( isset( $tokens[ $next ]['parenthesis_closer'] ) ) {
						$nextPtr       = $tokens[ $next ]['parenthesis_closer'];
						$foundFunction = true;
					}
				}

				continue;
			}

			// Check for searched tag matched closing bracket.
			if (
				isset( Tokens::$textStringTokens[ $nextPtrCode ] ) &&
				'>' === substr( $nextPtrContent, -1 )
			) {
				$this->tag[ $filename ] = false;
				$foundEnd               = true;
				break;
			}

			// Increment stack to next non-whitespace token.
			$next = $phpcsFile->findNext( Tokens::$emptyTokens, ( $nextPtr + 1 ), null, true );

			if ( ! $next || ! isset( $tokens[ $next ] ) ) {
				break; // Short circuit loop as there's not anything left.
			}

			$nextPtr = $next;

		} while ( false === $foundEnd ); // Loop until matched closing bracket is found for searched tag.

		// Required function not found.
		if ( false === $foundFunction ) {
			$phpcsFile->addError(
				"Themes must call {$tagFn}() inside <{$tagName}> tags.",
				$stackPtr,
				"RequiredFunction{$pascal}"
			);

			return;
		}

		// Atrribute is not allowed.
		if ( true === $foundAttribute ) {
			$phpcsFile->addError(
				"Attribute '{$tagAttr}' is not allowed on <{$tagName}> tags. Themes must call {$tagFn}() instead.",
				$stackPtr,
				"DisallowedAttribute{$pascal}"
			);

			return;
		}
	}

	/**
	 * Cleans string for parsing.
	 *
	 * This cleans whitespace chars and single/double quotes
	 * from string.  Primary used to check T_CONSTANT_ENCAPSED_STRING
	 * and T_DOUBLE_QUOTED_STRING for closing HTML brackets.  This is
	 * because < and > are valid attribute values, and a strpos wouldn't
	 * be enough.
	 *
	 * Strips:
	 * ' '   : Whitespace
	 * '"'   : double quote
	 * '''   : single quote
	 * '\t'  : tab
	 * '\n'  : newline
	 * '\r'  : carriage return
	 * '\0'  : NUL-byte
	 * '\x0B': vertical tab
	 *
	 * @param string $str String to clean.
	 *
	 * @return string Cleaned string.
	 */
	private function clean_str( $str ) {
		return trim( $str, " \"\'\t\n\r\0\x0B" );
	}
}
