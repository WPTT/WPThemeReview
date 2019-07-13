<?php
/**
 * Unit test class for WPThemeReview Coding Standard.
 *
 * @package WPTRT\WPThemeReview
 * @link    https://github.com/WPTRT/WPThemeReview
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WPThemeReview\Tests\Privacy;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Unit test class for the ShortenedURLs sniff.
 *
 * @since 0.2.0
 */
class ShortenedURLsUnitTest extends AbstractSniffUnitTest {

	/**
	 * Returns the lines where errors should occur.
	 *
	 * @param string $testFile The name of the file being tested.
	 * @return array <int line number> => <int number of errors>
	 */
	public function getErrorList( $testFile = '' ) {

		switch ( $testFile ) {
			case 'ShortenedURLsUnitTest.inc':
				return array(
					10 => 1,
					12 => 1,
					14 => 1,
					15 => 1,
					17 => 1,
					21 => 1,
					28 => 1,
					33 => 1,
					38 => 1,
					43 => 1,
					48 => 1,
					55 => 1,
					56 => 1,
					57 => 1,
					60 => 2,
				);

			case 'ShortenedURLsUnitTest.js':
				return array(
					2  => 1,
					6  => 1,
					8  => 1,
					15 => 1,
					19 => 2,
				);

			case 'ShortenedURLsUnitTest.css':
				return array(
					1 => 1,
					2 => 1,
				);

			default:
				return array();
		}
	}

	/**
	 * Returns the lines where warnings should occur.
	 *
	 * @return array <int line number> => <int number of warnings>
	 */
	public function getWarningList() {
		return array();
	}

}
