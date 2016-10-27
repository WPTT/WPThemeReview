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
		$tokens                  = PHP_CodeSniffer_Tokens::$stringTokens;
		$tokens[ T_INLINE_HTML ] = T_INLINE_HTML;

		return $tokens;
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

		// Set to false if it is the first time this sniff is run on a file.
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
				$content                   = trim( substr( $content, ( strpos( $content, '</svg>' ) + 6 ) ) );
			}
		}

		// We're not in svg, so check if it there's a <svg> open tag on this line.
		if ( true === $this->has_svg_open_tag( $content, $stackPtr, $tokens ) ) {
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

	/**
	 * Check if a content string contains a SVG open tag.
	 *
	 * For PHP 5.3+ this is straightforward.
	 * PHP 5.2 creates a seperate token for `<s` when used in inline HTML, so we
	 * need to check that the first two letters in the next token are 'vg'.
	 * We don't need to worry about checking the content of the next token as
	 * it will be passed to this sniff in the next iteration and checked then.
	 * Nor about checking content before the '<s' as the bug will break up the
	 * inline html to several string tokens if it plays up.
	 *
	 * @param string $content  The current content string, might be a substring of
	 *                         the original string.
	 * @param int    $stackPtr The position of the current token in the token stack.
	 * @param array  $tokens   The token stack for the current file.
	 *
	 * @return bool True when the string contains an SVG open tag, false otherwise.
	 */
	protected function has_svg_open_tag( $content, $stackPtr, $tokens ) {
		// Check for the open tag in normal string tokens and T_INLINE_STRING for PHP 5.3+.
		if ( false !== strpos( $content, '<svg' ) ) {
			return true;

		} elseif ( T_INLINE_HTML === $tokens[ $stackPtr ]['code'] && '<s' === $content ) {
			// Ok, we might be coming across the token parser issue. Check the next token.
			if ( isset( $tokens[ $stackPtr + 1 ] ) && T_INLINE_HTML === $tokens[ $stackPtr + 1 ]['code'] && 'vg' === substr( $tokens[ $stackPtr + 1 ]['content'], 0, 2 ) ) {
				return true;
			}
		}

		return false;
	}

} // End Class.
