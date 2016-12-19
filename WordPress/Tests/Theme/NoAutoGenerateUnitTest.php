<?php
/**
 * Unit test class for WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Unit test class for the Theme_NoAutoGenerate sniff.
 *
 * @package WPCS\WordPressCodingStandards
 * @since   0.xx.0
 */
class WordPress_Tests_Theme_NoAutoGenerateUnitTest extends AbstractSniffUnitTest {

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
				);
				break;
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
				break;
			default:
				return array();
				break;
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

} // End class.
