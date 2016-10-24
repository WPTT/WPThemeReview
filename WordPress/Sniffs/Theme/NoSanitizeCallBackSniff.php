<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

/**
 * Check thatsanitization is done correctly in the customizer.
 *
 * @link    https://make.wordpress.org/themes/handbook/review/required/#code
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class WordPress_Sniffs_Theme_NoSanitizeCallbackSniff implements PHP_CodeSniffer_Sniff {

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return array(
			T_STRING,
			T_EVAL,
		);
	}

	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
	 * @param int                  $stackPtr  The position of the current token
	 *                                        in the stack passed in $tokens.
	 *
	 * @return void
	 */
	public function process( PHP_CodeSniffer_File $phpcsFile, $stackPtr ) {

		$tokens = $phpcsFile->getTokens();
		$token  = $tokens[ $stackPtr ];

		// Exclude function definitions, static class methods, and namespaced calls.
		if (
			T_STRING === $token['code']
			&&
			( $prev = $phpcsFile->findPrevious( T_WHITESPACE, ( $stackPtr - 1 ), null, true ) )
			&&
			// Skip sniffing if calling anything but class method.
			( T_OBJECT_OPERATOR !== $tokens[ $prev ]['code'] )
			||
			// Skip namespaced functions, ie: \foo\bar() not \bar().
			(
				T_NS_SEPARATOR === $tokens[ $prev ]['code']
				&&
				( $pprev = $phpcsFile->findPrevious( T_WHITESPACE, ( $prev - 1 ), null, true ) )
				&&
				T_STRING === $tokens[ $pprev ]['code']
			)
			) {
			return;
		}

		if ( $token['content'] !== 'add_setting') {
			return;
		}

		$parameter_arg = $this->getFunctionCallParameter( $phpcsFile, $stackPtr, 2 );

		$sanitize_callback_found    = false;
		$sanitize_js_callback_found = false;

		$sanitize_callback_key = $parameter_arg['start'] - 1;

		while ( $sanitize_callback_key = $phpcsFile->findNext( array( T_CONSTANT_ENCAPSED_STRING ), $sanitize_callback_key + 1, $parameter_arg['end'], false ) ) {

			$name = trim( $tokens[ $sanitize_callback_key ]['content'], '\'\"' );

			if ( 'sanitize_callback' === $name ) {
				$sanitize_callback_found = true;
			}
			if ( 'sanitize_js_callback' === $name ) {
				$sanitize_js_callback_found = true;
			}

			if ( false === $sanitize_js_callback_found && false == $sanitize_callback_found ) {
				$last = $phpcsFile->findPrevious( array( T_CONSTANT_ENCAPSED_STRING ), $parameter_arg['end'] );
				if ( $last === $sanitize_callback_key ) {
					$phpcsFile->addError( 'Neither sanitize_callback or sanitize_js_callback were found for this option.', $stackPtr, 'SanitizeCallbackChecks' );
				}
				continue;
			}

			$sanitize_callback = $phpcsFile->findNext( array( T_CONSTANT_ENCAPSED_STRING ), $sanitize_callback_key + 1 );
			$value = trim( $tokens[ $sanitize_callback ]['content'], '\'\"' );

			if ( ! empty( $value ) ) {
				continue;
			}

			$phpcsFile->addError(
				'The %s must not be empty.',
				$sanitize_callback,
				'SanitizeCallbackChecks',
				array( $name )
			);

		}

	}


	/**
	 * Checks if a function call has parameters.
	 *
	 * Expects to be passed the T_STRING stack pointer for the function call.
	 * If passed a T_STRING which is *not* a function call, the behaviour is unreliable.
	 *
	 * @link https://github.com/wimg/PHPCompatibility/issues/120
	 * @link https://github.com/wimg/PHPCompatibility/issues/152
	 *
	 * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
	 * @param int                  $stackPtr  The position of the function call token.
	 *
	 * @return bool
	 */
	public function doesFunctionCallHaveParameters(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
	{
		$tokens = $phpcsFile->getTokens();

		// Check for the existence of the token.
		if (isset($tokens[$stackPtr]) === false) {
			return false;
		}

		if ($tokens[$stackPtr]['code'] !== T_STRING) {
			return false;
		}

		// Next non-empty token should be the open parenthesis.
		$openParenthesis = $phpcsFile->findNext(PHP_CodeSniffer_Tokens::$emptyTokens, $stackPtr + 1, null, true, null, true);
		if ($openParenthesis === false || $tokens[$openParenthesis]['code'] !== T_OPEN_PARENTHESIS) {
			return false;
		}

		if (isset($tokens[$openParenthesis]['parenthesis_closer']) === false) {
			return false;
		}

		$closeParenthesis = $tokens[$openParenthesis]['parenthesis_closer'];
		$nextNonEmpty     = $phpcsFile->findNext(PHP_CodeSniffer_Tokens::$emptyTokens, $openParenthesis + 1, $closeParenthesis + 1, true);

		if ($nextNonEmpty === $closeParenthesis) {
			// No parameters.
			return false;
		}

		return true;
	}

	/**
	 * Count the number of parameters a function call has been passed.
	 *
	 * Expects to be passed the T_STRING stack pointer for the function call.
	 * If passed a T_STRING which is *not* a function call, the behaviour is unreliable.
	 *
	 * @link https://github.com/wimg/PHPCompatibility/issues/111
	 * @link https://github.com/wimg/PHPCompatibility/issues/114
	 * @link https://github.com/wimg/PHPCompatibility/issues/151
	 *
	 * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
	 * @param int                  $stackPtr  The position of the function call token.
	 *
	 * @return int
	 */
	public function getFunctionCallParameterCount(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
	{
		if ($this->doesFunctionCallHaveParameters($phpcsFile, $stackPtr) === false) {
			return 0;
		}

		return count($this->getFunctionCallParameters($phpcsFile, $stackPtr));
	}


	/**
	 * Get information on all parameters passed to a function call.
	 *
	 * Expects to be passed the T_STRING stack pointer for the function call.
	 * If passed a T_STRING which is *not* a function call, the behaviour is unreliable.
	 *
	 * Will return an multi-dimentional array with the start token pointer, end token
	 * pointer and raw parameter value for all parameters. Index will be 1-based.
	 * If no parameters are found, will return an empty array.
	 *
	 * @param PHP_CodeSniffer_File $phpcsFile     The file being scanned.
	 * @param int                  $stackPtr      The position of the function call token.
	 *
	 * @return array
	 */
	public function getFunctionCallParameters(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
	{
		if ($this->doesFunctionCallHaveParameters($phpcsFile, $stackPtr) === false) {
			return array();
		}

		// Ok, we know we have a T_STRING with parameters and valid open & close parenthesis.
		$tokens = $phpcsFile->getTokens();

		$openParenthesis  = $phpcsFile->findNext(PHP_CodeSniffer_Tokens::$emptyTokens, $stackPtr + 1, null, true, null, true);
		$closeParenthesis = $tokens[$openParenthesis]['parenthesis_closer'];

		// Which nesting level is the one we are interested in ?
		$nestedParenthesisCount = 1;
		if (isset($tokens[$openParenthesis]['nested_parenthesis'])) {
			$nestedParenthesisCount = count($tokens[$openParenthesis]['nested_parenthesis']) + 1;
		}

		$parameters = array();
		$nextComma  = $openParenthesis;
		$paramStart = $openParenthesis + 1;
		$cnt        = 1;
		while ($nextComma = $phpcsFile->findNext(array(T_COMMA, T_CLOSE_PARENTHESIS, T_OPEN_SHORT_ARRAY), $nextComma + 1, $closeParenthesis + 1)) {
			// Ignore anything within short array definition brackets.
			if (
				$tokens[$nextComma]['type'] === 'T_OPEN_SHORT_ARRAY'
				&&
				( isset($tokens[$nextComma]['bracket_opener']) && $tokens[$nextComma]['bracket_opener'] === $nextComma )
				&&
				isset($tokens[$nextComma]['bracket_closer'])
			) {
				// Skip forward to the end of the short array definition.
				$nextComma = $tokens[$nextComma]['bracket_closer'];
				continue;
			}

			// Ignore comma's at a lower nesting level.
			if (
				$tokens[$nextComma]['type'] === 'T_COMMA'
				&&
				isset($tokens[$nextComma]['nested_parenthesis'])
				&&
				count($tokens[$nextComma]['nested_parenthesis']) !== $nestedParenthesisCount
			) {
				continue;
			}

			// Ignore closing parenthesis if not 'ours'.
			if ($tokens[$nextComma]['type'] === 'T_CLOSE_PARENTHESIS' && $nextComma !== $closeParenthesis) {
				continue;
			}

			// Ok, we've reached the end of the parameter.
			$parameters[$cnt]['start'] = $paramStart;
			$parameters[$cnt]['end']   = $nextComma - 1;
			$parameters[$cnt]['raw']   = trim($phpcsFile->getTokensAsString($paramStart, ($nextComma - $paramStart)));

			// Check if there are more tokens before the closing parenthesis.
			// Prevents code like the following from setting a third parameter:
			// functionCall( $param1, $param2, );
			$hasNextParam = $phpcsFile->findNext(PHP_CodeSniffer_Tokens::$emptyTokens, $nextComma + 1, $closeParenthesis, true, null, true);
			if ($hasNextParam === false) {
				break;
			}

			// Prepare for the next parameter.
			$paramStart = $nextComma + 1;
			$cnt++;
		}

		return $parameters;
	}


	/**
	 * Get information on a specific parameter passed to a function call.
	 *
	 * Expects to be passed the T_STRING stack pointer for the function call.
	 * If passed a T_STRING which is *not* a function call, the behaviour is unreliable.
	 *
	 * Will return a array with the start token pointer, end token pointer and the raw value
	 * of the parameter at a specific offset.
	 * If the specified parameter is not found, will return false.
	 *
	 * @param PHP_CodeSniffer_File $phpcsFile   The file being scanned.
	 * @param int                  $stackPtr    The position of the function call token.
	 * @param int                  $paramOffset The 1-based index position of the parameter to retrieve.
	 *
	 * @return array|false
	 */
	public function getFunctionCallParameter(PHP_CodeSniffer_File $phpcsFile, $stackPtr, $paramOffset)
	{
		$parameters = $this->getFunctionCallParameters($phpcsFile, $stackPtr);

		if (isset($parameters[$paramOffset]) === false) {
			return false;
		}
		else {
			return $parameters[$paramOffset];
		}
	}


}
