<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Restricts the use of the <title> tag, unless it is within a <svg> tag.
 *
 * @link https://make.wordpress.org/themes/handbook/review/required/
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class WordPress_Sniffs_Theme_NoTitleTagSniff implements PHP_CodeSniffer_Sniff {

	/**
	 * Property to keep track of whether a <svg> open tag has been encountered.
	 *
	 * @var array
	 */
	private $in_svg;

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return array(
			T_INLINE_HTML, // Finds inline html.
			T_CONSTANT_ENCAPSED_STRING, // Finds the title tag in PHP.
		 );
	}

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
		$tokens   = $phpcsFile->getTokens();
		$content  = $tokens[ $stackPtr ]['content'];
		$filename = $phpcsFile->getFileName();

		// Set to false if it is the first time.
		if ( ! isset( $this->in_svg[ $filename ] ) ) {
			$this->in_svg[ $filename ] = false;
		}

		// No need to check an empty string.
		if ( '' === trim( $content ) ) {
			return;
		}

		// Are we in a <svg> tag ?
		if ( true === $this->in_svg[ $filename ] ) {
			if ( false === strpos( $content, '</svg>' ) ) {
				return;
			} else {
				// Make sure we check any content on this line after the closing svg tag.
				$this->in_svg[ $filename ] = false;
				$content      = trim( substr( $content, ( strpos( $content, '</svg>' ) + 6 ) ) );
			}
		}

		/*
		 * We're not in svg, so check if it there's a <svg> open tag on this line.
		 * PHP 5.2 creates a seperate token for `<s` we need to check that the first two letters in the next token are vg.
		*/
		$next_token = $phpcsFile->findNext( array( T_INLINE_HTML ), ( $stackPtr + 1 ) );
		if ( false !== strpos( $content, '<svg' ) || ( '<s' === $content && 'vg' === substr( $tokens[ $next_token ]['content'], 0, 2 ) ) ) {
			if ( false === strpos( $content, '</svg>' ) ) {
				// Skip the next lines until the closing svg tag, but do check any content
				// on this line before the svg tag.
				$this->in_svg[ $filename ] = true;
				$content      = trim( substr( $content, 0, ( strpos( $content, '<svg' ) ) ) );
			} else {
				// Ok, we have open and close svg tag on the same line with possibly content before and/or after.
				$before  = trim( substr( $content, 0, ( strpos( $content, '<svg' ) ) ) );
				$after   = trim( substr( $content, ( strpos( $content, '</svg>' ) + 6 ) ) );
				$content = $before . $after;
			}
		}

		// Now let's do the check for the <title> tag.
		if ( false !== strpos( $content, '<title' ) ) {
			$phpcsFile->addError( "The title tag must not be used. Use add_theme_support( 'title-tag' ) instead.", $stackPtr, 'TagFound' );
		}

	} // End process().

} // End Class.
