Thank you for your interest in contributing to the WordPress Theme Review Coding Standards! We look forward to working with you.

There are plenty of ways in which you can contribute: writing sniffs, or opening issues for sniffs, that don't exists, but which cover some [handbook rules](https://make.wordpress.org/themes/handbook/review/required/). Giving different code examples to [open issues](https://github.com/WPTRT/WPThemeReview/issues) that will reproduce the issue is also an extremely valuable contribution that you can make.

# Table of Contents

- [Reporting Bugs](#reporting-bugs)
  * [Upstream bugs](#upstream-bugs)
- [Contributing patches and new features](#contributing-patches-and-new-features)
  * [Branches](#branches)
  * [Picking an open issue](#picking-an-open-issue)
  * [Contributing to the project](#contributing-to-the-project)
- [Considerations when writing sniffs](#considerations-when-writing-sniffs)
  * [Unit Testing](#unit-testing)
    + [Pre-requisites](#pre-requisites)
    + [Composer setup](#composer-setup)
    + [Other setups](#other-setups)
      - [Method 1](#method-1)
      - [Method 2](#method-2)
  * [Writing and running unit tests](#writing-and-running-unit-tests)
  * [Unit Testing conventions](#unit-testing-conventions)
    + [Public properties](#public-properties)
    + [File organization and naming](#file-organization-and-naming)
  * [Code Standards for this project](#code-standards-for-this-project)

# Reporting Bugs

When reporting a bug in an existing sniff it's good to differentiate between whether the sniff is reporting something which the sniff shouldn't report on (a _false positive_), or whether the sniff isn't reporting on something that it should report on (a _false negative_).

If you've found a false positive, please check which sniff the error or warning is coming from using the `-s` flag with the `phpcs` command.

In case the sniff is not reporting on a certain thing it should, you won't be able to check it using the `-s` flag, but **in both** cases it's **mandatory** to provide code samples so that the issue could be easily remedied.

## Upstream bugs

In the case the sniff error code doesn't starts with `WPThemeReview`, and instead it starts with `WordPress`, `PHPCompatibility`, or something else, that means that it is and 'upstream' bug coming from either `WPCS`, `PHPCompatibility` or `PHPCS`. You can report the bug here, but the chances are high that you'll be asked to report it in the correct repository instead.

# Contributing patches and new features

## Branches

Ongoing development will be done in the `develop` branch with merges done into `master` once considered stable.

## Picking an open issue

If you want to pick an open issue, please mention that in the issue, and it will be assigned to you. This will prevent the possible double work by different people on the same issue.

## Contributing to the project

If you want to contribute to this project, fork the repo and open a pull request to the `develop` branch. If you have push access to this repo, you can create a feature branch and then open an intra-repo PR from that branch to the `develop`.

# Considerations when writing sniffs

## Unit Testing

All PRs which affect sniffs, whether bug fixes to existing sniffs, or the addition of a new sniff, should be accompanied by unit tests.

### Pre-requisites

* PHP 5.4 or higher
* WordPress-Coding-Standards 1.0.0 or higher
* PHP_CodeSniffer 3.3.0 or higher
* PHPUnit 4.x, 5.x, 6.x or 7.x
* PHPCompatibility 8.0 or higher

### Composer setup

Use Composer to install all the necessary dependencies to write and run unit tests. Running

```bash
composer install
```

from the root of the cloned repository, will install `PHP_CodeSniffer`, `WordPress Coding Standards`, `PHPUnit`, `PHPCompatibility` and `security advisories` which ensures that your application doesn't have installed dependencies with known security vulnerabilities.

### Other setups

If you have PHP_CodeSniffer (PHPCS) and/or WordPress Coding Standards (WordPressCS) already installed, for instance as git clones, because you either contribute to these libraries as well or you want to develop for or test WPThemeReview with bleeding edge versions of either PHP_CodeSniffer or WordPress Coding Standards, you need to take some additional steps to make it all work.

First, make sure you also have PHPCompatibility and make sure the `installed_paths` for PHP_CodeSniffer is setup correctly.

You can see how this can be done by reading the official PHPCS [documentation](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Configuration-Options#setting-the-installed-standard-paths).

#### Method 1

Set up global environment variables to point to PHP_CodeSniffer and WordPress Coding Standards:

```bash
PHPCS_DIR: I:/path/to/PHP_CodeSniffer/
WPCS_DIR: I:/path/to/WordPressCS/
```

If you do that, the unit tests should be able to work correctly.

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

The most important thing when writing sniffs intended for the theme review, is to have ample example code. This makes writing sniffs a lot easier, because you can test against the given examples.

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

If you didn't install PHPCS/WPCS/PHPUnit using Composer, you will need to type the above command in to run the unit tests. Make sure you replace the path to PHPUnit and the path to PHPCS when you do.

## Unit Testing conventions

### Public properties

When writing sniffs, always remember that any `public` sniff property can be overruled via a custom ruleset by the end-user.
Only make a property `public` if that is the intended behaviour.

When you introduce new `public` sniff properties, or your sniff extends a class from which you inherit a `public` property, please don't forget to update the [public properties wiki page](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/wiki/Customizable-sniff-properties) with the relevant details once your PR has been merged into the `develop` branch.

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

Also note the class name convention. The method `getWarningList()` MUST return an array of line numbers indicating warnings (when running `phpcs`) found in `WPThemeReview/Tests/CoreFunctionality/FileIncludeSniff.inc`.
If you run

```bash
$ cd /path-to-cloned/WPThemeReview
$ vendor/bin/phpcs --standard=WPThemeReview -s WPThemeReview/Tests/CoreFunctionality/FileIncludeUnitTest.inc --sniffs=WPThemeReview.CoreFunctionality.FileInclude
```

The results will be

```bash
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

The WPTRTCS sniffs and test files (excluding test _case_ files) are written in a way that they pass the rules set by the custom ruleset found in `/.phpcs.xml.dist`. They should pass some of the `WordPress-Extra` standards and the `WordPress-Docs` code standards.

You can check the custom written sniff using the `composer check-cs` command from the project root.
