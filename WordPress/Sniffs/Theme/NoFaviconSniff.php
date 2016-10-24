<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Check for hardcoded favicons instead of using core implementation.
 *
 * @link    https://make.wordpress.org/themes/handbook/review/required/#core-functionality-and-features
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class WordPress_Sniffs_Theme_NoFaviconSniff implements PHP_CodeSniffer_Sniff {

	const REGEX_TEMPLATE = '` (?:%s)`i';

	const REGEX_ATTR_TEMPLATE = '%1$s=[\'"](?:%2$s)[\'"]';

	/**
	 * List of link and meta attributes that are blacklisted.
	 *
	 * @var array
	 */
	protected $attribute_blacklist = array(
		'rel' => array(
			'icon',
			'shortcut icon',
			'bookmark icon',
			'apple-touch-icon',
			'apple-touch-icon-precomposed',
		),
		'name' => array(
			'msapplication-config',
			'msapplication-TileImage',
			'msapplication-square70x70logo',
			'msapplication-square150x150logo',
			'msapplication-wide310x150logo',
			'msapplication-square310x310logo',
		),
	);

	/**
	 * The regex to catch the blacklisted attributes.
	 *
	 * @var string
	 */
	protected $favicon_regex;

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		// Build the regex to be used only once.
		$regex_parts = array();

		foreach ( $this->attribute_blacklist as $key => $values ) {
			$values = array_map( 'preg_quote', $values, array_fill( 0, count( $values ), '`' ) );
			$values = implode( '|', $values );
			$regex_parts[] = sprintf( self::REGEX_ATTR_TEMPLATE, preg_quote( $key ), $values );
		}

		$this->favicon_regex = sprintf( self::REGEX_TEMPLATE, implode( '|', $regex_parts ) );

		$tokens   = PHP_CodeSniffer_Tokens::$stringTokens;
		$tokens[] = T_INLINE_HTML;

		return $tokens;
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

		if ( preg_match( $this->favicon_regex, $token['content'] ) > 0 ) {
			$phpcsFile->addError( 'Code for favicon found. Favicons are handled by the "Site Icon" setting in the customizer since version 4.3.' , $stackPtr, 'NoFavicon' );
		}

	}

}
