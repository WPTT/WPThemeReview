<?php
/**
 * Sniff to check theme for deregister and register of core scripts (jquery)
 *
 * @category Theme
 * @package  PHP_CodeSniffer
 * @author   Simon Prosser <pross@pross.org.uk>
 */
class WordPress_Sniffs_Theme_NoDeregisterCoreScriptSniff extends WordPress_Sniffs_Functions_FunctionRestrictionsSniff {
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
			   );

	}//end register()


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

		$content = trim( $token['content'], '"\'' );

		$functions = array(
			'wp_deregister_script',
			'wp_register_script',
		);

		$scripts = array(
			'jquery',
		);

		if ( in_array( $content, $functions, true ) ) {

			$script = $phpcsFile->findNext( array( T_CONSTANT_ENCAPSED_STRING, T_DOUBLE_QUOTED_STRING ), $stackPtr );

			$content = preg_replace( '/[^a-zA-Z0-9]+/', '', html_entity_decode( $tokens[ $script ]['content'], ENT_QUOTES ) );

			if ( in_array( $content, $scripts, true ) ) {

				$phpcsFile->addError( sprintf( 'Registering or deregistering core script %s is prohibited.', $content ), $stackPtr, 'RemovalDetected' );
			}
		}
	}//end process()
}//end class
