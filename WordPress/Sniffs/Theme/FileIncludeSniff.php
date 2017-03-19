<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Check if a theme loads one of the restricted files:
 * - wp-load.php
 * - wp-admin/admin.php
 * - media.php
 * - plugin.php
 *
 * Also check if a theme uses include(_once) or require(_once)
 * when get_template_part() should be used.
 *
 * @link    https://make.wordpress.org/themes/handbook/review/required/#core-functionality-and-features
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class WordPress_Sniffs_Theme_FileIncludeSniff implements PHP_CodeSniffer_Sniff {

	/**
	 * A list of files to skip.
	 *
	 * @var array
	 */
	protected $file_whitelist = array(
		'functions.php' => true,
	);

	/**
	 * Pattern to match the restricted files.
	 *
	 * @var string
	 */
	protected $restricted_files = '/(\/|\'|\"|\s)(wp-load|wp-admin\/admin|media|plugin)\.php/';

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
		$token  = $tokens[ $stackPtr ];

		$file_name = basename( $phpcsFile->getFileName() );

		// Get the starting position of the include/require statement.
		$incStatementStart = $phpcsFile->findStartOfStatement( $stackPtr );

		// Get the ending position of the include/require statement.
		$incStatementEnd = $phpcsFile->findEndOfStatement( $incStatementStart + 1 );

		// Get what's inside the include/require function.
		$incStatemen = $phpcsFile->getTokensAsString( $incStatementStart, ( $incStatementEnd - $incStatementStart ) );

		// Check if we are dealing with one of the restricted files, and throw an errow if yes.
		if ( preg_match( $this->restricted_files, $incStatemen ) ) {
			$phpcsFile->addError(
				$error = '%s() is not allowed to load the restricted files such as wp-load.php, wp-admin/admin.php, media.php, and plugin.php. See http://bit.ly/2nw9zet for more details.',
				$stackPtr,
				'FileIncludeFound',
				array( trim( $tokens[ $stackPtr ]['content'] ) )
			);
		}

		// If not, check if it's functions.php or not.
		if ( ! isset( $this->file_whitelist[ $file_name ] ) ) {
			$phpcsFile->addWarning(
				'Check that %s is not being used to load template files. "get_template_part()" should be used to load template files.' ,
				$stackPtr,
				'FileIncludeFound',
				array( $token['content'] )
			);
		}
	}

}
