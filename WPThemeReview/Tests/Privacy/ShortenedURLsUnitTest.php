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
 * Unit test class for the NoUrlShorteners sniff.
 *
 * @since 0.2.0
 */
class NoUrlShortenersUnitTest extends AbstractSniffUnitTest {

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
					6  => 1,
					9  => 1,
					10 => 1,
					11 => 1,
					14 => 1,
					16 => 1,
					21 => 1,
					35 => 1,
					41 => 1,
					48 => 1,
				);

			case 'ShortenedURLsUnitTest.js':
				return array(
					2  => 1,
					6  => 1,
					14 => 1,
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
