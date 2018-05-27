<?php
/**
 * Unit test class for WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Unit test class for the NonPrintableCheck sniff.
 *
 * @package WPCS\WordPressCodingStandards
 * @since   0.xx.0
 */
class WordPress_Tests_Theme_NonPrintableCheckUnitTest extends AbstractSniffUnitTest {

	/**
	 * Returns the lines where errors should occur.
	 *
	 * @param string $testFile The name of the file being tested.
	 *
	 * @return array <int line number> => <int number of errors>
	 */
	public function getErrorList( $testFile = '' ) {
		switch ( $testFile ) {
			case 'NonPrintableCheckUnitTest.css':
				return array(
					3 => 1,
					5 => 1,
					6 => 1,
					7 => 1,
				);
			case 'NonPrintableCheckUnitTest.inc':
				return array(
					1  => 1,
					2  => 1,
					3  => 1,
					4  => 1,
					5  => 1,
					6  => 1,
					8  => 1,
					10 => 1,
					11 => 1,
					13 => 1,
					14 => 1,
					18 => 1,
					19 => 1,
				);
			case 'NonPrintableCheckUnitTest.js':
				return array(
					2 => 1,
					5 => 1,
					8 => 1,
				);
			default:
				return array();
		}   // End switch().

	}

	/**
	 * Returns the lines where warnings should occur.
	 *
	 * @return array <int line number> => <int number of warnings>
	 */
	public function getWarningList() {
		return array();
	}

} // End class.
