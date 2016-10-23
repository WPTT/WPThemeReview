<?php

include( get_template_directory() . '/searchform.php' ); // Error.
include( get_template_directory() . "/searchform.php" ); // Error.

// searchform.php OK

$path = get_template_directory() . '/searchform.php' ); // Error.
include $path;

$path = get_childtheme_directory() . "/searchform.php" ); // Error.
$path = get_childtheme_directory() . "/my-completely-different-searchform.php" ); // OK

$dummy_text_on_example_page = ".... so if you want to add an extra search form, just use `include searchform.php` somewhere in the template code..."; // OK
