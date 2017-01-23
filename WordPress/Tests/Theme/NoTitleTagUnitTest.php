<?php
/**
 * Unit test class for WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Unit test class for the NoTitleTag sniff.
 *
 * @package WPCS\WordPressCodingStandards
 * @since   0.xx.0
 */
class WordPress_Tests_Theme_NoTitleTagUnitTest extends AbstractSniffUnitTest {

	/**
	 * Returns the lines where errors should occur.
	 *
	 * @return array <int line number> => <int number of errors>
	 */
	public function getErrorList() {
		return array(
			7 => 1,
			9 => 1,
			19 => 1,
			24 => 1,
			26 => 1,
			28 => 1,
			// PHP 5.2 has an issue tokenizing `<s` so splits the string into two.
			30 => ( PHP_VERSION_ID >= 50300 ) ? 1 : 2,
			34 => 1,
			37 => 1,
			40 => 1,
			43 => 1,
			47 => ( PHP_VERSION_ID >= 50300 ) ? 1 : 0, // PHPCS on PHP 5.2 does not recognize T_NOWDOC.
			50 => ( PHP_VERSION_ID >= 50300 ) ? 1 : 0, // PHPCS on PHP 5.2 does not recognize T_NOWDOC.
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

} // End class.
