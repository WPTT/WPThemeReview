<?php

include( get_template_directory() . '/searchform.php' ); // Error.
include( get_template_directory() . "/footer.php" ); // Error.

$path = get_template_directory() . '/header.php' ); // Error.
include $path;

$path = get_childtheme_directory() . "/sidebar.php" ); // Error.
include( get_template_directory() . "/footer-special.php" ); // Error.
$path = get_childtheme_directory() . "/sidebar-special.php" ); // Error.
require 'header-special.php'; // Error.

// searchform.php OK
$path = get_childtheme_directory() . "/my-completely-different-searchform.php" ); // OK
$path = get_childtheme_directory() . "/searchform-special.php" ); // OK

$dummy_text_on_example_page = ".... so if you want to add an extra search form, just use `include searchform.php` somewhere in the template code..."; // OK
