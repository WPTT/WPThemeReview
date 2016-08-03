<?php
/**
 * Represents a PHP_CodeSniffer sniff for sniffing WordPress coding standards.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 */

/**
 * Represents a PHP_CodeSniffer sniff for sniffing WordPress coding standards.
 *
 * Provides a bootstrap for the sniffs, to reduce code duplication.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Juliette Reinders Folmer <wpplugins_nospam@adviesenzo.nl>
 * @author    Kevin Haig
 * @author    Ulrich Pogson <ulrich@pogson.ch>
 */
abstract class WordPress_AbstractThemeSniff implements PHP_CodeSniffer_Sniff {
	/**
	 * Define the path for style.css file.
	 *
	 * @var false|string
	 */
	public static $style_css_path = false;
	/**
	 * Array holding the theme header info as found in the style.css file.
	 *
	 * This is a static variable so it's shared between all instances of this class for efficiency.
	 *
	 * Make sure to add really good documentation about the potential keys and value types.
	 *
	 * @var array
	 */
	private static $theme_data;

	/**
	 * Initial setup.
	 *
	 * @var array $theme_data contains data from style.css headers.
	 */
	public function __construct() {
		// Only set the static once when the first child class is instantiated, no need to run this again as it'll be remembered.
		// Set the static to false if the retrieval failed and test for false.
		if ( empty( self::$theme_data ) || ! is_array( self::$theme_data ) || false === self::$theme_data ) {
			$files = $this->get_files();
			$style_css = $this->get_style_css_path( $files );
			if ( ! $this->is_theme( $style_css ) !== false ) {
				self::$theme_data = false;
			}
			$file_contents    = $this->get_file_contents( $style_css );
			if ( is_array( $file_contents ) ) {
				self::$theme_data = $this->process_data( $file_contents );
			}
		}
	}

	/**
	 * Check if this is a theme by checking if it has a style.css file.
	 *
	 * @param string $style_css contains style directory.
	 *
	 * @return bool
	 */
	private function is_theme( $style_css = '' ) {
		if ( false !== strpos( $style_css, '/style.css' ) ) {
			return true;
		}
		return false;
	}
	/**
	 * Get the style.css file from the list of files.
	 *
	 * @param array $files All of the files being sniffed.
	 *
	 * @return false|string
	 */
	private function get_style_css_path( $files = array() ) {
		if ( self::$style_css_path ) {
			return self::$style_css_path;
		}
		if ( count( $files ) === 1 ) {
			$style_css = $files[0] . '/style.css';
		} else {
			foreach ( $files as $file ) {
				if ( false !== strpos( $file, '/style.css' ) ) {
					$style_css = $file;
				}
			}
		}
		if ( ! empty( $style_css ) && file_exists( $style_css ) ) {
			return $style_css;
		}
		return false;
	}
	/**
	 * Get the list of files that are being sniffed.
	 *
	 * @return array
	 */
	private function get_files() {
		$cli_object = new PHP_CodeSniffer_CLI;
		$command_line_values = $cli_object->getCommandLineValues();
		array_multisort( array_map( 'strlen', $command_line_values['files'] ), $command_line_values['files'] );
		return $command_line_values['files'];
	}
	/**
	 * Fetch the contents of the style.css file.
	 *
	 * @param string $file_path The file path to style.css..\phpcs --standard=WordPress-Theme c:\xampp\htdocs\Themes\aatest.
	 *
	 * @return false|array
	 */
	private function get_file_contents( $file_path = '' ) {
		if ( ! file_exists( $file_path ) ) {
			// ERROR file does not exist.
			return false;
		}
		 // Read the theme file into an array.
		return file( $file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
	}
	/**
	 * Processes the contents of the style.css.
	 *
	 * @param array $file_contents The content from the style.css.
	 *
	 * @return false|array
	 */
	public function process_data( $file_contents = array() ) {
		// initialize $theme_data.
		$theme_data = array(
			'name'        => '',
			'uri'         => '',
			'author'      => '',
			'author_uri'  => '',
			'description' => '',
			'version'     => '',
			'license'     => '',
			'license_uri' => '',
			'tags'        => '',
			'text_domain' => '',
		);
		foreach ( $file_contents as $style_line ) {
			// get the data name.
			$name = trim( strstr( $style_line, ':', true ) );
			// get the data value.
			$start = strpos( $style_line, ':' ) + 1;
			$value = trim( substr( $style_line, $start ) );
			switch ( $name ) {
				case 'Theme Name':
					$theme_data['name'] = $value;
					break;
				case 'Theme URI':
					$theme_data['uri'] = $value;
					break;
				case 'Author':
					$theme_data['author'] = $value;
					break;
				case 'Author URI':
					$theme_data['author_uri'] = $value;
					break;
				case 'Description':
					$theme_data['description'] = $value;
					break;
				case 'Version':
					$theme_data['version'] = $value;
					break;
				case 'License':
					$theme_data['license'] = $value;
					break;
				case 'License URI':
					$theme_data['license_uri'] = $value;
					break;
				case 'Text Domain':
					$theme_data['text_domain'] = $value;
					break;
				case 'Tags':
					$tag_array = explode( ',' , $value );
					foreach ( $tag_array as $tag ) {
						$tags[] = trim( strtolower( $tag ) );
					}
					$theme_data['tags'] = $tags;
					break;
			}
		}
		return $theme_data;
	}
	/**
	 * Fetch single theme data.
	 *
	 * @param string $key The content from the style.css.
	 *
	 * @return false|string|array
	 */
	protected function get_theme_data( $key ) {
		if ( isset( self::$theme_data[ $key ] ) ) {
			return self::$theme_data[ $key ];
		} else {
			return false;
		}
	}
}
