<?php
/**
 * Unit test class for WPThemeReview Coding Standard.
 *
 * @package WPTRT\WPThemeReview
 * @link    https://github.com/WPTRT/WPThemeReview
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WPThemeReview\Tests\PluginTerritory;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Unit test class for the AdminBarRemoval sniff.
 *
 * @since WPCS 0.3.0
 * @since WPCS 0.13.0 Class name changed: this class is now namespaced.
 *
 * @since TRTCS 0.1.0 As this sniff will be removed from WPCS in version 2.0, the
 *                    sniff has been cherry-picked into the WPThemeReview standard.
 */
class AdminBarRemovalUnitTest extends AbstractSniffUnitTest {

	/**
	 * Returns the lines where errors should occur.
	 *
	 * @param string $testFile The name of the file being tested.
	 *
	 * @return array <int line number> => <int number of errors>
	 */
	public function getErrorList( $testFile = '' ) {

		switch ( $testFile ) {
			case 'AdminBarRemovalUnitTest.inc':
				return [
					3   => 1,
					6   => 1,
					9   => 1,
					12  => 1,
					13  => 1,
					19  => 1,
					20  => 1,
					21  => 1,
					26  => 1,
					32  => 1,
					56  => 1,
					57  => 1,
					58  => 1,
					68  => 1,
					69  => 1,
					70  => 1,
					81  => 1,
					82  => 1,
					83  => 1,
					92  => 1,
					103 => 1,
					104 => 1,
					105 => 1,
				];

			case 'AdminBarRemovalUnitTest.css':
				return [
					15 => 1,
					16 => 1,
					17 => 1,
					22 => 1,
					23 => 1,
					24 => 1,
					29 => 1,
					30 => 1,
					31 => 1,
					38 => 1,
					39 => 1,
					40 => 1,
					46 => 1,
					47 => 1,
					48 => 1,
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
