<?php
/**
 * WordPress Coding Standard.
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @link     https://make.wordpress.org/core/handbook/best-practices/coding-standards/
 */

/**
 * WordPress_Sniffs_Theme_StyleTagsCheckSniff.
 *
 * ERROR | Check that any Tags in the style.css file header comply with the current 
 * guidelines (allowed tags, deprecated tags (=> WARNING) etc). 
 * See Theme-Check plugin - /checks/style_tags.php for the list.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    khacoder
 */
class WordPress_Sniffs_Theme_StyleTagsCheckSniff extends WordPress_AbstractThemeSniff {

	/**
	 * A list of tokenizers this sniff supports.
	 *
	 * @var array
	 */
	public $supportedTokenizers = array(
		'CSS',
	);

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return array(
			T_COMMENT,
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

		$deprecated_tags = array( 'flexible-width','fixed-width','black','blue','brown','gray','green','orange','pink','purple','red','silver','tan','white','yellow','dark','light','fixed-layout','fluid-layout','responsive-layout','blavatar','photoblogging','seasonal' );
		$allowed_tags = array( 'one-column','two-columns','three-columns','four-columns','left-sidebar','right-sidebar','grid-layout','flexible-header','accessibility-ready','buddypress','custom-background','custom-colors','custom-header','custom-menu','custom-logo','editor-style','featured-image-header','featured-images','footer-widgets','front-page-post-form','full-width-template','microformats','post-formats','rtl-language-support','sticky-post','theme-options','threaded-comments','translation-ready','blog','e-commerce','education','entertainment','food-and-drink','holiday','news','photography','portfolio' );

		$tokens = $phpcsFile->getTokens();
		$token  = $tokens[ $stackPtr ];

		$fileName = basename( $phpcsFile->getFileName() );

		if ( 'style.css' === $fileName ) {
			if ( false !== strpos( $token['content'] , 'Tags' ) ) {
				foreach ( $themetags as $tag ) {
					if ( in_array( $tag, $deprecated_tags, true ) && '' !== $tag ) {
						$phpcsFile->addWarning( $tag . ' is deprecated, please remove it.', $stackPtr, 'TagsAllowedCheck' );
					} elseif ( ! in_array( $tag, $allowed_tags, true ) && ! in_array( $tag, $deprecated_tags, true ) && '' !== $tag ) {
						$phpcsFile->addError( $tag . ' is not an approved tag and must be removed.', $stackPtr, 'TagsAllowedCheck' );
					}
				}
				return count( $tokens ) + 1;
			}
		}
	}//end process()
}
