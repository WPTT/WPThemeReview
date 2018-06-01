<?php
/**
 * Unit test class for WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */
 
namespace WordPress\Tests\Theme;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;
/**
 * Unit test class for the NoSanitizeCallback sniff.
 *
 * @package WPCS\WordPressCodingStandards
 * @since   0.xx.0
 */
class NoSanitizeCallbackUnitTest extends AbstractSniffUnitTest {
	/**
	 * Returns the lines where errors should occur.
	 *
	 * @return array <int line number> => <int number of errors>
	 */
	public function getErrorList() {
		return array(
			12 => 1,
			13 => 1,
			15 => 1,
			27 => 1,
			33 => 1,
		);
	}
	/**
	 * Returns the lines where warnings should occur.
	 *
	 * @return array <int line number> => <int number of warnings>
	 */
	public function getWarningList() {
		return array(
		);
	}
} // End class.