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
 * Unit test class for the Theme\RestrictedPHPFunctions sniff.
 *
 * @package WPCS\WordPressCodingStandards
 * @since   0.xx.0
 */
class RestrictedPHPFunctionsUnitTest extends AbstractSniffUnitTest {

	/**
	 * Returns the lines where errors should occur.
	 *
	 * @return array(int => int)
	 */
	public function getErrorList() {
		return array(
			4  => 1,
			5  => 1,
			6  => 1,
			7  => 1,
			8  => 1,
			9  => 1,
			12 => 1,
			15 => 1,
			16 => 1,
			17 => 1,
			18 => 1,
			19 => 1,
			20 => 1,
		);
	}

	/**
	 * Returns the lines where warnings should occur.
	 *
	 * @return array(int => int)
	 */
	public function getWarningList() {
		return array();
	}

}
