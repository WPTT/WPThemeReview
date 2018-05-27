<?php
/**
 * Unit test class for WordPress Coding Standard.
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @link     https://make.wordpress.org/core/handbook/best-practices/coding-standards/
 */

/**
 * WordPress_Tests_Theme_NoOrgUriUnitTest
 *
 * Error : Verify in style.css that the Theme URI does not point to wordpress.org
 * (with predefined list of themes which are exempt and live under the
 * wordpressdotorg user or have a check based on Author name.
 * We allow .org user profiles as Author URI, so only check the Theme URI.
 * We also allow WordPress.com links.
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @author   khacoder
 */
class WordPress_Tests_Theme_AccessibilityTagCheckUnitTest extends AbstractSniffUnitTest {

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
