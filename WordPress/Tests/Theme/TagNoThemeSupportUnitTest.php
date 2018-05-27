<?php
/**
 * Unit test class for WordPress Coding Standard.
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @link     https://make.wordpress.org/core/handbook/best-practices/coding-standards/
 */

/**
 * WordPress_Tests_Theme_TagNoThemeSupportUnitTest
 *
 * Verify that an add_theme_support() call is made for any feature the
 * theme has been tagged with from the following list: custom-background,
 * custom-header, custom-menu, featured-images/post-thumbnails, post-formats,
 * custom-logo.
 *
 * This unit test will not work without having access to a style.css file in the same folder.
 * Both the style.css and the .inc test files would then be manipulated for proper testing.
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @author   khacoder
 */
class WordPress_Tests_Theme_TagNoThemeSupportUnitTest extends AbstractSniffUnitTest {

	/**
	 * Returns the lines where errors should occur.
	 *
	 * The key of the array should represent the line number and the value
	 * should represent the number of errors that should occur on that line.
	 *
	 * @return array(int => int)
	 */
	public function getErrorList() {
		return array();

	}

	/**
	 * Returns the lines where warnings should occur.
	 *
	 * The key of the array should represent the line number and the value
	 * should represent the number of warnings that should occur on that line.
	 *
	 * @return array(int => int)
	 */
	public function getWarningList() {
		return array();

	} // end getWarningList()

} // end class
