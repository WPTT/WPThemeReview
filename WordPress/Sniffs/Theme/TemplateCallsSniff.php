<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Check that the correct template functions are used instead of directly calling template files.
 *
 * @link    https://make.wordpress.org/themes/handbook/review/required/#core-functionality-and-features
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class WordPress_Sniffs_Theme_TemplateCallsSniff implements PHP_CodeSniffer_Sniff {

	/**
	 * Returns an array of files and the correct template function.
	 *
	 * @var array
	 */
	protected $template_files = array(
		'searchform.php' => array(
			'alt' => 'get_search_form()',
		),
		'header.php' => array(
			'alt' => 'get_header()',
		),
		'footer.php' => array(
			'alt' => 'get_footer()',
		),
		'sidebar.php' => array(
			'alt' => 'get_sidebar()',
		),
	);

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return PHP_CodeSniffer_Tokens::$stringTokens;
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
		$string = trim( $token['content'], '\"\'\/' );

		if ( isset( $this->template_files[ $string ] ) ) {
			$phpcsFile->addError(
				'Use %1$s instead of including %2$s directly.',
				$stackPtr,
				'DirectTemplateIncludeFound',
				array(
					$this->template_files[ $string ]['alt'],
					$string,
				)
			);
		}
	}

}
