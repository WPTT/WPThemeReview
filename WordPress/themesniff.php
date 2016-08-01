<?php
/**
 * Represents a PHP_CodeSniffer sniff for sniffing WordPress Theme coding standards.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 */

/**
 * Represents a PHP_CodeSniffer sniff for sniffing WordPress Theme coding standards.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @version   0.4.0
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class WordPress_ThemeSniff {

	/**
	 * Array holding the theme header info as found in the style.css file.
	 *
	 * To use the $theme_data array, create your sniff and extend this class.
	 * Then call the array with $this->theme_data.
	 *
	 * @var array
	 */
	public $theme_data = array();

	/**
	 * Initial class set up creates the $theme_data Array
	 * @var array $theme_data
	 */
	public function __construct() {
		if ( empty( self::$theme_data ) || ! is_array( self::$theme_data ) ) {
			// initialize $theme_data.
			$theme_data['theme_name'] = '';
			$theme_data['theme_uri'] = '';
			$theme_data['theme_author'] = '';
			$theme_data['theme_author_uri'] = '';
			$theme_data['theme_description'] = '';
			$theme_data['theme_version'] = '';
			$theme_data['theme_license'] = '';
			$theme_data['theme_license_uri'] = '';
			$theme_data['theme_tags'] = '';
			$theme_data['theme_text_domain'] = '';

			// get the theme directroy for the sniff.
			$cli_object = new PHP_CodeSniffer_CLI;
	 		$values = $cli_object->getCommandLineValues();
			$directory = $values['files'][0];

			if ( ! file_exists( $directory . '/style.css' ) ) {
				echo 'WARNING : Theme style.css not found, sniffs that require theme data will not work.';
				return '';
			}

			// load style.css into array by line.
			$style_css_lines = file( $directory . '/style.css' , FILE_IGNORE_NEW_LINES );

			foreach ( $style_css_lines as $style_line ) {
				if ( strpos( $style_line , 'Theme Name :' ) !== false || strpos( $style_line , 'Theme Name:' ) !== false ) {
					$start = strpos( $style_line  , ':' ) + 1;
					$theme_data['theme_name'] = trim( substr( $style_line , $start ) );
				} elseif ( strpos( $style_line , 'Theme URI :' ) !== false || strpos( $style_line , 'Theme URI:' ) !== false ) {
					$start = strpos( $style_line  , ':' ) + 1;
					$theme_data['theme_uri'] = trim( substr( $style_line , $start ) );
				} elseif ( strpos( $style_line , 'Author :' ) !== false || strpos( $style_line , 'Author:' ) !== false ) {
					$start = strpos( $style_line  , ':' ) + 1;
					$theme_data['theme_author'] = trim( substr( $style_line , $start ) );
				} elseif ( strpos( $style_line , 'Author URI :' ) !== false || strpos( $style_line , 'Author URI:' ) !== false ) {
					$start = strpos( $style_line  , ':' ) + 1;
					$theme_data['theme_author_uri'] = trim( substr( $style_line , $start ) );
				} elseif ( strpos( $style_line , 'Description' ) !== false ) {
					$start = strpos( $style_line  , ':' ) + 1;
					$theme_data['theme_description'] = trim( substr( $style_line , $start ) );
				} elseif ( strpos( $style_line , 'Version' ) !== false ) {
					$start = strpos( $style_line  , ':' ) + 1;
					$theme_data['theme_version'] = trim( substr( $style_line , $start ) );
				} elseif ( strpos( $style_line , 'License :' ) !== false || strpos( $style_line , 'License:' ) !== false ) {
					$start = strpos( $style_line  , ':' ) + 1;
					$theme_data['theme_license'] = trim( substr( $style_line , $start ) );
				} elseif ( strpos( $style_line , 'License URI :' ) !== false || strpos( $style_line , 'License URI:' ) !== false ) {
					$start = strpos( $style_line  , ':' ) + 1;
					$theme_data['theme_license_uri'] = trim( substr( $style_line , $start ) );
				} elseif ( strpos( $style_line , 'Tags' ) !== false ) {
					$start = strpos( $style_line  , ':' ) + 1;
					$tagstring = trim( substr( $style_line , $start ) );
					$tagsarray = explode( ',' , $tagstring );
					$i = 0;
					foreach ( $tagsarray as $tag ) {
						$tagsarray[ $i ] = trim( strtolower( $tag ) );
						$i ++;
					}
					$theme_data['theme_tags'] = $tagsarray;
				} elseif ( strpos( $style_line , 'Text Domain' ) !== false ) {
					$start = strpos( $style_line  , ':' ) + 1;
					$theme_data['theme_text_domain'] = trim( substr( $style_line , $start ) );
				}
			}
			$this->theme_data = $theme_data;
		}
	}
}
