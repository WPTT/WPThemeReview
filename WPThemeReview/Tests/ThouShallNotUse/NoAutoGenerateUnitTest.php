<?php
/**
 * Unit test class for WPThemeReview Coding Standard.
 *
 * @package WPTRT\WPThemeReview
 * @link    https://github.com/WPTRT/WPThemeReview
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WPThemeReview\Tests\ThouShallNotUse;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Unit test class for the Theme_NoAutoGenerate sniff.
 *
 * @package WPCS\WordPressCodingStandards
 * @since   0.xx.0
 */
class NoAutoGenerateUnitTest extends AbstractSniffUnitTest {

	/**
	 * Returns the lines where errors should occur.
	 *
	 * @param string $testFile The name of the file being tested.
	 *
	 * @return array <int line number> => <int number of errors>
	 */
	public function getErrorList( $testFile = '' ) {
		switch ( $testFile ) {
			case 'NoAutoGenerateUnitTest.inc':
				return array(
					2  => 1,
					3  => 1,
					6  => 1,
					8  => 1,
					9  => 1,
					11 => 1,
					13 => 1,
					14 => 1,
					15 => 1,
					22 => 1,
					39 => 2,
					45 => 2,
				);

			case 'NoAutoGenerateUnitTest.css':
				return array(
					3  => 1,
					4  => 1,
					5  => 1,
					9  => 1,
					10 => 1,
					13 => 1,
					14 => 1,
					15 => 1,
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
