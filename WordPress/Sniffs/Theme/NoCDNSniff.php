<?php
/**
 * WordPress Coding Standard.
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @link     https://make.wordpress.org/core/handbook/best-practices/coding-standards/
 */

/**
 * WordPress_Sniffs_Theme_NoHardCodedUrlsSniff Class Doc Comment
 *
 * ERROR : Using a CDN is discouraged. All JS and CSS should be bundled. For a
 * list of typical source strings to look for, see Theme-Check plugin -
 * /checks/cdn.php
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @author   khacoder
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
				foreach( $cdn_list as $cdn_url ) {
					if ( false !== strpos( $match[0], $cdn_url ) ) {
						$phpcsFile->addError( $cdn_url.'Found the URL of a CDN. You should not load CSS or Javascript resources from a CDN, please bundle them with the theme.', $stackPtr, 'CDNFound' );
						$found = true;
					}
				}
				if ( false !== strpos( $match[0], 'cdn' ) && $found === false ) {
					$phpcsFile->addWarning( 'Possible URL of a CDN has been found. You should not load CSS or Javascript resources from a CDN, please bundle them with the theme.', $stackPtr, 'CDNFound' );
				}
			}
		}
	}//end process()
}
