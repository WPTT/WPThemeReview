<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * WordPress_Sniffs_Theme_NoRemovingCustomizerActiveThemeSniff.
 *
 * Forbids removing the active theme section and control in the customizer.
 * $wp_customize->remove_section( 'themes' ); and $wp_customize->remove_control( 'active_theme' );
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class WordPress_Sniffs_Theme_NoRemovingCustomizerActiveThemeSniff implements PHP_CodeSniffer_Sniff {

	/**
	 * A list of tokenizers this sniff supports.
	 *
	 * @var array
	 */
	public $supportedTokenizers = array(
		'PHP',
	);

	/**
	 * A list of strings that can be used to remove the active theme section and control from the customizer.
	 *
	 * @var array
	 */
	protected $remove_active_theme = array(
		'remove_section(themes)',
		'remove_control(active_theme)',
	);

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		$tokens   = PHP_CodeSniffer_Tokens::$stringTokens;
		return $tokens;
	}

	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
	 * @param int                  $stackPtr  The position of the current token
	 *                                        in the stack passed in $tokens.
	 *
	 * @return void
	 */
	public function process( PHP_CodeSniffer_File $phpcsFile, $stackPtr ) {

		$tokens = $phpcsFile->getTokens();
		$token  = $tokens[ $stackPtr ];
		$content = trim( strtolower( $token['content'] ) );
		// This will help us find our section and control names no matter what type of quotes that are used.
		$content = str_replace(array('"', "'", " "), '', $content);

		// No need to check an empty string.
		if ( '' === $content ) {
			return;
		}

		foreach ( $this->remove_active_theme as $removed_section ) {

			if ( false === strpos( $content, $removed_section ) ) {
				continue;
			}

			$phpcsFile->addError(
				'Themes are not allowed to remove the active theme customizer section or control. Found: %s',
				$stackPtr,
				'RemovingCustomizerActiveThemeFound',
				array( $removed_section )
			);
		}
	}

}
