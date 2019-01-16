<?php
/**
 * WPThemeReview Coding Standard autoload file.
 *
 * Load the WPCS alias/autoload file.
 * This file is needed as several WPThemeReview sniffs extend WPCS sniffs.
 *
 * {@internal Once WPCS drops PHPCS 2.x support, it may be possible to remove
 * the WPCS alias/autoload file. Needs to be reviewed/checked if and when.}}
 *
 * @package WPTRT\WPThemeReview
 * @link    https://github.com/WPTRT/WPThemeReview
 * @license https://opensource.org/licenses/MIT MIT
 * @since   0.2.0 Removed PHPCSAliases block require
 * @since   0.1.0
 */

namespace WPThemeReview;

$ds          = DIRECTORY_SEPARATOR;
$projectRoot = __DIR__ . $ds;

/*
 * Load the WPCS autoload file.
 */
// Get the WPCS dir from an environment variable.
$wpcsDir                 = getenv( 'WPCS_DIR' );
$composerWPCSPath        = $projectRoot . 'vendor' . $ds . 'wp-coding-standards' . $ds . 'wpcs';
$composerWPCSPathProject = $projectRoot . '..' . $ds . '..' . $ds . 'wp-coding-standards' . $ds . 'wpcs';

if ( false === $wpcsDir && is_dir( $composerWPCSPath ) ) {
	// WPCS installed via Composer.
	$wpcsDir = $composerWPCSPath;
} elseif ( false === $wpcsDir && is_dir( $composerWPCSPathProject ) ) {
	// TRTCS + WPCS installed via Composer.
	$wpcsDir = $composerWPCSPathProject;
} elseif ( false !== $wpcsDir ) {
	/*
	 * WPCS in a custom directory [1].
	 * For this to work, the `WPCS_DIR` needs to be set as an environment variable.
	 */
	$wpcsDir = realpath( $wpcsDir );
} elseif ( file_exists( $projectRoot . '.pathtowpcs' ) ) {
	/*
	 * WPCS in a custom directory [2].
	 * For this to work, a file called `.pathtowpcs` needs to be placed in the project
	 * root directory. The only content in the file should be the absolute path to
	 * the developers WPCS install.
	 */
	$wpcsPath = file_get_contents( $projectRoot . '.pathtowpcs' );
	if ( false !== $wpcsPath ) {
		$wpcsPath = trim( $wpcsPath );
		if ( file_exists( $wpcsPath ) ) {
			$wpcsDir = realpath( $wpcsPath );
		}
	}
}

// Clean up.
unset( $ds, $projectRoot, $wpcsDir, $composerWPCSPath, $composerWPCSPathProject, $wpcsPath );
