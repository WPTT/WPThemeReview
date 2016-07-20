<?php
/**
 * WordPress Coding Standard.
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @link     https://make.wordpress.org/core/handbook/best-practices/coding-standards/
 */

/**
 * WordPress_Sniffs_Theme_NoTitleTagSniff.
 *
 * Forbids the use of the title tag, unless it is in within an svg tag.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    carolinan
 */
class WordPress_Sniffs_Theme_NoTitleTagSniff implements PHP_CodeSniffer_Sniff {
	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return array(
			T_INLINE_HTML, // Finds inline html.
			T_CONSTANT_ENCAPSED_STRING, // Finds the title tag in php.
		 );
	} // end register()

	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
	 * @param int                  $stackPtr  The position of the current token in
	 *                                        the stack passed in $tokens.
	 *
	 * @return void
	 */
	public function process( PHP_CodeSniffer_File $phpcsFile, $stackPtr ) {
		$tokens = $phpcsFile->getTokens();
		$content = $tokens[ $stackPtr ]['content'];

		/**
		 * The sniff is performed line by line.
		 * This adds a warning if the title tag is used, -unless the title tag is on the same line as an svg element.
		 */
		if ( strpos( $content, '<title>' ) !== false && strpos( $content, '<svg') === false ) {
			$phpcsFile->addWarning( "The title tag is only allowed within svg elements.", $stackPtr, 'NotAllowed' );
		}
	} // end process()

} // end class
