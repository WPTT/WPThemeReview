// phpcs:set WPThemeReview.CoreFunctionality.PrefixAllGlobals prefixes[] my_theme
<?php

$my_theme_var = 123; // OK, prefixed.
$var = 'Value'; // Error. Not in a template file.

// phpcs:set WPThemeReview.CoreFunctionality.PrefixAllGlobals prefixes[]
