<?php
/**
 * WPThemeReview Coding Standard.
 *
 * @package WPTRT\WPThemeReview
 * @link    https://github.com/WPTRT/WPThemeReview
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WPThemeReview\Sniffs\Templates;

use WordPressCS\WordPress\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Ensures correct HTML attribute functions are called within HTML tags.
 *
 * Ex: <body <?php body_class(); ?>> or <html <?php language_attributes(); ?>>
 *
 * @link  https://make.wordpress.org/themes/handbook/review/required/#templates
 *
 * @since 0.2.0
 */
class RequiredHTMLAttributeFunctionsSniff extends Sniff {

	/**
	 * Sniff Settings
	 *
	 * List of HTML tags that should contain the required WordPress functions.
	 *
	 * @since 0.2.0
	 *
	 * @var array
	 */
	protected $tagsConfig = array(
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
	 * The current file that is being checked.
	 *
	 * @since 0.2.0
	 *
	 * @var string
	 */
	private $current_file;

	/**
	 * Last tag in a file being checked.
	 *
	 * @since 0.2.0
	 *
	 * @var string
	 */
	private $last_tag;

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @since 0.2.0
	 *
	 * @return array
	 */
	public function register() {
		return Tokens::$textStringTokens;
	}

	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @since 0.2.0
	 *
	 * @param int $stackPtr The position of the current token
	 *                      in the stack.
	 *
	 * @return void
	 */
	public function process_token( $stackPtr ) {
		$tokens   = $this->phpcsFile->getTokens();
		$filename = $this->phpcsFile->getFileName();

		/**
		 * If filename doesn't match the one in the current_file property,
		 * that means that the sniff is in a new file and last_tag property should be empty.
		 */
		if ( $filename !== $this->current_file ) {
			$this->current_file = $filename;
			$this->last_tag     = '';
		}

		$content = trim( $tokens[ $stackPtr ]['content'] );

		// Skip on empty.
		if ( '' === trim( $content ) ) {
			return;
		}

		// Skip content that does not contain open html or body tag.
		if ( false === stripos( $content, '<html' ) && false === stripos( $content, '<body' ) ) {
			return;
		}

		// If closed html tag is found, report an error.
		if ( false !== stripos( $content, '<html>' ) ) {
			$this->phpcsFile->addError(
				'Themes must call language_attributes() inside <html> tags.',
				$stackPtr,
				'RequiredLanguageAttributesFunction'
			);

			return ( $stackPtr + 1 );
		}

		// If closed body tag is found, report an error.
		if ( false !== stripos( $content, '<body>' ) ) {
			$this->phpcsFile->addError(
				'Themes must call body_class() inside <body> tags.',
				$stackPtr,
				'RequiredBodyClassFunction'
			);

			return ( $stackPtr + 1 );
		}

		$nextPtr = $stackPtr + 1;

		$closingTagFound = false;

		do {
			$nextTokenContent = $tokens[ $nextPtr ]['content'];
			$nextTokenType    = $tokens[ $nextPtr ]['type'];

			$nextPtr++;
			$closingTagFound = true;

		} while ( ! $closingTagFound );

	}
}
