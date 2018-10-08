# Change Log for the WPThemeReview PHP_CodeSniffer standard

All notable changes to this project will be documented in this file.

This projects adheres to [Semantic Versioning](https://semver.org/) and [Keep a CHANGELOG](https://keepachangelog.com/).

## [Unreleased]

_No documentation available about unreleased changes as of yet._

## [0.1.0] - 2013-10-20

### Added

#### Native sniffs
- `WPThemeReview.CoreFunctionality.FileInclude`: checks if a theme uses `include(_once)` or `require(_once)` when `get_template_part()` should be used. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/#core-functionality-and-features).
- `WPThemeReview.CoreFunctionality.NoDeregisterCoreScript`: checks if a theme deregistered core script (javascript). [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/#stylesheets-and-scripts).
- `WPThemeReview.CoreFunctionality.NoFavicon`: checks if a theme is hard coding favicons instead of using core implementation. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/#core-functionality-and-features).
- `WPThemeReview.CoreFunctionality.NoTitleTag`: checks if a theme is using a `<title>` tag instead of `add_theme_support( 'title-tag' )`. `<svg>` tag can use a `<title>` tag. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/#core-functionality-and-features).
- `WPThemeReview.PluginTerritory.AdminBarRemoval`: checks if a theme is removing admin bar. This rule was pulled from `WPCS` and will be removed in version 2.0 of `WPCS`. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/#core-functionality-and-features).
- `WPThemeReview.PluginTerritory.ForbiddenFunctions`: checks if a theme is using functions that fall under a plugin territory. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/#presentation-vs-functionality).
- `WPThemeReview.PluginTerritory.NoAddAdminPages`: checks if a theme is using `add_..._page()` functions, with the exception of `add_theme_page()`. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/theme-check-plugin/#admin-menu).
- `WPThemeReview.PluginTerritory.SessionFunctionsUsage`: taken from `WordPress-VIP` ruleset, which will be deprecated in the `WPCS` version 2.0. Prevents the usage of the session functions in themes.
- `WPThemeReview.PluginTerritory.SessionVariableUsage`: taken from `WordPress-VIP` ruleset, which will be deprecated in the `WPCS` version 2.0. Prevents the usage of the session variables in themes.
- `WPThemeReview.Plugins.CorrectTGMPAVersion` Verifies that if the [TGM Plugin Activation](http://tgmpluginactivation.com/) library is included, the correct version is used. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/theme-check-plugin/#admin-menu).
- `WPThemeReview.ThouShallNotUse.ForbiddenIframe`: checks if a theme is using `<iframe>`. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/theme-check-plugin/#info).
- `WPThemeReview.ThouShallNotUse.NoAutoGenerate`: checks if a theme has been generated using theme generators.

#### Other sniffs in the ruleset
- `PHPCompatibilityWP`: added as an entire ruleset, checking that the theme is compatible with PHP 5.2 and above
- `Generic.PHP.DisallowShortOpenTag`: prohibits the usage of the PHP short open tags. [Handbook rule](https://make.wordpress.org/themes/handbook/review/required/theme-check-plugin/#additional-checks).
- `Generic.PHP.DisallowAlternativePHPTags`: disallows the usage of alternative PHP open tags (`<%` and similar).
- `Squiz.WhiteSpace.SuperfluousWhitespace.StartFile`: files starting with a PHP open tag shouldn't have a whitespace preceding it, to prevent possible `headers already sent` errors.
- `PSR2.Files.ClosingTag.NotAllowed`: files should omit the closing PHP tag at the end of a file, to prevent possible `headers already sent` errors.
- `Internal.LineEndings.Mixed`: mixed line endings are not allowed.
- `Internal.Tokenizer.Exception`: minified scripts or files should have original files included.
- `Generic.Files.ByteOrderMark`: no ByteOrderMark allowed - important to prevent issues with content being sent before headers
- `Generic.CodeAnalysis.EmptyStatement`: PHP tags without anything between them is just sloppy
- `WordPress.WP.I18n`: check that the I18N functions are used correctly. This sniff can also check the text domain, provided it's passed to `PHPCS`.
- `WordPress.WP.EnqueuedResources`: hard coding of scripts and styles is prohibited. They should be enqueued.
- `WordPress.Security.PluginMenuSlug`: prevent path disclosure when using add_theme_page().
- `Generic.PHP.NoSilencedErrors`: usage of Error Control Operator `@` is forbidden in a theme.
- `WordPress.DB.RestrictedClasses`: the WP abstraction layer should be used to query database if needed.
- `WordPress.DB.RestrictedFunctions`: the WP abstraction layer should be used to query database if needed.
- `WordPress.DB.PreparedSQL`: all SQL queries should be prepared as close to the time of querying the database as possible.
- `WordPress.DB.PreparedSQLPlaceholders`: verify that placeholders in prepared queries are used correctly.
- `WordPress.Security.ValidatedSanitizedInput`: validate and/or sanitize untrusted data before entering into the database.
- `WordPress.Security.EscapeOutput`: all untrusted data should be escaped before output - warning, since translations don't have to be escaped.
- `Generic.PHP.BacktickOperator`: prohibit the use of the backtick operator.
- `WordPress.WP.GlobalVariablesOverride`: šrohibit overwriting of WordPress global variables.
- `Squiz.PHP.Eval.Discouraged`: prohibit the use of the eval() PHP language construct.
- `Generic.PHP.DiscourageGoto.Found`: prohibit the use of the `goto` PHP language construct.
- `WordPress.WP.DeprecatedClasses`: check for use of deprecated WordPress classes.
- `WordPress.WP.DeprecatedFunctions`: check for use of deprecated WordPress functions.
- `WordPress.WP.DeprecatedParameters`: check for use of deprecated WordPress function parameters.
- `WordPress.WP.DiscouragedConstants`: check for deprecated WordPress constants.
- `WordPress.NamingConventions.PrefixAllGlobals`: verify that everything in the global namespace is prefixed.
- `WordPress.WP.CapitalPDangit`: check for correct spelling of WordPress.
- `WordPress.WP.TimezoneChange`: themes should never touch the timezone.

[Unreleased]: https://github.com/WPTRT/WPThemeReview/compare/master...HEAD
[0.1.0]: https://github.com/WPTRT/WPThemeReview/compare/tag...0.1.0
