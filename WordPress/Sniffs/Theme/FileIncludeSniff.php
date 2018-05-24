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
 * Check if a theme uses include(_once) or require(_once) when get_template_part() should be used.
 *
 * @link    https://make.wordpress.org/themes/handbook/review/required/#core-functionality-and-features
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class FileIncludeSniff extends Sniff {

	/**
	 * A list of files to skip.
	 *
	 * @var array
	 */
	protected $file_whitelist = array(
		'functions.php' => true,
	);

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
	 * @param int $stackPtr The position of the current token in the stack.
	 */
	public function process_token( $stackPtr ) {
		$token     = $this->tokens[ $stackPtr ];
		$file_name = basename( $this->phpcsFile->getFileName() );

		if ( ! isset( $this->file_whitelist[ $file_name ] ) ) {
			$this->phpcsFile->addWarning(
				'Check that %s is not being used to load template files. "get_template_part()" should be used to load template files.' ,
				$stackPtr,
				'FileIncludeFound',
				array( $token['content'] )
			);
		}
	}

}
