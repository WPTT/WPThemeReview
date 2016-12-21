<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Forbids deregistering of core scripts (jquery).
 *
 * @link    https://make.wordpress.org/themes/handbook/review/required/#core-functionality-and-features
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class WordPress_Sniffs_Theme_NoDeregisterCoreScriptSniff implements PHP_CodeSniffer_Sniff {

	/**
	 * Core scripts to sniff for.
	 *
	 * @var array
	 */
	private $core_scripts = array(
		'jquery' => 'jquery',
	);

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return array(
			T_STRING,
		);
	}

	/**
	 * Process a given string and remove quotes.
	 *
	 * @param string $string The text to be processed.
	 *
	 * @return string
	 */
	function trim_quotes( $string ) {
		return trim( $string, '"\'' );
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

		$content = strtolower( $this->trim_quotes( $token['content'] ) );

		if ( 'wp_deregister_script' !== $content ) {
			return;
		}

		/**
		 * Find the script name as the first argument.
		 */
		$script = $phpcsFile->findNext( array( T_CONSTANT_ENCAPSED_STRING ), $stackPtr, null, false, null, true );

		$script_handle = strtolower( $this->trim_quotes( $tokens[ $script ]['content'] ) );

		if ( isset( $this->core_scripts[ $script_handle ] ) ) {

			$phpcsFile->addError( 'Deregistering core script %s is prohibited.', $stackPtr, 'DeregisterDetected', $script_handle );
		}

	}

} // End Class.
