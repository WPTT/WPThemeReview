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
	 * Array holding the once through WordPress Theme file checks.
	 *
	 * @var array
	 */
	private static $sniff_helper;

	/**
	 * Initial setup.
	 *
	 * @var array $theme_data contains data from style.css headers.
	 */
	public function __construct() {
		// do a once through pass and get the files.
		if ( empty( self::$sniff_helper ) || ! is_array( self::$sniff_helper ) || false === self::$sniff_helper ) {
			$files = $this->get_files();
			$themedir = $files[0];
			// Only run this if checking a directory.
			$themedir_parts = pathinfo( $themedir );
			if ( isset( $themedir_parts['extension'] ) ) {
				return;
			}
			$themefiles = $this->listdir( $themedir );
			self::$sniff_helper = $this->once_through( $themedir , $themefiles );
			// var_dump( self::$sniff_helper );.
		}
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

	// ================== below are functions for the once through
	/**
	 * Taken from themecheck
	 *
	 * @param string $dir containing directory uri.
	 */
	protected function listdir( $dir ) {
		$files = array();
		$dir_iterator = new RecursiveDirectoryIterator( $dir );
		$iterator = new RecursiveIteratorIterator( $dir_iterator, RecursiveIteratorIterator::SELF_FIRST );

		foreach ( $iterator as $file ) {
			array_push( $files, $file->getPathname() );
		}
		return $files;
	}

	/**
	 * Taken from themecheck.
	 * Strip comments from a PHP file in a way that will not change the underlying structure of the file.
	 *
	 * @param string $code contains the file contents as a string.
	 */
	protected function strip_comments( $code ) {
		$strip = array( T_COMMENT => true, T_DOC_COMMENT => true );
		$newlines = array( "\n" => true, "\r" => true );
		$tokens = token_get_all( $code );
		reset( $tokens );
		$return = '';
		$token = current( $tokens );
		while ( $token ) {
			if ( ! is_array( $token ) ) {
				$return .= $token;
			} elseif ( ! isset( $strip[ $token[0] ] ) ) {
				$return .= $token[1];
			} else {
				for ( $i = 0, $token_length = strlen( $token[1] ); $i < $token_length; ++$i ) {
					if ( isset( $newlines[ $token[1][ $i ] ] ) ) {
						$return .= $token[1][ $i ];
					}
				}
			}
			$token = next( $tokens );
		}
		return $return;
	}

	/**
	 * Processes the contents of each theme file.
	 * Obtain sniff helper data
	 *
	 * @param string $themedir directory of theme being checked.
	 * @param array  $themefiles list of files to be checked.
	 *
	 * @return false|array
	 */
	public function once_through( $themedir, $themefiles = array() ) {
		// Initiate the Sniff_helper array.
		global $sniff_helper;
		$sniff_helper = array(
			'theme_data' => array(
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
			),
			'theme_supports' => array(
				'custom-header' => false,
				'custom-background' => false,
				'custom-logo' => false,
				'post-formats' => false,
				'featured-images' => false,
				'featured-image-header' => false,
				'custom-menu' => false,
			),
			'comment_reply' => array(
				'enqueued' => false,
				'comment_reply_term' => false,
			),
			'comments_pagination' => false,
			'content_width' => false,
			'add_editor_style' => false,
			'avatar_check' => false,
			'custom_menu_support' => false,
			'post_pagination' => false,
			'post_format_support' => false,
			'post_thumbnail_support' => false,
			'post_tags_support' => false,
			'title_tag' => array(
				'theme_support' => false,
				'wp_title' => false,
			),
			'sidebar_support' => array(
				'register_sidebar_used' => false,
				'dynamic_sidebar_used' => false,
				'widgets_init_used' => false,
			),
			'basic_function_calls' => array(
				'wp_footer' => false,
				'wp_head' => false,
				'language_attributes' => false,
				'charset' => false,
				'automatic_feed_links' => false,
				'comments_template' => false,
				'wp_list_comments' => false,
				'comment_form' => false,
				'body_class' => false,
				'wp_link_pages' => false,
				'post_class' => false,
			),
			'doctype' => false,
			'index_file_used' => false,
			'style_file_used' => false,
			'readme_file_used' => false,
			'screenshot' => array(
				'found' => false,
				'less_than_1200_wide' => false,
				'less_than_900_high' => false,
				'aspect_ratio_4_by_3' => false,
				'details_not_found' => false,
			),
			'css_required' => array(
				'sticky' => false,
				'bypostauthor' => false,
				'alignleft' => false,
				'alignright' => false,
				'aligncenter' => false,
				'wp-caption' => false,
				'wp-caption-text' => false,
				'gallery-caption' => false,
				'screen-reader-text' => false,
			),
		);
		$this->get_minimum_file_check( $themedir );
		$this->get_readme_file_check( $themedir );
		$this->get_screenshot_checks( $themedir );
		foreach ( $themefiles as $themefile ) {
			if ( strpos( $themefile , '.php' ) !== false ) {
				$file_content = file_get_contents( $themefile );
				$file_content = $this->strip_comments( $file_content );
				$this->get_theme_supports( $file_content );
				$this->get_comment_reply_checks( $file_content );
				$this->get_comments_pagination_check( $file_content );
				$this->get_content_width_check( $file_content );
				$this->get_editor_style_check( $file_content );
				$this->get_avatar_checks( $file_content );
				$this->get_custom_menu_check( $file_content );
				$this->get_post_pagination_check( $file_content );
				$this->get_post_format_check( $file_content );
				$this->get_post_thumbnail_check( $file_content );
				$this->get_post_tags_check( $file_content );
				$this->get_title_tag_check( $file_content );
				$this->get_sidebar_checks( $file_content );
				$this->get_basic_function_checks( $file_content );
				$this->get_doctype_check( $file_content );
			}
			if ( strpos( $themefile , '.css' ) !== false ) {
				// css files loaded into line array.
				$file_content = file( $themefile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
				if ( $themefile == trim( $themedir ,'\\' ) . '\style.css' ) {
					$this->get_theme_data( $file_content );
				}
				$this->get_css_checks( $file_content );
				$this->get_post_format_css_check( $file_content );
			}
		}
		// Display errors and warnings.
		$this->display_errors_and_warnings( $themedir );
		return $sniff_helper;
	}

	/**
	 * This function will go through the files and identify theme supports.
	 * Verify that an add_theme_support() call is made for any feature the theme
	 * has been tagged with from the following list: custom-background,
	 * custom-header, custom-menu, featured-images/post-thumbnails, post-formats,
	 * custom-logo
	 * If found set associated theme tags to true.
	 *
	 * @param string $file_content contains content of file in a single string.
	 */
	public function get_theme_supports( $file_content ) {
		global $sniff_helper;
		if ( false !== strpos( $file_content, 'add_theme_support' ) && false !== strpos( $file_content, 'custom-header' ) ) {
			$sniff_helper['theme_supports']['custom-header'] = true;
		}
		if ( false !== strpos( $file_content, 'add_theme_support' ) && false !== strpos( $file_content, 'custom-background' ) ) {
			$sniff_helper['theme_supports']['custom-background'] = true;
		}
		if ( false !== strpos( $file_content, 'add_theme_support' ) && false !== strpos( $file_content, 'custom-logo' ) ) {
			$sniff_helper['theme_supports']['custom-logo'] = true;
		}
		if ( false !== strpos( $file_content, 'add_theme_support' ) && false !== strpos( $file_content, 'post-formats' ) ) {
			$sniff_helper['theme_supports']['post-formats'] = true;
		}
		if ( false !== strpos( $file_content, 'add_theme_support' ) && false !== strpos( $file_content, 'post-thumbnails' ) ) {
			$sniff_helper['theme_supports']['featured-images'] = true;
			$sniff_helper['theme_supports']['featured-image-header'] = true;
		}
		if ( false !== strpos( $file_content, 'register_nav_menu' ) ) {
			$sniff_helper['theme_supports']['custom-menu'] = true;
		}
		if ( false !== strpos( $file_content, 'wp_nav_menu' ) ) {
			$sniff_helper['theme_supports']['custom-menu'] = true;
		}
	}

	/**
	 * This functions checks for comment-reply useage.
	 * Checks include enqueue of comment-reply script and useage of the comment-reply term.
	 *
	 * @param string $file_content contains content of file in a single string.
	 */
	public function get_comment_reply_checks( $file_content ) {
		global $sniff_helper;
		// from themecheck.
		if ( preg_match( '/wp_enqueue_script\(\s?("|\')comment-reply("|\')/i', $file_content ) ) {
			$sniff_helper['comment_reply']['enqueued'] = true;
			$sniff_helper['comment_reply']['comment_reply_term'] = true;
		} elseif ( preg_match( '/comment-reply/', $file_content ) ) {
			$sniff_helper['comment_reply']['comment_reply_term'] = true;
		}
	}

	/**
	 * This function checks for comment pagination.
	 * If found set comment_pagination to true.
	 *
	 * @param string $file_content contains content of file in a single string.
	 */
	public function get_comments_pagination_check( $file_content ) {
		global $sniff_helper;
		if ( false !== strpos( $file_content, 'paginate_comments_links' ) ) {
			$sniff_helper['comments_pagination'] = true;
		}
		if ( false !== strpos( $file_content, 'the_comments_navigation' ) ) {
			$sniff_helper['comments_pagination'] = true;
		}
		if ( false !== strpos( $file_content, 'the_comments_pagination' ) ) {
			$sniff_helper['comments_pagination'] = true;
		}
		if ( false !== strpos( $file_content, 'next_comments_link' ) ) {
			$sniff_helper['comments_pagination'] = true;
		}
		if ( false !== strpos( $file_content, 'previous_comments_link' ) ) {
			$sniff_helper['comments_pagination'] = true;
		}
	}

	/**
	 * This functions checks the global content_width is set.
	 * Checks include enqueue of comment-reply script and useage of the term comment-reply term.
	 *
	 * @param string $file_content contains content of file in a single string.
	 */
	public function get_content_width_check( $file_content ) {
		global $sniff_helper;
		if ( false !== strpos( $file_content, '$content_width' ) ) {
			$sniff_helper['content_width'] = true;
		}
		if ( false !== strpos( $file_content , '$GLOBALS' . "['content_width']" ) ) {
			$sniff_helper['content_width'] = true;
		}
	}

	/**
	 * This functions checks if add_editor_style() is called.
	 * Checks include enqueue of comment-reply script and useage of the term comment-reply term.
	 *
	 * @param string $file_content contains content of file in a single string.
	 */
	public function get_editor_style_check( $file_content ) {
		global $sniff_helper;
		if ( false !== strpos( $file_content, 'add_editor_style' ) ) {
			$sniff_helper['add_editor_style'] = true;
		}
	}

	/**
	 * This functions checks if for get_avatar and wp_list_comments.
	 * If one is present set flag to true for use later.
	 *
	 * @param string $file_content contains content of file in a single string.
	 */
	public function get_avatar_checks( $file_content ) {
		global $sniff_helper;
		if ( false !== strpos( $file_content, 'get_avatar' ) ) {
			$sniff_helper['avatar_check'] = true;
		}
		if ( false !== strpos( $file_content, 'wp_list_comments' ) ) {
			$sniff_helper['avatar_check'] = true;
		}
	}

	/**
	 * This functions checks if for wp_nav_menu and register_nav_menu.
	 * If one is present set flag to true for use later.
	 *
	 * @param string $file_content contains content of file in a single string.
	 */
	public function get_custom_menu_check( $file_content ) {
		global $sniff_helper;
		if ( false !== strpos( $file_content, 'wp_nav_menu' ) ) {
			$sniff_helper['custom_menu_support'] = true;
		}
		if ( false !== strpos( $file_content, 'registar_nav_menu' ) ) {
			$sniff_helper['custom_menu_support'] = true;
		}
	}

	/**
	 * Check that post pagination is supported. At least one of the following
	 * functions would need to be found in at least one of the template files,
	 * fail if none are found at all. posts_nav_link(), paginate_links(),
	 * the_posts_navigation(), the_posts_pagination(), next_posts_link() or
	 * previous_posts_link()
	 * If one is found set post_pagination to true for later use.
	 *
	 * @param string $file_content contains content of file in a single string.
	 */
	public function get_post_pagination_check( $file_content ) {
		global $sniff_helper;
		if ( false !== strpos( $file_content, 'posts_nav_link' ) ) {
			$sniff_helper['post_pagination'] = true;
		}
		if ( false !== strpos( $file_content, 'paginate_links' ) ) {
			$sniff_helper['post_pagination'] = true;
		}
		if ( false !== strpos( $file_content, 'the_posts_navigation' ) ) {
			$sniff_helper['post_pagination'] = true;
		}
		if ( false !== strpos( $file_content, 'the_posts_pagination' ) ) {
			$sniff_helper['post_pagination'] = true;
		}
		if ( false !== strpos( $file_content, 'next_posts_link' ) ) {
			$sniff_helper['post_pagination'] = true;
		}
		if ( false !== strpos( $file_content, 'previous_posts_link' ) ) {
			$sniff_helper['post_pagination'] = true;
		}
	}

	/**
	 * Verify that get_post_format()or has_format() are found, at least once
	 * if the theme has a add_theme_support( 'post-format' ) call. This should
	 * become an error if the theme is tagged with post-formats.
	 * If one is present set flag to true for use later.
	 *
	 *  @param string $file_content contains content of file in a single string.
	 */
	public function get_post_format_check( $file_content ) {
		global $sniff_helper;
		if ( false !== strpos( $file_content, 'get_post_format' ) ) {
			$sniff_helper['post_format_support'] = true;
		}
		if ( false !== strpos( $file_content, 'has_post_format' ) ) {
			$sniff_helper['post_format_support'] = true;
		}
	}

	/**
	 * Verify that the_post_thumbnail(), get_the_post_thumbnail(), or
	 * get_post_thumbnail_id() are found at least once if the theme has a
	 * add_theme_support( 'post-thumbnails' ) call. This should become an error
	 * if the theme is tagged with featured-image.
	 * If one is present set flag to true for use later.
	 *
	 * @param string $file_content contains content of file in a single string.
	 */
	public function get_post_thumbnail_check( $file_content ) {
		global $sniff_helper;
		if ( false !== strpos( $file_content, 'the_post_thumbnail' ) ) {
			$sniff_helper['post_thumbnail_support'] = true;
		}
		if ( false !== strpos( $file_content, 'get_the_post_thumbnail' ) ) {
			$sniff_helper['post_thumbnail_support'] = true;
		}
		if ( false !== strpos( $file_content, 'get_post_thumbnail_id' ) ) {
			$sniff_helper['post_thumbnail_support'] = true;
		}
	}

	/**
	 * Check that post tags are supported in the theme. At least one of the
	 * following functions would need to be found in at least one of the template
	 * files, fail if none are found at all; the_tags(), get_the_tag_list(),
	 * get_the_term_list()
	 * If one is present set flag to true for use later.
	 *
	 * @param string $file_content contains content of file in a single string.
	 */
	public function get_post_tags_check( $file_content ) {
		global $sniff_helper;
		if ( false !== strpos( $file_content, 'the_tags' ) ) {
			$sniff_helper['post_tags_support'] = true;
		}
		if ( false !== strpos( $file_content, 'get_the_tag_list' ) ) {
			$sniff_helper['post_tags_support'] = true;
		}
		if ( false !== strpos( $file_content, 'get_the_term_list' ) ) {
			$sniff_helper['post_tags_support'] = true;
		}
	}

	/**
	 * Check that add_theme_support( 'title-tag' ) and wp_title() are being used.
	 * If used then set a flag to true, to be used later.
	 *
	 * @param string $file_content contains content of file in a single string.
	 */
	public function get_title_tag_check( $file_content ) {
		global $sniff_helper;
		if ( ! preg_match( '#add_theme_support\s?\(\s?[\'|"]title-tag#', $file_content ) ) {
			$sniff_helper['title_tag']['theme_support'] = true;
		}
		if ( false !== strpos( $file_content, 'wp_title' ) ) {
			$sniff_helper['title_tag']['wp_title'] = true;
		}
	}

	/**
	 * Check if register_sidebar(), dynamic_sidebar() and
	 * add_action( 'widget_init', ... ) are being used.
	 * If used then set a flag to true, to be used later.
	 *
	 * @param string $file_content contains content of file in a single string.
	 */
	public function get_sidebar_checks( $file_content ) {
		global $sniff_helper;
		if ( false !== strpos( $file_content, 'register_sidebar' ) ) {
			$sniff_helper['sidebar_support']['register_sidebar_used'] = true;
		}
		if ( false !== strpos( $file_content, 'dynamic_sidebar' ) ) {
			$sniff_helper['sidebar_support']['dynamic_sidebar_used'] = true;
		}
		if ( false != preg_match( '/add_action\s*\(\s*("|\')widgets_init("|\')\s*,/', $file_content ) ) {
			$sniff_helper['sidebar_support']['widgets_init_used'] = true;
		}
	}

	/**
	 * Check that basic WordPress function calls are made.
	 * If used then set a flag to true, to be used later.
	 *
	 * @param string $file_content contains content of file in a single string.
	 */
	public function get_basic_function_checks( $file_content ) {
		global $sniff_helper;
		if ( false !== strpos( $file_content, 'wp_footer' ) ) {
			$sniff_helper['basic_function_calls']['wp_footer'] = true;
		}
		if ( false !== strpos( $file_content, 'wp_head' ) ) {
			$sniff_helper['basic_function_calls']['wp_head'] = true;
		}
		if ( false !== strpos( $file_content, 'language_attributes' ) ) {
			$sniff_helper['basic_function_calls']['language_attributes'] = true;
		}
		if ( false !== strpos( $file_content, 'charset' ) ) {
			$sniff_helper['basic_function_calls']['charset'] = true;
		}
		if ( false !== strpos( $file_content, 'add_theme_support' ) && false !== strpos( $file_content, 'automatic-feed-links' ) ) {
			$sniff_helper['basic_function_calls']['automatic_feed_links'] = true;
		}
		if ( false !== strpos( $file_content, 'comments_template' ) ) {
			$sniff_helper['basic_function_calls']['comments_template'] = true;
		}
		if ( false !== strpos( $file_content, 'wp_list_comments' ) ) {
			$sniff_helper['basic_function_calls']['wp_list_comments'] = true;
		}
		if ( false !== strpos( $file_content, 'comment_form' ) ) {
			$sniff_helper['basic_function_calls']['comment_form'] = true;
		}
		if ( false !== strpos( $file_content, 'body_class' ) ) {
			$sniff_helper['basic_function_calls']['body_class'] = true;
		}
		if ( false !== strpos( $file_content, 'wp_link_pages' ) ) {
			$sniff_helper['basic_function_calls']['wp_link_pages'] = true;
		}
		if ( false !== strpos( $file_content, 'post_class' ) ) {
			$sniff_helper['basic_function_calls']['post_class'] = true;
		}
	}

	/**
	 * Check for DOCTYPE declaration.
	 * If used then set a flag to true, to be used later.
	 *
	 * @param string $file_content contains content of file in a single string.
	 */
	public function get_doctype_check( $file_content ) {
		global $sniff_helper;
		if ( false !== strpos( $file_content, 'DOCTYPE' ) ) {
			$sniff_helper['doctype'] = true;
		}
	}

	/**
	 * Check that at the very least the following two files exist: index.php
	 * and style.css.
	 * If used then set a flag to true, to be used later.
	 *
	 * @param string $themedir contains the theme directory uri.
	 */
	public function get_minimum_file_check( $themedir ) {
		global $sniff_helper;
		if ( file_exists( $themedir . '/style.css' ) ) {
			$sniff_helper['style_file_used'] = true;
		}
		if ( file_exists( $themedir . '/index.php' ) ) {
			$sniff_helper['index_file_used'] = true;
		}
	}

	/**
	 * Check if readme.txt or readme.md exists.
	 * If used then set a flag to true, to be used later.
	 *
	 * @param string $themedir contains the theme directory uri.
	 */
	public function get_readme_file_check( $themedir ) {
		global $sniff_helper;
		if ( file_exists( $themedir . '/readme.txt' ) || file_exists( $themedir . '/readme.md' ) ) {
			$sniff_helper['readme_file_used'] = true;
		}
	}

	/**
	 * Check if readme.txt or readme.md exists.
	 * If used then set a flag to true, to be used later.
	 *
	 * @param string $themedir contains the theme directory uri.
	 */
	public function get_screenshot_checks( $themedir ) {
		global $sniff_helper;
		if ( file_exists( $themedir . '\screenshot.jpg' ) ) {
			$sniff_helper['screenshot']['found'] = true;
			$imagefilename = $themedir . '\screenshot.jpg';
			echo $imagefilename;
		}
		if ( file_exists( $themedir . '\screenshot.png' ) ) {
			$sniff_helper['screenshot']['found'] = true;
			$imagefilename = $themedir . '\screenshot.png';
		}
		if ( false !== $sniff_helper['screenshot']['found'] ) {
			$image = getimagesize( $imagefilename );
			if ( is_array($image) ) {
				if ( $image[0] <= 1200 ) {
					$sniff_helper['screenshot']['less_than_1200_wide'] = true;
				}
				if ( $image[1] <= 900 ) {
					$sniff_helper['screenshot']['less_than_900_high'] = true;
				}

				if ( 0.76 > $image[1] / $image[0] &&  0.74 < $image[1] / $image[0] ) {
					$sniff_helper['screenshot']['aspect_ratio_4_by_3'] = true;
				}
			} else {
				$sniff_helper['screenshot']['less_than_1200_wide'] = true;
				$sniff_helper['screenshot']['less_than_900_high'] = true;
				$sniff_helper['screenshot']['aspect_ratio_4_by_3'] = true;
				$sniff_helper['screenshot']['details_not_found'] = true;
			}
		}
	}

	// ------------------ CSS File prep functions ------------------------
	/**
	 * Processes the contents of the style.css.
	 *
	 * @param array $file_content contains content of file by line.
	 *
	 * @return false|array
	 */
	public function get_theme_data( $file_content ) {
		global $sniff_helper;
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
		foreach ( $file_content as $style_line ) {
			// get the data name.
			$name = trim( strstr( $style_line, ':', true ) );
			// get the data value.
			$start = strpos( $style_line, ':' ) + 1;
			$value = trim( substr( $style_line, $start ) );
			switch ( $name ) {
				case 'Theme Name':
					$sniff_helper['theme_data']['name'] = $value;
					break;
				case 'Theme URI':
					$sniff_helper['theme_data']['uri'] = $value;
					break;
				case 'Author':
					$sniff_helper['theme_data']['author'] = $value;
					break;
				case 'Author URI':
					$sniff_helper['theme_data']['author_uri'] = $value;
					break;
				case 'Description':
					$sniff_helper['theme_data']['description'] = $value;
					break;
				case 'Version':
					$sniff_helper['theme_data']['version'] = $value;
					break;
				case 'License':
					$sniff_helper['theme_data']['license'] = $value;
					break;
				case 'License URI':
					$sniff_helper['theme_data']['license_uri'] = $value;
					break;
				case 'Text Domain':
					$sniff_helper['theme_data']['text_domain'] = $value;
					break;
				case 'Tags':
					$tag_array = explode( ',' , $value );
					foreach ( $tag_array as $tag ) {
						$tags[] = trim( strtolower( $tag ) );
					}
					$sniff_helper['theme_data']['tags'] = $tags;
					break;
			}
		}
		return;
	}
	/**
	 * This function will go through the css files and identify required css.
	 * If found set associated check to true.
	 *
	 * @param array $file_content contains content of file in a line array.
	 */
	public function get_css_checks( $file_content ) {
		global $sniff_helper;
		foreach ( $file_content as $line ) {
			if ( false !== strpos( $line, '.sticky' ) ) {
				$sniff_helper['css_required']['sticky'] = true;
			}
			if ( false !== strpos( $line, '.bypostauthor' ) ) {
				$sniff_helper['css_required']['bypostauthor'] = true;
			}
			if ( false !== strpos( $line, '.alignleft' ) ) {
				$sniff_helper['css_required']['alignleft'] = true;
			}
			if ( false !== strpos( $line, '.alignright' ) ) {
				$sniff_helper['css_required']['alignright'] = true;
			}
			if ( false !== strpos( $line, '.aligncenter' ) ) {
				$sniff_helper['css_required']['aligncenter'] = true;
			}
			if ( false !== strpos( $line, '.wp-caption' ) ) {
				$sniff_helper['css_required']['wp-caption'] = true;
			}
			if ( false !== strpos( $line, '.wp-caption-text' ) ) {
				$sniff_helper['css_required']['wp-caption-text'] = true;
			}
			if ( false !== strpos( $line, '.gallery-caption' ) ) {
				$sniff_helper['css_required']['gallery-caption'] = true;
			}
			if ( false !== strpos( $line, '.screen-reader-text' ) ) {
				$sniff_helper['css_required']['screen-reader-text'] = true;
			}
		}
	}

	/**
	 * Verify that CSS rules covering .format are found, at least once if the
	 * theme has a add_theme_support( 'post-format' ) call. This should become an
	 * error if the theme is tagged with post-formats.
	 * Note this is in conjunction with get_post_format_check() above.
	 * If found set associated check to true.
	 *
	 * @param array $file_content contains content of file in a line array.
	 */
	public function get_post_format_css_check( $file_content ) {
		global $sniff_helper;
		foreach ( $file_content as $line ) {
			if ( false !== strpos( $line, '.format' ) ) {
				$sniff_helper['post_format_support'] = true;
			}
		}
	}

	// ------------------ Reporting ------------------------
	/**
	 * Display errors and warnings.
	 *
	 * @param string $themedir contains the theme directory uri.
	 */
	public function display_errors_and_warnings( $themedir ) {
		global $sniff_helper;
		echo PHP_EOL;
		echo 'ThemeCheck Results: ' . $themedir . PHP_EOL;
		echo '----------------------------------------------------------------------' . PHP_EOL;
		echo 'Errors and warnings not related to file checks.' . PHP_EOL;
		echo '----------------------------------------------------------------------' . PHP_EOL;
		echo '  INFO   | Please do not use your own functions for features that are' . PHP_EOL;
		echo '         | supported with add_theme_support().' . PHP_EOL;

		/**
		 *  Comment reply errors.
		 *  Comments should always be supported by themes.
		 */
		if ( false === $sniff_helper['comment_reply']['enqueued'] ) {
			if ( true === $sniff_helper['comment_reply']['comment_reply_term'] ) {
				/**
				 * WARNING : Check that the comment_reply string or rather any HTML identifiers needed for the
				 *  JS script to work are present (need more info) (comments should always be supported by
				 *  themes, enqueuing the script alone is not enough)
				 */
				echo ' WARNING | Could not find the comment-reply script enqueued, however a' . PHP_EOL;
				echo '         | reference to \'comment-reply\' was found. Make sure that the' . PHP_EOL;
				echo '         | comment-reply script is being enqueued properly on singular ' . PHP_EOL;
				echo '         | pages.' . PHP_EOL;
			} else {
				/**
				 *  ERROR : Check that the comment reply script is being enqueued.
				 *  Comments should always be supported by themes.
				 */
				echo '  ERROR  | Could not find the comment-reply script enqueued.' . PHP_EOL;
			}
		}

		/**
		 *  ERROR : Check that comment pagination is supported. At least one of
		 * the following functions would need to be found in at least one of the
		 * template files, fail if none are found at all. paginate_comments_links(),
		 * the_comments_navigation(), the_comments_pagination(), next_comments_link()
		 * or previous_comments_link().
		 */
		if ( false === $sniff_helper['comments_pagination'] ) {
			echo '  ERROR  | The theme does not have comment pagination code in it.' . PHP_EOL;
			echo '         | Use paginate_comments_links() or the_comments_navigation()' . PHP_EOL;
			echo '         | or the_comments_pagination() or next_comments_link() and' . PHP_EOL;
			echo '         | previous_comments_link()to add comment pagination.' . PHP_EOL;
		}

		/**
		 * ERROR : Check that - normally in functions.php, but could be in another file - the global
		 * variable $content_width is set, so either in the global namespace using $content_width or
		 * within a function using global $content_width; $content_width =... or $GLOBALS['content_width'].
		 */
		if ( false === $sniff_helper['content_width'] ) {
			echo '  ERROR  | No content width has been defined. Example:' . PHP_EOL;
			echo '         | if ( ! isset( $content_width ) ) $content_width = 900;' . PHP_EOL;
		}

		/**
		 * ERROR : Verify that get_avatar() or wp_list_comments() is used at least once.
		 */
		if ( false === $sniff_helper['avatar_check'] ) {
			echo '  ERROR  | This theme does not seem to support the standard avatar' . PHP_EOL;
			echo '         | functions. Use get_avatar() or wp_list_comments() to add' . PHP_EOL;
			echo '         | this support.' . PHP_EOL;
		}

		/**
		 * WARNING : Verify that (register|wp)_nav_menu() is used at least once.
		 * This should become an error if the theme is tagged with custom-menu.
		 */
		if ( false === $sniff_helper['custom_menu_support'] ) {
			echo ' WARNING | No reference to nav_menu was found in the theme. Note that' . PHP_EOL;
			echo '         | if your theme has a menu bar, it is required to use the' . PHP_EOL;
			echo '         | WordPress nav_menu functionality for it.' . PHP_EOL;
		}

		/**
		 * ERROR : Verify that (get_post_format()|has_format() or CSS rules covering
		 * .format are found, at least once if the theme has a add_theme_support( 'post-format' )
		 * call. This should become an error if the theme is tagged with post-formats.
		 */
		if ( true === $sniff_helper['theme_supports']['post-formats'] ) {
			if ( false === $sniff_helper['post_format_support'] ) {
				echo '  ERROR  | Post format support was found. However it does not' . PHP_EOL;
				echo '         | appear they are supported because get_post_format(),' . PHP_EOL;
				echo '         | has_post_format(), or use of formats in the CSS were ' . PHP_EOL;
				echo '         | not found.' . PHP_EOL;
			}
		}

		/**
		 * ERROR : Check that post pagination is supported. At least one of the following
		 * functions would need to be found in at least one of the template files, fail if
		 * none are found at all; posts_nav_link(), paginate_links(), the_posts_navigation(),
		 * the_posts_pagination(), next_posts_link() or previous_posts_link().
		 */
		if ( false === $sniff_helper['post_pagination'] ) {
			echo '  ERROR  | The theme does not have post pagination code in it.' . PHP_EOL;
			echo '         | Use posts_nav_link() or paginate_links() or' . PHP_EOL;
			echo '         | the_posts_pagination() or the_posts_navigation() or' . PHP_EOL;
			echo '         | next_posts_link() and previous_posts_link()' . PHP_EOL;
			echo '         | to add post pagination.' . PHP_EOL;
		}

		/**
		 * ERROR : Verify that the_post_thumbnail() or get_the_post_thumbnail() or
		 * get_the_post_thumbnail_id() is found at least once if the theme has
		 * a add_theme_support( 'post-thumbnails' ) call. This should become an error if the theme
		 * is tagged with featured-image.
		 */
		if ( true === $sniff_helper['theme_supports']['featured-images'] ) {
			if ( false === $sniff_helper['post_thumbnail_support'] ) {
				echo '  ERROR  | Post thumbnail support was found. However' . PHP_EOL;
				echo '         | the_post_thumbnail() or get_the_post_thumbnail() or' . PHP_EOL;
				echo '         | get_the_post_thumbnail_id() were not found. It is' . PHP_EOL;
				echo '         | recommended that the theme implement this functionality' . PHP_EOL;
				echo '         | instead of using custom fields for thumbnails.' . PHP_EOL;
			}
		}

		/**
		 * ERROR : Check that post tags are supported in the theme. At least one of the following
		 * functions would need to be found in at least one of the template files, fail if none
		 * are found at all. the_tags(), get_the_tag_list(), get_the_term_list()
		 */
		if ( false === $sniff_helper['post_tags_support'] ) {
			echo '  ERROR  | This theme does not seem to display tags. Modify it to' . PHP_EOL;
			echo '         | display tags in appropriate locations. Either the_tags() or' . PHP_EOL;
			echo '         | get_the_tag_list() or get_the_term_list() are required.' . PHP_EOL;
		}

		/**
		 * WARNING : Check if at least one call to register_sidebar() or dynamic_sidebar() is made.
		 */
		if ( false === $sniff_helper['sidebar_support']['register_sidebar_used'] && false === $sniff_helper['sidebar_support']['dynamic_sidebar_used'] ) {
			echo ' WARNING | This theme contains no sidebars/widget areas.' . PHP_EOL;
		}

		/**
		 * ERROR : If a call to register_sidebar() is found, make sure there is at
		 * least one call to dynamic_sidebar().
		 */
		if ( true === $sniff_helper['sidebar_support']['register_sidebar_used'] && false === $sniff_helper['sidebar_support']['dynamic_sidebar_used'] ) {
			echo '  ERROR  | The theme appears to use register_sidebar() but' . PHP_EOL;
			echo '         | no dynamic_sidebar() was found.' . PHP_EOL;
		}

		/**
		 * ERROR : If a call to dynamic_sidebar() is found, make sure there is at
		 * least one call to register_sidebar().
		 */
		if ( false === $sniff_helper['sidebar_support']['register_sidebar_used'] && true === $sniff_helper['sidebar_support']['dynamic_sidebar_used'] ) {
			echo '  ERROR  | The theme appears to use dynamic_sidebars() but ' . PHP_EOL;
			echo '         | no register_sidebar() was found.' . PHP_EOL;
		}

		/**
		 * ERROR : Check that the register_sidebar() function is called with an
		 * add_action( 'widget_init', ... ) call.
		 */
		if ( true === $sniff_helper['sidebar_support']['register_sidebar_used'] && false === $sniff_helper['sidebar_support']['widgets_init_used'] ) {
			echo '  ERROR  | Sidebars need to be registered in a custom function hooked ' . PHP_EOL;
			echo '         | to the widgets_init action' . PHP_EOL;
		}

		/**
		 * ERROR | Check for a number of function calls which each theme has to contain.
		 */
		if ( false === $sniff_helper['basic_function_calls']['wp_footer'] ) {
			echo '  ERROR  | wp_footer() is required immediately above </body> tag.' . PHP_EOL;
		}
		if ( false === $sniff_helper['basic_function_calls']['wp_head'] ) {
			echo '  ERROR  | wp_head() is required immediately above </head> tag.' . PHP_EOL;
		}
		if ( false === $sniff_helper['basic_function_calls']['language_attributes'] ) {
			echo '  ERROR  | language_attributes() is required after DOCTYPE in header.php' . PHP_EOL;
		}
		if ( false === $sniff_helper['basic_function_calls']['charset'] ) {
			echo '  ERROR  | There must be a charset defined in the Content-Type or the' . PHP_EOL;
			echo '         | meta charset tag in the head.' . PHP_EOL;
		}
		if ( false === $sniff_helper['basic_function_calls']['automatic_feed_links'] ) {
			echo '  ERROR  | add_theme_support(\'automatic-feed-links\') is required' . PHP_EOL;
		}
		if ( false === $sniff_helper['basic_function_calls']['comments_template'] ) {
			echo '  ERROR  | comments_template() is required but not found.' . PHP_EOL;
		}
		if ( false === $sniff_helper['basic_function_calls']['wp_list_comments'] ) {
			echo '  ERROR  | wp_list_comments() is required but not found.' . PHP_EOL;
		}
		if ( false === $sniff_helper['basic_function_calls']['comment_form'] ) {
			echo '  ERROR  | comment_form() is required but not found.' . PHP_EOL;
		}
		if ( false === $sniff_helper['basic_function_calls']['body_class'] ) {
			echo '  ERROR  | body_class() is required in the <body> tag.' . PHP_EOL;
		}
		if ( false === $sniff_helper['basic_function_calls']['wp_link_pages'] ) {
			echo '  ERROR  | wp_link_pages() is required but not found.' . PHP_EOL;
		}
		if ( false === $sniff_helper['basic_function_calls']['post_class'] ) {
			echo '  ERROR  | post_class() is required but not found.' . PHP_EOL;
		}

		/**
		 * ERROR : Check if a number of specific CSS identifiers have been given styles in
		 * any of the CSS files.
		 */
		if ( false === $sniff_helper['css_required']['sticky'] ) {
			echo '  ERROR  | sticky class is required but not found' . PHP_EOL;
		}
		if ( false === $sniff_helper['css_required']['bypostauthor'] ) {
			echo '  ERROR  | bypostauthor class is required but not found' . PHP_EOL;
		}
		if ( false === $sniff_helper['css_required']['alignleft'] ) {
			echo '  ERROR  | alignleft class is required but not found' . PHP_EOL;
		}
		if ( false === $sniff_helper['css_required']['alignright'] ) {
			echo '  ERROR  | alignright class is required but not found' . PHP_EOL;
		}
		if ( false === $sniff_helper['css_required']['aligncenter'] ) {
			echo '  ERROR  | aligncenter class is required but not found' . PHP_EOL;
		}
		if ( false === $sniff_helper['css_required']['wp-caption'] ) {
			echo '  ERROR  | wp-caption class is required but not found' . PHP_EOL;
		}
		if ( false === $sniff_helper['css_required']['wp-caption-text'] ) {
			echo '  ERROR  | wp-caption-text class is required but not found' . PHP_EOL;
		}
		if ( false === $sniff_helper['css_required']['gallery-caption'] ) {
			echo '  ERROR  | gallery-caption class is required but not found' . PHP_EOL;
		}
		if ( false === $sniff_helper['css_required']['screen-reader-text'] ) {
			echo '  ERROR  | screen-reader-text class is required but not found' . PHP_EOL;
		}

		/**
		 * ERROR : Check that the theme contains a DOCTYPE headers somewhere.
		 */
		if ( false === $sniff_helper['doctype'] ) {
			echo '  ERROR  | DOCTYPE declaration required in header.' . PHP_EOL;
		}

		/**
		 * ERROR : index.php is required.
		 */
		if ( false === $sniff_helper['index_file_used'] ) {
			echo '  ERROR  | index.php file is required.' . PHP_EOL;
		}

		/**
		 * ERROR : index.php is required.
		 */
		if ( false === $sniff_helper['style_file_used'] ) {
			echo '  ERROR  | style.css file is required.' . PHP_EOL;
		}

		/**
		 * WARNING : readme.txt or readme.md recommended
		 */
		if ( false === $sniff_helper['readme_file_used'] ) {
			echo ' WARNING | Either a readme.txt or a readme.md is recommended.' . PHP_EOL;
			echo '         | This file should be in the theme root directory.' . PHP_EOL;
		}

		/**
		 * ERROR : Either a screenshot.png or screenshot.jpg is required.
		 */
		if ( false === $sniff_helper['screenshot']['found'] ) {
			echo '  ERROR  | Either a screenshot.png or screenshot.jpg is required.' . PHP_EOL;
		}

		/**
		 * ERROR : width must be less then 1200 px
		 */
		if ( false === $sniff_helper['screenshot']['less_than_1200_wide'] &&  true === $sniff_helper['screenshot']['found'] ) {
			echo '  ERROR  | Screenshot width must be 1200px or less.' . PHP_EOL;
		}

		/**
		 * ERROR : height must be less then 900 px
		 */
		if ( false === $sniff_helper['screenshot']['less_than_900_high'] &&  true === $sniff_helper['screenshot']['found'] ) {
			echo '  ERROR  | Screenshot height must be 900px or less.' . PHP_EOL;
		}

		/**
		 * ERROR : aspect ratio must be 4:3.
		 */
		if ( false === $sniff_helper['screenshot']['aspect_ratio_4_by_3'] &&  true === $sniff_helper['screenshot']['found'] ) {
			echo '  ERROR  | Screenshot aspect ratio must be 4:3.' . PHP_EOL;
		}

		/**
		 * WARNING : unable to obtain image details.
		 */
		if ( false !== $sniff_helper['screenshot']['details_not_found'] &&  true === $sniff_helper['screenshot']['found'] ) {
			echo ' WARNING | Image details were not found.' . PHP_EOL;
			echo '         | Please check to ensure max dimensions of 1200 x 900 px.' . PHP_EOL;
			echo '         | Aspect ratio must be 4:3.' . PHP_EOL;
		}

		// Closing line.
		echo '----------------------------------------------------------------------' . PHP_EOL;
	}
}
