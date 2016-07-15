<?php
/**
 * Sniff to check theme for deregister and register of core scripts (jquery)
 *
 * @category Theme
 * @package  PHP_CodeSniffer
 * @author   Simon Prosser <pross@pross.org.uk>
 */
class WordPress_Sniffs_Theme_NoDeregisterCoreScriptSniff implements PHP_CodeSniffer_Sniff {

	/**
	 * Core scripts to sniff for.
	 *
	 * @var array
	 */
	private $core_scripts = array(
		'jquery',
	);

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return array(
			T_STRING,
			T_CONSTANT_ENCAPSED_STRING,
			T_DOUBLE_QUOTED_STRING,
			T_OPEN_PARENTHESIS,
			T_CLOSE_PARENTHESIS,
		);
	}//end register()

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

		$tokens  = $phpcsFile->getTokens();
		$token   = $tokens[ $stackPtr ];

		$content = $this->trim_quotes( $token['content'] );

		if ( 'wp_deregister_script' === $content ) {

			/**
			 * Find next closing parenthesis after the function
			 */
			$closing = $phpcsFile->findNext( T_CLOSE_PARENTHESIS, $stackPtr );

			/**
			 * The script name will be right before the closing parenthesis
			 */
			$script = $phpcsFile->findPrevious( array( T_CONSTANT_ENCAPSED_STRING, T_DOUBLE_QUOTED_STRING ), $closing, $stackPtr );

			$scriptname = $this->trim_quotes( $tokens[ $script ]['content'] );

			if ( in_array( $scriptname, $this->core_scripts, true ) ) {

				$phpcsFile->addError( 'Registering or deregistering core script %s is prohibited.', $stackPtr, 'RemovalDetected', $scriptname );
			}
		}
	}//end process()
}//end class
