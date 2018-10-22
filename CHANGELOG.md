# Change Log for the WPThemeReview PHP_CodeSniffer standard

All notable changes to this project will be documented in this file.

This projects adheres to [Semantic Versioning](https://semver.org/) and [Keep a CHANGELOG](https://keepachangelog.com/).

## [Unreleased]

_No documentation available about unreleased changes as of yet._

## [0.1.0]

### Added

#### Native sniffs
- `WPThemeReview.CoreFunctionality.FileInclude`: checks if a theme uses `include(_once)` or `require(_once)` when `get_template_part()` should be used. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/#core-functionality-and-features).
- `WPThemeReview.CoreFunctionality.NoDeregisterCoreScript`: checks if a theme deregisters core scripts (javascript). [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/#stylesheets-and-scripts).
- `WPThemeReview.CoreFunctionality.NoFavicon`: checks if a theme is hard coding favicons instead of using core implementation. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/#core-functionality-and-features).
- `WPThemeReview.CoreFunctionality.NoTitleTag`: checks if a theme is using a `<title>` tag instead of `add_theme_support( 'title-tag' )`. `<svg>` tag can use a `<title>` tag. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/#core-functionality-and-features).
- `WPThemeReview.PluginTerritory.AdminBarRemoval`: checks if a theme is removing the WP admin bar. This sniff was originally part of `WordPressCS`. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/#core-functionality-and-features).
- `WPThemeReview.PluginTerritory.ForbiddenFunctions`: checks if a theme is using functions that fall under plugin territory. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/#presentation-vs-functionality).
- `WPThemeReview.PluginTerritory.NoAddAdminPages`: checks if a theme is using `add_..._page()` functions, with the exception of `add_theme_page()`. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/theme-check-plugin/#admin-menu).
- `WPThemeReview.PluginTerritory.SessionFunctionsUsage`: Prevents the usage of the session functions in themes. This sniff was originally part of `WordPressCS`.
- `WPThemeReview.PluginTerritory.SessionVariableUsage`: Prevents the usage of the session variables in themes. This sniff was originally part of `WordPressCS`.
- `WPThemeReview.Plugins.CorrectTGMPAVersion`: verifies that if the [TGM Plugin Activation](http://tgmpluginactivation.com/) library is included, the correct version is used. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/theme-check-plugin/#admin-menu).
- `WPThemeReview.ThouShallNotUse.ForbiddenIframe`: checks if a theme is using `<iframe>`. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/theme-check-plugin/#info).
- `WPThemeReview.ThouShallNotUse.NoAutoGenerate`: checks if a theme has been generated using theme generators.

#### Other sniffs in the ruleset
- `PHPCompatibilityWP`: added as an entire ruleset, checking that the theme is compatible with PHP 5.2 and above.
- `Generic.PHP.DisallowShortOpenTag`: prohibits the usage of the PHP short open tags. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/theme-check-plugin/#additional-checks).
- `Generic.PHP.DisallowAlternativePHPTags`: disallows the usage of alternative PHP open tags (`<%` and similar).
- `Squiz.WhiteSpace.SuperfluousWhitespace.StartFile`: files starting with a PHP open tag shouldn't have a whitespace preceding it, to prevent possible `headers already sent` errors.
- `PSR2.Files.ClosingTag.NotAllowed`: files should omit the closing PHP tag at the end of a file, to prevent possible `headers already sent` errors.
- `Internal.LineEndings.Mixed`: mixed line endings are not allowed. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/theme-check-plugin/#line-endings).
- `Internal.Tokenizer.Exception`: minified scripts or files should have original files included. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/#stylesheets-and-scripts).
- `Generic.Files.ByteOrderMark`: no ByteOrderMark allowed - important to prevent issues with content being sent before headers.
- `Generic.CodeAnalysis.EmptyStatement`: prohibits empty statements in the code (empty conditionals for instance).
- `WordPress.CodeAnalysis.EmptyStatement`: prohibits empty PHP statements (empty PHP tags with no content or double semi-colons).
- `WordPress.WP.I18n`: check that the I18N functions are used correctly. This sniff can also check the text domain, provided it's passed to `PHPCS`. See the [documentation](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/wiki/Customizable-sniff-properties#internationalization-setting-your-text-domain) for more details.
- `WordPress.WP.EnqueuedResources`: hard coding of scripts and styles is prohibited. They should be enqueued.
- `WordPress.Security.PluginMenuSlug`: prevent path disclosure when using add_theme_page().
- `Generic.PHP.NoSilencedErrors`: usage of Error Control Operator `@` is forbidden in a theme.
- `WordPress.DB.RestrictedClasses`: the WP abstraction layer should be used to query database if needed.
- `WordPress.DB.RestrictedFunctions`: the WP abstraction layer should be used to query database if needed.
- `WordPress.DB.PreparedSQL`: all SQL queries should be prepared as close to the time of querying the database as possible.
- `WordPress.DB.PreparedSQLPlaceholders`: verify that placeholders in prepared queries are used correctly.
- `WordPress.Security.ValidatedSanitizedInput`: validate and/or sanitize untrusted data before using it.
- `WordPress.Security.EscapeOutput`: all untrusted data should be escaped before output - warning, since translations don't have to be escaped.
- `Generic.PHP.BacktickOperator`: prohibit the use of the backtick operator.
- `WordPress.WP.GlobalVariablesOverride`: prohibit overwriting of WordPress global variables.
- `Squiz.PHP.Eval.Discouraged`: prohibit the use of the eval() PHP language construct.
- `Generic.PHP.DiscourageGoto.Found`: prohibit the use of the `goto` PHP language construct.
- `WordPress.WP.DeprecatedClasses`: check for use of deprecated WordPress classes.
- `WordPress.WP.DeprecatedFunctions`: check for use of deprecated WordPress functions.
- `WordPress.WP.DeprecatedParameters`: check for use of deprecated WordPress function parameters.
- `WordPress.WP.DiscouragedConstants`: check for deprecated WordPress constants.
- `WordPress.NamingConventions.PrefixAllGlobals`: verify that everything in the global namespace is prefixed. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/#code). This rule will only work if a prefix is passed. See the [documentation](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/wiki/Customizable-sniff-properties#naming-conventions-prefix-everything-in-the-global-namespace) for more details.
- `WordPress.WP.CapitalPDangit`: check for correct spelling of WordPress. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/#naming)
- `WordPress.WP.TimezoneChange`: themes should never touch the timezone.

[Unreleased]: https://github.com/WPTRT/WPThemeReview/compare/0.1.0...HEAD
