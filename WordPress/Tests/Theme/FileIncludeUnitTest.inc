<?php

include( '/file.ext' ); // Warning.
include_once( '/file.ext' ); // Warning.
require( '/file.ext' ); // Warning.
require_once( '/file.ext' ); // Warning.
include dirname( __FILE__ ) . '/myfile.php'; // Warning.
require_once $path_to_file; // Warning.

// wp-load.php
include( '/wp-load.php' ); // Error.
include_once( '/wp-load.php' ); // Error.
require( '/wp-load.php' ); // Error.
require_once( '/wp-load.php' ); // Error.
include APBSPATH . '/wp-load.php'; // Error.

// admin.php
include( 'wp-admin/admin.php' ); // Error.
include_once( 'wp-admin/admin.php' ); // Error.
require( 'wp-admin/admin.php' ); // Error.
require_once( 'wp-admin/admin.php' ); // Error.
include APBSPATH . 'wp-admin/admin.php'; // Error.

// media.php
include( '/media.php' ); // Error.
include_once( '/media.php' ); // Error.
require( '/media.php' ); // Error.
require_once( '/media.php' ); // Error.
include APBSPATH . '/media.php'; // Error.

// plugin.php
include( '/plugin.php' ); // Error.
include_once( '/plugin.php' ); // Error.
require( '/plugin.php' ); // Error.
require_once( '/plugin.php' ); // Error.
include APBSPATH . '/plugin.php'; // Error.
