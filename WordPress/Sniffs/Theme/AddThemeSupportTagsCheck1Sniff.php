<?php
/**
 * WordPress Coding Standard.
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @link     https://make.wordpress.org/core/handbook/best-practices/coding-standards/
 */

/**
 * WordPress_Sniffs_Theme_AddThemeSupportTagsCheckSniff.
 *
 * Verify that an add_theme_support() call is made for any feature the
 * theme has been tagged with from the following list: custom-background,
 * custom-header, custom-menu, featured-images/post-thumbnails, post-formats,
 * custom-logo.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    khacoder
 */
class WordPress_Sniffs_Theme_AddThemeSupportTagsCheck1Sniff extends WordPress_AbstractThemeSniff {

	/**
	 * A list of tokenizers this sniff supports.
	 *
	 * @var array
	 */
	public $supportedTokenizers = array(
		'PHP',
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
		// get tags list from style.css.
		global $sniff_helper;
		$themetags = array();
		$themetags = $sniff_helper['theme_data']['tags'];
		if ( ! is_array( $themetags ) ) {
			return;
		}

		$tokens = $phpcsFile->getTokens();
		$token  = $tokens[ $stackPtr ];

		if ( 'add_theme_support' === $token['content'] ) {
			$nextStackPtr = $phpcsFile->findNext( T_CONSTANT_ENCAPSED_STRING , $stackPtr + 1 );
			$theme_support = trim( $tokens[ $nextStackPtr ]['content'] , '\'\"' );
			if ( 'post-formats' === $theme_support || 'custom-background' === $theme_support || 'custom-header' === $theme_support || 'custom-logo' === $theme_support ) {
				if ( ! in_array( $theme_support , $themetags , true ) ) {
					$phpcsFile->addError( 'add_theme_support() for ' . $theme_support . ' used but not found in tags list in style.css' , $stackPtr, 'TagAddThemeSupport' );
				}
			} elseif ( 'post-thumbnails' === $theme_support ) {
				if ( ! in_array( 'featured-image-header' , $themetags , true ) && ! in_array( 'featured-images' , $themetags , true ) ) {
					$phpcsFile->addError( 'add_theme_support() for ' . $theme_support . ' used but neither featured-images or featured-image-header were found in tags list in style.css' , $stackPtr, 'TagAddThemeSupport' );
				}
			}
		} elseif ( 'wp_nav_menu' === $token['content'] || 'register_nav_menu' === $token['content'] ) {
			if ( ! in_array( 'custom-menu' , $themetags , true ) ) {
				$phpcsFile->addError( 'When wp_nav_menu() or register_nav_menu() are used custom-menu must be added to your tags list in style.css' , $stackPtr, 'TagAddThemeSupport' );
			}
		}
	}//end process()
}
