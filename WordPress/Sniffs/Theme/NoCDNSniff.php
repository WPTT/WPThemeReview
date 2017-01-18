<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Restricts the use of the CDN URLs.
 *
 * @link https://make.wordpress.org/themes/handbook/review/required/
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class WordPress_Sniffs_Theme_NoCDNSniff implements PHP_CodeSniffer_Sniff {

	/**
	 * A list of tokenizers this sniff supports.
	 *
	 * @var array
	 */
	public $supportedTokenizers = array(
		'PHP',
		'JS',
		'CSS',
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
			T_INLINE_HTML,
			T_URL,
		);
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

		// List of CDN's not allowed.
		$cdn_list = array(
			'maxcdn.bootstrapcdn.com',
			'netdna.bootstrapcdn.com',
			'html5shiv.googlecode.com/svn/trunk/html5.js',
			'oss.maxcdn.com',
			'code.jquery.com',
			'cdnjs.com',
		);

		if ( preg_match_all( '#(?:(?:http|https|ftp):)?//([[:alnum:]\-\.])+(\\.)([[:alnum:]]){2,4}([[:blank:][:alnum:]\/\+\=\%\&\_\\\.\~\?\-]*)#' , $token['content'], $matches, PREG_SET_ORDER ) ) {

			foreach ( $matches as $match ) {
				$found = false;

				foreach ( $cdn_list as $cdn_url ) {
					if ( false !== strpos( $match[0], $cdn_url ) ) {
						$phpcsFile->addError( 'Found the URL to a CDN: (' . $cdn_url . ') The CSS or JavaScript resources cannot be loaded from a CDN but must be bundled.', $stackPtr, 'CDNFound' );
						$found = true;
					}
				}

				if ( false !== strpos( $match[0], 'cdn' ) && false === $found ) {
					$phpcsFile->addWarning( 'Possible URL of a CDN has been found. The CSS or JavaScript resources cannot be loaded from a CDN but must be bundled.', $stackPtr, 'CDNFound' );
				}
			}
		}
	}
}
