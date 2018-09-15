<?php
/**
 * Bootstrap file for running the tests.
 *
 * - Load the PHPCS PHPUnit bootstrap file providing cross-version PHPUnit support.
 *   {@link https://github.com/squizlabs/PHP_CodeSniffer/pull/1384}
 * - Load the WPThemeReview autoload file.
 *   This file loads the WPCS alias file which is needed as several WPThemeReview
 *   sniffs extend WPCS sniffs.
 *
 * {@internal The PHPCS autoloader needs to be loaded first, so as to allow their
 * auto-loader to find the classes WPCS aliases for PHPCS 3.x.
 * This aliasing has to be done before any of the test classes are loaded by the
 * PHPCS native unit test suite to prevent fatal errors.}}
 *
 * @package WPTRT\WPThemeReview
 * @link    https://github.com/WPTRT/WPThemeReview
 * @license https://opensource.org/licenses/MIT MIT
 *
 * @since   WPCS 0.13.0
 * @since   TRTCS 0.1.0 Adjusted for use in the WPThemeReview standard.
 */

if ( ! \defined( 'PHP_CODESNIFFER_IN_TESTS' ) ) {
	define( 'PHP_CODESNIFFER_IN_TESTS', true );
}

$ds          = DIRECTORY_SEPARATOR;
$projectRoot = dirname( __DIR__ ) . $ds;

/*
 * Load the necessary PHPCS files.
 */
// Get the PHPCS dir from an environment variable.
$phpcsDir          = getenv( 'PHPCS_DIR' );
$composerPHPCSPath = $projectRoot . 'vendor' . $ds . 'squizlabs' . $ds . 'php_codesniffer';

if ( false === $phpcsDir && is_dir( $composerPHPCSPath ) ) {
	// PHPCS installed via Composer.
	$phpcsDir = $composerPHPCSPath;
} elseif ( false !== $phpcsDir ) {
	/*
	 * PHPCS in a custom directory.
	 * For this to work, the `PHPCS_DIR` needs to be set in a custom `phpunit.xml` file.
	 */
	$phpcsDir = realpath( $phpcsDir );
}

// Try and load the PHPCS autoloader.
if ( false !== $phpcsDir
	&& file_exists( $phpcsDir . $ds . 'autoload.php' )
	&& file_exists( $phpcsDir . $ds . 'tests' . $ds . 'bootstrap.php' )
) {
	require_once $phpcsDir . $ds . 'autoload.php';
	require_once $phpcsDir . $ds . 'tests' . $ds . 'bootstrap.php'; // PHPUnit 6.x+ support.

} else {
	echo 'Uh oh... can\'t find PHPCS.

If you use Composer, please run `composer install`.
Otherwise, make sure you set a `PHPCS_DIR` environment variable in your phpunit.xml file
pointing to the PHPCS directory.

Please read the contributors guidelines for more information:
https://is.gd/contributing2WPCS
';

	die( 1 );
}

/*
 * Load the WPThemeReview autoload file.
 */
require_once $projectRoot . 'autoload.php';

// Clean up.
unset( $ds, $projectRoot, $phpcsDir, $composerPHPCSPath );
