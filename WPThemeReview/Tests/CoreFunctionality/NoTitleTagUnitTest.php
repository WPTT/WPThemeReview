<?php
/**
 * Unit test class for WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WPThemeReview\Tests\CoreFunctionality;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Unit test class for the NoTitleTag sniff.
 *
 * @package WPCS\WordPressCodingStandards
 * @since   0.xx.0
 */
class NoTitleTagUnitTest extends AbstractSniffUnitTest {

	/**
	 * Returns the lines where errors should occur.
	 *
	 * @return array <int line number> => <int number of errors>
	 */
	public function getErrorList() {
		return array(
			7  => 1,
			9  => 1,
			19 => 1,
			24 => 1,
			26 => 1,
			28 => 1,
			30 => 1,
			34 => 1,
			37 => 1,
			40 => 1,
			43 => 1,
			47 => 1,
			50 => 1,
		);
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
