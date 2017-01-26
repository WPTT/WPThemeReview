<?php

include('/wp-load.php'); // Warning.
include_once('/wp-load.php'); // Warning.
require('/wp-load.php'); // Warning.
require_once('/wp-load.php'); // Warning.
include APBSPATH . '/wp-load.php'; // Warning.
include('/admin.php'); // Warning.
include_once('/admin.php'); // Warning.
require('/admin.php'); // Warning.
require_once('/admin.php'); // Warning.
include APBSPATH . '/admin.php'; // Warning.
include('/media.php'); // Warning.
include_once('/media.php'); // Warning.
require('/media.php'); // Warning.
require_once('/media.php'); // Warning.
include APBSPATH . '/media.php'; // Warning.
include('/plugin.php'); // Warning.
include_once('/plugin.php'); // Warning.
require('/plugin.php'); // Warning.
require_once('/plugin.php'); // Warning.
include APBSPATH . '/plugin.php'; // Warning.
include $path_to_file; // Ok.
include_once $path_to_file; // Ok.
require $path_to_file; // Ok.
require_once $path_to_file; // Ok.
