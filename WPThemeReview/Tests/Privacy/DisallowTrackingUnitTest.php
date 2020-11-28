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
 * Unit test class for the DisallowTracking sniff.
 *
 * @since 0.2.2
 */
class DisallowTrackingUnitTest extends AbstractSniffUnitTest {

	/**
	 * Returns the lines where errors should occur.
	 *
	 * @param string $testFile The name of the file being tested.
	 * @return array <int line number> => <int number of errors>
	 */
	public function getErrorList( $testFile = '' ) {

		switch ( $testFile ) {
			case 'DisallowTrackingUnitTest.inc':
				return [
					5  => 1,
					13 => 1,
					30 => 1,
					52 => 1,
					61 => 1,
					65 => 1,
				];

			case 'DisallowTrackingUnitTest.js':
				return [
					3 => 1,
					6 => 1,
				];

			case 'DisallowTrackingUnitTest.css':
				return [
					2 => 1,
				];

			default:
				return [];
		}
	}

	/**
	 * Returns the lines where warnings should occur.
	 *
	 * @return array <int line number> => <int number of warnings>
	 */
	public function getWarningList() {
		return [];
	}

}
