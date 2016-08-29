<?php
/**
 * WordPress Coding Standard.
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @link     https://make.wordpress.org/core/handbook/best-practices/coding-standards/
 */

/**
 * WordPress_Sniffs_Theme_DeprecatedArgsSniff
 *
 * ERROR : Check for usage of deprecated WP functions and provide alternative based on the parameter passed.
 * For details, see Theme-Check plugin - /checks/more_deprecated.php.
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @author   khacoder
 */
class WordPress_Sniffs_Theme_DeprecatedArgsSniff implements PHP_CodeSniffer_Sniff
{
	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return array(
			T_STRING,
			T_CONSTANT_ENCAPSED_STRING,
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

		$tokens = $phpcsFile->getTokens();
		$token  = $tokens[ $stackPtr ];

		/**
		 * Array of function, argument, and replacement function for deprecated argument.
		 */
		$checks = array(
			'get_bloginfo' => array(
				'home'                 => 'home_url()',
				'url'                  => 'home_url()',
				'wpurl'                => 'site_url()',
				'stylesheet_directory' => 'get_stylesheet_directory_uri()',
				'template_directory'   => 'get_template_directory_uri()',
				'template_url'         => 'get_template_directory_uri()',
				'text_direction'       => 'is_rtl()',
				'feed_url'             => "get_feed_link( 'feed' ), where feed is rss, rss2 or atom",
			),
			'bloginfo' => array(
				'home'                 => 'echo esc_url( home_url() )',
				'url'                  => 'echo esc_url( home_url() )',
				'wpurl'                => 'echo esc_url( site_url() )',
				'stylesheet_directory' => 'echo esc_url( get_stylesheet_directory_uri() )',
				'template_directory'   => 'echo esc_url( get_template_directory_uri() )',
				'template_url'         => 'echo esc_url( get_template_directory_uri() )',
				'text_direction'       => 'is_rtl()',
				'feed_url'             => "echo esc_url( get_feed_link( 'feed' ) ), where feed is rss, rss2 or atom",
			),
			'get_option' => array(
				'home'     => 'home_url()',
				'site_url' => 'site_url()',
			),
		);

		$types = array( T_CONSTANT_ENCAPSED_STRING );

		foreach ( $checks as $key => $check ) {
			if ( trim( $token['content'], '\"\'"' ) === $key ) {
				$nextStackPtr = $stackPtr;
				$nextStackPtr = $phpcsFile->findNext( $types , $nextStackPtr + 1 );
				foreach ( $check as $key2 => $arg ) {
					if ( trim( $tokens[ $nextStackPtr ]['content'], '\"\'' ) === $key2 ) {
						$phpcsFile->addError( $key . "('" . $key2 . "')" . ' was found. Please use ' . $arg . ' instead.', $stackPtr, 'NoDeprecatedArgs' );
					}
				}
			}
		}
	}//end process()
}
