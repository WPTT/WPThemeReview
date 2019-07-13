<?php
/**
 * Unit test class for WPThemeReview Coding Standard.
 *
 * @package WPTRT\WPThemeReview
 * @link    https://github.com/WPTRT/WPThemeReview
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WPThemeReview\Tests\Templates;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Unit test class for the RequiredHTMLAttributeFunctions sniff.
 *
 * @since 0.2.0
 */
class RequiredHTMLAttributeFunctionsUnitTest extends AbstractSniffUnitTest {

	/**
	 * Get a list of all test files to check.
	 *
	 * @param string $testFileBase The base path that the unit tests files will have.
	 *
	 * @return string[]
	 */
	protected function getTestFiles( $testFileBase ) {
		$sep        = \DIRECTORY_SEPARATOR;
		$test_files = glob( dirname( $testFileBase ) . $sep . 'RequiredHTMLAttributeFunctionsTests{' . $sep . ',' . $sep . '*' . $sep . '}*.inc', \GLOB_BRACE );

		if ( ! empty( $test_files ) ) {
			return $test_files;
		}
		return array( $testFileBase . '.inc' );
	}

	/**
	 * Returns the lines where errors should occur.
	 *
	 * @param string $testFile The name of the file being tested.
	 *
	 * @return array <int line number> => <int number of errors>
	 */
	public function getErrorList( $testFile = '' ) {
		switch ( $testFile ) {
			case 'required-template-attributes-first.inc':
				return array(
					7  => 1,
					8  => 1,
					10 => 1,
					11 => 1,
					13 => 1,
					22 => 1,
					23 => 1,
					24 => 1,
					25 => 1,
					26 => 1,
					27 => 1,
					38 => 1,
				);
			case 'required-template-attributes-second.inc':
				return array(
					47 => 1,
					51 => 1,
					54 => 1,
					56 => 1,
					59 => 1,
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
