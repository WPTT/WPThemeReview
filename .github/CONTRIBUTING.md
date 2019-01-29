Thank you for your interest in contributing to the WordPress Theme Review Coding Standards! We look forward to working with you.

There are plenty of ways in which you can contribute: writing sniffs, or opening issues for sniffs, that don't exists, but which cover some [handbook rules](https://make.wordpress.org/themes/handbook/review/required/). Giving different code examples to [open issues](https://github.com/WPTRT/WPThemeReview/issues) that will reproduce the issue is also an extremely valuable contribution that you can make.

# Table of Contents

- [Reporting Bugs](#reporting-bugs)
  * [Upstream bugs](#upstream-bugs)
- [Contributing patches and new features](#contributing-patches-and-new-features)
  * [Branches](#branches)
  * [Contributing with code](#contributing-with-code)
  * [Picking an open issue](#picking-an-open-issue)
  * [Sniff categorization](#sniff-categorization)
  * [Public properties](#public-properties)
  * [Code Standards for this project](#code-standards-for-this-project)
- [Considerations when writing sniffs](#considerations-when-writing-sniffs)
  * [Unit testing](#unit-testing)
    + [Pre-requisites](#pre-requisites)
    + [Composer setup](#composer-setup)
    + [Other setups](#other-setups)
  * [Writing and running unit tests](#writing-and-running-unit-tests)
  * [Unit testing conventions](#unit-testing-conventions)
    + [File organization and naming](#file-organization-and-naming)

# Reporting Bugs

When reporting a bug in an existing sniff it's good to differentiate between whether the sniff is reporting something which the sniff shouldn't report on (a _false positive_), or whether the sniff isn't reporting on something that it should report on (a _false negative_).

If you've found a false positive, please check which sniff the error or warning is coming from using the `-s` flag with the `phpcs` command.

In case of a false negative, you won't be able to check for a sniff code using the `-s` flag, but **in both** cases it's **mandatory** to provide code samples so that the issue can be easily reproduced and remedied.

## Upstream bugs

If the sniff error code doesn't starts with `WPThemeReview`, but instead it starts with `WordPress`, `PHPCompatibility`, or something else, that means that it is an 'upstream' bug coming from either [`WordPressCS`](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards), [`PHPCompatibility`](https://github.com/PHPCompatibility/PHPCompatibility) or [`PHP_CodeSniffer`](https://github.com/squizlabs/PHP_CodeSniffer).

You can report the bug here, but the chances are high that you'll be asked to report it in the correct repository instead.

# Contributing patches and new features

## Branches

Ongoing development will be done in the `develop` branch with merges done into `master` once considered stable.

## Contributing with code

If you want to contribute to this project, fork the repo, create a new branch for your work and, once finished, open a pull request to the `develop` branch. If you have push access to this repo, you don't need to fork the repo, but can push your feature branch directly to this repo and you can then open an intra-repo PR from that branch to the `develop` branch.

## Picking an open issue

If you start work on an open issue, please mention that in the issue, and it will be assigned to you. This will prevent possible double work by different people on the same issue.

## Sniff categorization

Every sniff should be categorized. Currently sniffs are placed in the following categories:

* __`CoreFunctionality`__ - sniffs checking whether a theme uses WordPress core functionality (correctly)
* __`Plugins`__ - sniff that checks if the correct version of TGMPA is included in the theme (if included)
* __`PluginTerritory`__ - sniffs related to how themes interact with plugins and how plugins are recommended
* __`ThouShallNotUse`__ - sniffs that check for code that shoulnd't be used in a theme

If you think a new sniff doesn't fall into any of these four categories, suggest a new category. Category names should be descriptive and written in CamelCaps without underscores. The proposed category should be somewhat connected to the requirements in the theme review handbook.

## Public properties

When writing sniffs, always remember that any `public` sniff property can be overruled via a custom ruleset by the end-user.
Only make a property `public` if that is the intended behaviour.

## Code Standards for this project

The WPTRTCS sniffs and test files (excluding test _case_ files) are written in a way that they pass the rules set by the custom ruleset found in [`/.phpcs.xml.dist`](https://github.com/WPTRT/WPThemeReview/blob/develop/.phpcs.xml.dist). They should pass most of the `WordPress-Extra` standards and the `WordPress-Docs` code standards.

You can check whether your code complies with the coding standard using the `composer check-cs` command from the project root.

# Considerations when writing sniffs

## Unit testing

All PRs which affect sniffs, whether bug fixes to existing sniffs, or the addition of a new sniff, should be accompanied by unit tests.

### Pre-requisites

* PHP 5.4 or higher

### Composer setup

Use Composer to install all the necessary dependencies to write and run unit tests. Running

```bash
composer install
```

from the root of the cloned repository, will install `PHP_CodeSniffer`, `WordPress Coding Standards`, `PHPUnit`, `PHPCompatibility` and `security advisories`, which ensures that you won't install dependencies with known security vulnerabilities.

### Other setups

If you have PHP_CodeSniffer (PHPCS) and/or WordPress Coding Standards (WordPressCS) already installed, for instance as git clones, because you either contribute to these libraries as well or you want to develop for or test WPThemeReview with bleeding edge versions of either PHP_CodeSniffer or WordPress Coding Standards, you need to take some additional steps to make it all work.

First, make sure you also have PHPCompatibility installed and make sure the `installed_paths` for PHP_CodeSniffer is set up correctly.

You can see how this can be done by reading the official PHPCS [documentation](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Configuration-Options#setting-the-installed-standard-paths).

Next, you need to make sure that PHPUnit can find the PHPCS unit test bootstrap file.  
There are two ways to do this:

1. You can copy the `phpunit.xml.dist` file, rename it to `phpunit.xml` and adjust the bootstrap line to point to where PHPCS is installed on your system.
2. Alternatively, you can add `--bootstrap="/path/to/PHPCS/tests/bootstrap.php"` to the phpunit command when you invoke it on the command line.

Once you've done that, both running the sniffs as well as the unit tests should work correctly.

## Writing and running unit tests

The most important thing when writing sniffs intended for the theme review standard, is to have ample example code. This makes writing sniffs a lot easier, because you can test against the given examples.

If you want to run the unit tests, and you installed the dependencies using `composer`, you can now run `composer run-tests` (or `composer run-script run-tests`), which will run the test suite.

The WordPress Theme Review Coding Standards use the PHP_CodeSniffer native unit test suite for unit testing the sniffs.

Once you've started the tests you will see output similar to this:

```bash
> @php ./vendor/phpunit/phpunit/phpunit --filter WPThemeReview ./vendor/squizlabs/php_codesniffer/tests/AllTests.php
PHPUnit 7.5.0 by Sebastian Bergmann and contributors.

Runtime:       PHP 7.2.13
Configuration: /TRTCS/phpunit.xml

............                                                      12 / 12 (100%)

54 sniff test files generated 57 unique error codes; 0 were fixable (0%)

Time: 16.46 seconds, Memory: 48.00MB

OK (12 tests, 0 assertions)
```

If you didn't install PHPCS/WPCS/PHPUnit using Composer, you will need to type the above command in to run the unit tests. Make sure you replace the path to PHPUnit and the path to PHPCS when you do and, if you didn't setup your own `phpunit.xml` file, add `--bootstrap="/path/to/PHPCS/tests/bootstrap.php"`.

## Unit testing conventions

### File organization and naming

The tests folder located inside the `WPThemeReview/Tests` folder correspond to the `WPThemeReview/Sniffs` folder. For example the `WPThemeReview/Sniffs/CoreFunctionality/FileIncludeSniff.php` sniff has the unit test class defined in `WPThemeReview/Tests/CoreFunctionality/FileIncludeSniff.php` which checks the `WPThemeReview/Tests/CoreFunctionality/FileIncludeSniff.inc` test case file.

Lets take a look at what's inside `FileIncludeSniff.php`:  

<details>
  <summary>View `FileIncludeSniff.php`</summary>
  
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
  
</details><br>  

Also note the class and function name conventions. The methods `getErrorList()` and `getWarningList()` MUST return either an empty array (no errors/warnings) or an array of line numbers indicating errors/warnings (when running `phpcs`) found in the test case file for the sniff.
If you run:

```bash
$ cd /path-to-cloned/WPThemeReview
$ vendor/bin/phpcs --standard=WPThemeReview -s WPThemeReview/Tests/CoreFunctionality/FileIncludeUnitTest.inc --sniffs=WPThemeReview.CoreFunctionality.FileInclude
```

The results should be:

```bash
...
FILE: /path-to-cloned/WPThemeReview/WPThemeReview/Tests/CoreFunctionality/FileIncludeUnitTest.inc
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
