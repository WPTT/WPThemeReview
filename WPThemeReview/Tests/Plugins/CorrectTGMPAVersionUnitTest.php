<?php
/**
 * Unit test class for WPThemeReview Coding Standard.
 *
 * @package WPTRT\WPThemeReview
 * @link    https://github.com/WPTRT/WPThemeReview
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WPThemeReview\Tests\Plugins;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Unit test class for the Correct TGMPA Version sniff.
 *
 * @package WPCS\WordPressCodingStandards
 * @since   0.xx.0
 */
class CorrectTGMPAVersionUnitTest extends AbstractSniffUnitTest {

	/**
	 * Get a list of all test files to check.
	 *
	 * @param string $testFileBase The base path that the unit tests files will have.
	 *
	 * @return string[]
	 */
	protected function getTestFiles( $testFileBase ) {
		$sep        = DIRECTORY_SEPARATOR;
		$test_files = glob( __DIR__ . $sep . 'TGMPA' . $sep . 'CorrectVersionTests{ ' . $sep . ',' . $sep . '*' . $sep . '}*.inc', GLOB_BRACE );

		if ( ! empty( $test_files ) ) {
			return $test_files;
		}

		return array( $testFileBase . 'inc' );
	}

	/**
	 * Returns the lines where errors should occur.
	 *
	 * @param string $testFile The name of the file being tested.
	 * @return array <int line number> => <int number of errors>
	 */
	public function getErrorList( $testFile = '' ) {

		switch ( $testFile ) {
			// Bad versions.
			case 'class-tgm-plugin-activation-unstable.inc':
			case 'prefixed-tgm-plugin-activation.inc':
			case 'prefixed-tgm-plugin-activation.2.inc':
			case 'manual-search-and-replace.inc':
			case 'manual-search-and-replace.2.inc':
				return array(
					1 => 1,
				);

			// Official versions.
			case 'class-tgm-plugin-activation-2.0.0.inc':
			case 'class-tgm-plugin-activation-2.3.4.inc':
			case 'class-tgm-plugin-activation-2.5.2.inc':
				return array(
					1 => 1,
				);

			// Renamed official versions.
			case 'auto-install-1.0.0.inc':
			case 'auto-install-1.1.0.inc':
			case 'renamed-plugin-activation-2.0.0.inc':
			case 'renamed-plugin-activation-2.1.0.inc':
			case 'renamed-plugin-activation-2.1.1.inc':
			case 'renamed-plugin-activation-2.2.0.inc':
			case 'renamed-plugin-activation-2.2.1.inc':
			case 'renamed-plugin-activation-2.2.2.inc':
			case 'renamed-plugin-activation-2.3.0.inc':
			case 'renamed-plugin-activation-2.3.1.inc':
			case 'renamed-plugin-activation-2.3.2.inc':
			case 'renamed-plugin-activation-2.3.3.inc':
			case 'renamed-plugin-activation-2.3.4.inc':
			case 'renamed-plugin-activation-2.3.5.inc':
			case 'renamed-plugin-activation-2.3.6.inc':
			case 'renamed-plugin-activation-2.4.0.inc':
			case 'renamed-plugin-activation-2.4.1.inc':
			case 'renamed-plugin-activation-2.4.2.inc':
			case 'renamed-plugin-activation-2.5.0.inc':
			case 'renamed-plugin-activation-2.5.1.inc':
			case 'renamed-plugin-activation-2.5.2.inc':
			case 'renamed-plugin-activation-2.6.0.inc':
				return array(
					1 => 1,
				);

			default:
				return array();
		}
	}

	/**
	 * Returns the lines where warnings should occur.
	 *
	 * @param string $testFile The name of the file being tested.
	 * @return array <int line number> => <int number of warnings>
	 */
	public function getWarningList( $testFile = '' ) {
		switch ( $testFile ) {
			// Correct flavour check.
			case 'tgmpa-2.6.1-themeforest-bad-official.inc':
			case 'tgmpa-2.6.1-themeforest-bad-wporg.inc':
			case 'tgmpa-2.6.1-wporg-bad-official.inc':
			case 'tgmpa-2.6.1-wporg-bad-themeforest.inc':
				return array(
					1 => 1,
				);

			default:
				return array();
		}
	}

}
