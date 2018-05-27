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
	 * Returns an array of partial file names and the correct template function.
	 *
	 * Use a * wildcard in the array key to indicate that `file-variant.php` variations
	 * should be matched as well.
	 *
	 * @var array <string partial file name> => <string alternative>
	 */
	protected $template_files = array(
		'searchform' => 'get_search_form()',
		'header*'    => 'get_header()',
		'footer*'    => 'get_footer()',
		'sidebar*'   => 'get_sidebar()',
	);

	/**
	 * Regex for matching the filenames.
	 *
	 * The regex will be created once in the `register()` method based on the $template_files array.
	 *
	 * @var string
	 */
	private $regex = '`^/?(?P<filename>(?P<partial>%s)\.php)$`i';

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		// Prepare the regex only once.
		$files = array_map( array( $this, 'prepare_name_for_regex' ), array_keys( $this->template_files ) );
		$files = implode( '|', $files );

		$this->regex = sprintf( $this->regex, $files );

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
		$string = trim( $token['content'], '"\'' );

		if ( 1 === preg_match( $this->regex, $string, $matches ) ) {
			$file_name   = $matches['partial'];
			$alternative = '';

			// Find alternative for full file name matches.
			if ( isset( $this->template_files[ $file_name ] ) ) {
				$alternative = $this->template_files[ $file_name ];
			}

			// Find alternative for wildcard file name matches.
			if ( empty( $alternative ) ) {
				$dash = strpos( $file_name, '-' );
				$file_name = substr( $file_name, 0, $dash ) . '*';
				if ( isset( $this->template_files[ $file_name ] ) ) {
					$alternative = $this->template_files[ $file_name ];
				}
			}

			$phpcsFile->addError(
				'Use %1$s instead of including "%2$s" directly.',
				$stackPtr,
				'DirectTemplateIncludeFound',
				array(
					$alternative,
					$matches['filename'],
				)
			);
		}
	}

	/**
	 * Prepare the partial file name for use in a regular expression.
	 *
	 * - Escape the file name for use in regex.
	 * - Deal with wildcards indicating the potential for variants.
	 *
	 * @param string $file_name (Partial) file name.
	 * @return string Regex escaped file name.
	 */
	protected function prepare_name_for_regex( $file_name ) {
		$file_name = str_replace( '*' , '#', $file_name ); // Replace wildcards with placeholder.
		$file_name = preg_quote( $file_name, '`' );
		$file_name = str_replace( '#', '(?:-.*?)?', $file_name ); // Replace placeholder with optional regex wildcard.

		return $file_name;
	}
}
