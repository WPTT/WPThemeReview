// phpcs:set WPThemeReview.CoreFunctionality.PrefixAllGlobals prefixes[] my_theme
// phpcs:set WPThemeReview.CoreFunctionality.PrefixAllGlobals allowed_folders[] template-parts,templates,partials,page-templates
<?php
$my_theme_var = 123; // OK, prefixed.
$var = 'Value'; // OK, file in allowed folder.

// phpcs:set WPThemeReview.CoreFunctionality.PrefixAllGlobals prefixes[]
// phpcs:set WPThemeReview.CoreFunctionality.PrefixAllGlobals allowed_folders[]
