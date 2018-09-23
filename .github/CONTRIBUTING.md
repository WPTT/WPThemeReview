Hi, thank you for your interest in contributing to the WordPress Theme Review Coding Standards! We look forward to working with you.

# Reporting Bugs

Before reporting a bug, you should check what sniff an error is coming from.
Running `phpcs` with the `-s` flag will show the name of the sniff with each error.

Bug reports containing a minimal code sample which can be used to reproduce the issue are highly appreciated as those are most easily actionable.

# Contributing patches and new features

## Branches

Ongoing development will be done in the `develop` branch with merges done into `master` once considered stable.

To contribute an improvement to this project, fork the repo and open a pull request to the `develop` branch. Alternatively, if you have push access to this repo, create a feature branch prefixed by `feature/` and then open an intra-repo PR from that branch to `develop`.

Once a commit is made to `develop`, a PR should be opened from `develop` into `master` and named "Next release". This PR will provide collaborators with a forum to discuss the upcoming stable release.

# Considerations when writing sniffs

## Public properties

When writing sniffs, always remember that any `public` sniff property can be overruled via a custom ruleset by the end-user.
Only make a property `public` if that is the intended behaviour.

When you introduce new `public` sniff properties, or your sniff extends a class from which you inherit a `public` property, please don't forget to update the [public properties wiki page](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/wiki/Customizable-sniff-properties) with the relevant details once your PR has been merged into the `develop` branch.

# Unit Testing

## Pre-requisites

* PHP 5.4 or higher
* WordPress-Coding-Standards 1.0.0 or higher
* PHP_CodeSniffer 3.3.0 or higher
* PHPUnit 4.x, 5.x, 6.x or 7.x
* PHPCompatibility 8.0 or higher

### Composer setup

Use Composer to install all the necessary dependencies to write and run unit tests. Running

```sh
composer install
```

will install PHP_CodeSniffer, WordPress Coding Standards, PHPUnit, PHPCompatibility and security advisories which ensures that your application doesn't have installed dependencies with known security vulnerabilities.

### Other setups

If you have PHP_CodeSniffer (PHPCS) and/or WordPress Coding Standards (WordPressCS) already installed, for instance as git clones, because you either contribute to these libraries as well or you want to develop for or test WPThemeReview with bleeding edge versions of either PHP_CodeSniffer or WordPress Coding Standards, you need to take some additional steps to make it all work.

First, make sure you also have PHPCompatibility and make sure the `installed_paths` for PHP_CodeSniffer is setup correctly.

#### Method 1

Set up environment variables to point to PHP_CodeSniffer and WordPress Coding Standards:

```sh
PHPCS_DIR: I:/000_GitHub/PHPCS/PHP_CodeSniffer/
WPCS_DIR: I:/000_GitHub/PHPCS/WordPressCS/
```

If you do that, everything should work as expected.

#### Method 2

If you do not want to set up environment variables on your system

* Add a file called `.pathtowpcs` to the project root. The only content in that file should be the full absolute path to your WordPressCS install.
* Copy the `phpunit.xml.dist` file, rename the copied file `phpunit.xml` and make sure it's in the project root.
Now add the following to that file, adjusting the paths to reflect those on your system:

```xml
  <php>
    <env name="PHPCS_DIR" value="path/to/PHP_CodeSniffer/"/>
    <env name="WPCS_DIR" value="path/to/WordPressCS/"/>
  </php>
```

(and don't remove the existing line within the `<php>` block.)

## Writing and running unit tests

The most iportant thing when writing sniffs intended for the theme review, is to have an ample of examples. This makes writing sniffs a lot easier, because you can test agains the give nexamples.

If you want to run unit tests, and if you ran `composer install`, you can now run `composer run-tests` (or `composer run-script run-tests`), which will run the test suite.

The WordPress Theme Review Coding Standards use the PHP_CodeSniffer native unit test suite for unit testing the sniffs.

Once you've started the tests you will see a similar output to this:

```bash
> @php ./vendor/phpunit/phpunit/phpunit --filter WPThemeReview ./vendor/squizlabs/php_codesniffer/tests/AllTests.php
PHPUnit 7.3.5 by Sebastian Bergmann and contributors.

............                                                      12 / 12 (100%)

Tests generated 57 unique error codes; 0 were fixable (0%)

Time: 13.55 seconds, Memory: 64.00MB

OK (12 tests, 0 assertions)
```

## Unit Testing conventions

The tests folder located inside the `WPThemeReview/Tests` folder correspond to the `WPThemeReview/Sniffs` folder. For example the `WPThemeReview/Sniffs/CoreFunctionality/FileIncludeSniff.php` sniff has the unit test class defined in `WPThemeReview/Tests/CoreFunctionality/FileIncludeSniff.php` which checks the `WPThemeReview/Tests/CoreFunctionality/FileIncludeSniff.inc` test case file.

Lets take a look at what's inside `FileIncludeSniff.php`:

```php
<?php
/**
 * Unit test class for WPThemeReview Coding Standard.
 *
 * @package WPTRT\WPThemeReview
 * @link    https://github.com/WPTRT/WPThemeReview
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WPThemeReview\Tests\CoreFunctionality;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Unit test class for the Theme_FileInclude sniff.
 *
 * @since 0.1.0
 */
class FileIncludeUnitTest extends AbstractSniffUnitTest {

  /**
   * Returns the lines where errors should occur.
   *
   * @return array <int line number> => <int number of errors>
   */
  public function getErrorList() {
    return array();
  }

  /**
   * Returns the lines where warnings should occur.
   *
   * @return array <int line number> => <int number of warnings>
   */
  public function getWarningList() {
    return array(
      3 => 1,
      4 => 1,
      5 => 1,
      6 => 1,
      7 => 1,
      8 => 1,
    );
  }

}
```

Also note the class name convention. The method `getWarningList()` MUST return an array of line numbers indicating warnings (when running `phpcs`) found in `WPThemeReview/Tests/CoreFunctionality/FileIncludeSniff.inc`.
If you run:

```bash
$ cd /path-to-cloned/WPThemeReview
$ vendor/bin/phpcs --standard=WPThemeReview -s WPThemeReview/Tests/CoreFunctionality/FileIncludeUnitTest.inc --sniffs=WPThemeReview.CoreFunctionality.FileInclude
...
FILE: /Users/infinum-denis/Projects/Personal/WPThemeReview/WPThemeReview/Tests/CoreFunctionality/FileIncludeUnitTest.inc
--------------------------------------------------------------------------------
FOUND 0 ERRORS AND 6 WARNINGS AFFECTING 6 LINES
--------------------------------------------------------------------------------
 3 | WARNING | Check that include is not being used to load template
   |         | files. "get_template_part()" should be used to load template files.
   |         | (WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound)
 4 | WARNING | Check that include_once is not being used to load
   |         | template files. "get_template_part()" should be used to load template files.
   |         | (WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound)
 5 | WARNING | Check that require is not being used to load template
   |         | files. "get_template_part()" should be used to load template files.
   |         | (WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound)
 6 | WARNING | Check that require_once is not being used to load
   |         | template files. "get_template_part()" should be used to load template files.
   |         | (WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound)
 7 | WARNING | Check that include is not being used to load template
   |         | files. "get_template_part()" should be used to load template files.
   |         | (WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound)
 8 | WARNING | Check that require_once is not being used to load
   |         | template files. "get_template_part()" should be used to load template files.
   |         | (WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound)
--------------------------------------------------------------------------------

Time: 45ms; Memory: 6Mb
```
You'll see the line number and number of WARNINGs we need to return in the `getWarningList()` method.

The `--sniffs=...` directive limits the output to the sniff you are testing.

You can also run the same command using composer scripts

```bash
composer check-cs -- --standard=WPThemeReview -s WPThemeReview/Tests/CoreFunctionality/FileIncludeUnitTest.inc --sniffs=WPThemeReview.CoreFunctionality.FileInclude
```

## Code Standards for this project

The sniffs and test files - not test _case_ files! - for WPCS should be written such that they pass the `WordPress-Extra` and the `WordPress-Docs` code standards using the custom ruleset as found in `/.phpcs.xml.dist`.
