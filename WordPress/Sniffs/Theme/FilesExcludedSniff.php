<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Check if a theme includes/requires one of the restricted files.
 *
 * Files to check for:
 * - wp-load.php
 * - media.php
 * - admin.php
 * - plugin.php
 *
 * @link    https://make.wordpress.org/themes/handbook/review/required/#core-functionality-and-features
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class WordPress_Sniffs_Theme_FilesExcludedSniff implements PHP_CodeSniffer_Sniff {

	/**
	 * Pattern to match the restricted files.
	 *
	 * @var string
	 */
	protected $restrictedFiles = '/wp-load\.php|admin\.php|media\.php|plugin\.php/';

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return PHP_CodeSniffer_Tokens::$includeTokens;
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

		// Get the starting position of the string inside one of the include/require funcitons.
		$incValStart = $phpcsFile->findNext( array( T_CONSTANT_ENCAPSED_STRING, T_DOUBLE_QUOTED_STRING ), ( $stackPtr + 1 ), null, false );

		// Get the ending position of the string inside one of the include/require funcitons.
		$incValEnd = $phpcsFile->findNext( null, ( $incValStart + 1 ), null, true, null, true );

		// Get what's inside the include/require function.
		$incVal = $phpcsFile->getTokensAsString( $incValStart, ( $incValEnd - $incValStart ) );

		// Check if we are dealing with one of the restricted files, and throw an errow if yes.
		if ( preg_match( $this->restrictedFiles, $incVal ) ) {
			$error = 'Check that %s() is not being used to load admin files. See https://make.wordpress.org/themes/handbook/review/required/#core-functionality-and-features.';
			$data  = array( trim( $tokens[ $stackPtr ][ 'content' ] ) );
			$phpcsFile->addError( $error, $stackPtr, 'Found', $data );
		}
	}
}
