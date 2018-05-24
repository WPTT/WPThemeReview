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

/**
 * Restricts the use of the <title> tag, unless it is within a <svg> tag.
 *
 * @link https://make.wordpress.org/themes/handbook/review/required/
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class NoTitleTagSniff extends Sniff {

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
		$tokens[ T_HEREDOC ]     = T_HEREDOC;
		$tokens[ T_NOWDOC ]      = T_NOWDOC;

		return $tokens;
	}

	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param int $stackPtr The position of the current token in the stack.
	 *
	 * @return void
	 */
	public function process_token( $stackPtr ) {
		$content  = $this->tokens[ $stackPtr ]['content'];
		$filename = $this->phpcsFile->getFileName();

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
		if ( true === $this->has_html_open_tag( 'svg', $stackPtr, $content ) ) {
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
			$this->phpcsFile->addError( "The title tag must not be used. Use add_theme_support( 'title-tag' ) instead.", $stackPtr, 'TagFound' );
		}

	} // End process().

} // End Class.
