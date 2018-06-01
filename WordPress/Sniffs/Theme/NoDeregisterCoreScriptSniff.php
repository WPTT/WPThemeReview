<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPress\Sniffs\Theme;

use WordPress\AbstractFunctionParameterSniff;
use PHP_CodeSniffer_Tokens as Tokens;

/**
 * Forbids deregistering of core scripts (javascript).
 *
 * @link https://make.wordpress.org/themes/handbook/review/required/#stylesheets-and-scripts
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since 0.xx.0
 */
class NoDeregisterCoreScriptSniff extends AbstractFunctionParameterSniff {

	/**
	 * The group name for this group of functions.
	 *
	 * @since 0.xx.0
	 *
	 * @var string
	 */
	protected $group_name = 'wp_deregister_script';

	/**
	 * Array of function and script handles used in core.
	 *
	 * @since 0.xx.0
	 *
	 * @var array
	 */
	protected $target_functions = array(
		'wp_deregister_script' => array(
			'jcrop'                    => 'jcrop',
			'swfobject'                => 'swfobject',
			'swfupload'                => 'swfupload',
			'swfupload-degrade'        => 'swfupload-degrade',
			'swfupload-queue'          => 'swfupload-queue',
			'swfupload-handlers'       => 'swfupload-handlers',
			'jquery'                   => 'jquery',
			'jquery-form'              => 'jquery-form',
			'jquery-color'             => 'jquery-color',
			'jquery-masonry'           => 'jquery-masonry',
			'masonry'                  => 'masonry',
			'jquery-ui-core'           => 'jquery-ui-core',
			'jquery-ui-widget'         => 'jquery-ui-widget',
			'jquery-ui-accordion'      => 'jquery-ui-accordion',
			'jquery-ui-autocomplete'   => 'jquery-ui-autocomplete',
			'jquery-ui-button'         => 'jquery-ui-button',
			'jquery-ui-datepicker'     => 'jquery-ui-datepicker',
			'jquery-ui-dialog'         => 'jquery-ui-dialog',
			'jquery-ui-draggable'      => 'jquery-ui-draggable',
			'jquery-ui-droppable'      => 'jquery-ui-droppable',
			'jquery-ui-menu'           => 'jquery-ui-menu',
			'jquery-ui-mouse'          => 'jquery-ui-mouse',
			'jquery-ui-position'       => 'jquery-ui-position',
			'jquery-ui-progressbar'    => 'jquery-ui-progressbar',
			'jquery-ui-selectable'     => 'jquery-ui-selectable',
			'jquery-ui-resizable'      => 'jquery-ui-resizable',
			'jquery-ui-selectmenu'     => 'jquery-ui-selectmenu',
			'jquery-ui-sortable'       => 'jquery-ui-sortable',
			'jquery-ui-slider'         => 'jquery-ui-slider',
			'jquery-ui-spinner'        => 'jquery-ui-spinner',
			'jquery-ui-tooltip'        => 'jquery-ui-tooltip',
			'jquery-ui-tabs'           => 'jquery-ui-tabs',
			'jquery-effects-core'      => 'jquery-effects-core',
			'jquery-effects-blind'     => 'jquery-effects-blind',
			'jquery-effects-bounce'    => 'jquery-effects-bounce',
			'jquery-effects-clip'      => 'jquery-effects-clip',
			'jquery-effects-drop'      => 'jquery-effects-drop',
			'jquery-effects-explode'   => 'jquery-effects-explode',
			'jquery-effects-fade'      => 'jquery-effects-fade',
			'jquery-effects-fold'      => 'jquery-effects-fold',
			'jquery-effects-highlight' => 'jquery-effects-highlight',
			'jquery-effects-pulsate'   => 'jquery-effects-pulsate',
			'jquery-effects-scale'     => 'jquery-effects-scale',
			'jquery-effects-shake'     => 'jquery-effects-shake',
			'jquery-effects-slide'     => 'jquery-effects-slide',
			'jquery-effects-transfer'  => 'jquery-effects-transfer',
			'wp-mediaelement'          => 'wp-mediaelement',
			'schedule'                 => 'schedule',
			'suggest'                  => 'suggest',
			'thickbox'                 => 'thickbox',
			'hoverIntent'              => 'hoverIntent',
			'jquery-hotkeys'           => 'jquery-hotkeys',
			'sack'                     => 'sack',
			'quicktags'                => 'quicktags',
			'iris'                     => 'iris',
			'farbtastic'               => 'farbtastic',
			'colorpicker'              => 'colorpicker',
			'tiny_mce'                 => 'tiny_mce',
			'autosave'                 => 'autosave',
			'wp-ajax-response'         => 'wp-ajax-response',
			'wp-lists'                 => 'wp-lists',
			'common'                   => 'common',
			'editorremov'              => 'editorremov',
			'editor-functions'         => 'editor-functions',
			'ajaxcat'                  => 'ajaxcat',
			'admin-categories'         => 'admin-categories',
			'admin-tags'               => 'admin-tags',
			'admin-custom-fields'      => 'admin-custom-fields',
			'password-strength-meter'  => 'password-strength-meter',
			'admin-comments'           => 'admin-comments',
			'admin-users'              => 'admin-users',
			'admin-forms'              => 'admin-forms',
			'xfn'                      => 'xfn',
			'upload'                   => 'upload',
			'postbox'                  => 'postbox',
			'slug'                     => 'slug',
			'post'                     => 'post',
			'page'                     => 'page',
			'link'                     => 'link',
			'comment'                  => 'comment',
			'comment-reply'            => 'comment-reply',
			'admin-gallery'            => 'admin-gallery',
			'media-upload'             => 'media-upload',
			'admin-widgets'            => 'admin-widgets',
			'word-count'               => 'word-count',
			'theme-preview'            => 'theme-preview',
			'json2'                    => 'json2',
			'plupload'                 => 'plupload',
			'plupload-all'             => 'plupload-all',
			'plupload-html4'           => 'plupload-html4',
			'plupload-html5'           => 'plupload-html5',
			'plupload-flash'           => 'plupload-flash',
			'plupload-silverlight'     => 'plupload-silverlight',
			'underscore'               => 'underscore',
			'backbone'                 => 'backbone',
			'imagesloaded'             => 'imagesloaded',
		),
	);

	/**
	 * Process the parameters of a matched function.
	 *
	 * @since 0.xx.0
	 *
	 * @param int    $stackPtr        The position of the current token in the stack.
	 * @param array  $group_name      The name of the group which was matched.
	 * @param string $matched_content The token content (function name) which was matched.
	 * @param array  $parameters      Array with information about the parameters.
	 *
	 * @return void
	 */
	public function process_parameters( $stackPtr, $group_name, $matched_content, $parameters ) {

		if ( ! isset( $parameters[1] ) ) {
			return;
		}

		$matched_parameter = $this->strip_quotes( $parameters[1]['raw'] );

		if ( isset( $this->target_functions[ $matched_content ][ $matched_parameter ] ) ) {
			$this->throw_prohibited_error( $stackPtr, array( $matched_parameter ) );
			return;
		}

		// More extensive check to prevent people circumventing the sniff.
		$text                 = '';
		$found_variable_token = false;

		for ( $i = $parameters[1]['start']; $i <= $parameters[1]['end']; $i++ ) {
			if ( isset( Tokens::$stringTokens[ $this->tokens[ $i ]['code'] ] ) === false ) {
				if ( T_VARIABLE === $this->tokens[ $i ]['code']
					|| T_STRING === $this->tokens[ $i ]['code']
				) {
					$found_variable_token = true;
				}

				continue;
			}

			$text .= $this->strip_quotes( $this->tokens[ $i ]['content'] );
		}

		if ( isset( $this->target_functions[ $matched_content ][ $text ] ) ) {
			$this->throw_prohibited_error( $stackPtr, array( $text ) );
			return;
		}

		if ( true === $found_variable_token ) {
			$this->throw_variable_handle_warning( $stackPtr, array( $matched_content ) );
		}
	}

	/**
	 * Throw the error for deregistering a core script.
	 *
	 * @param int   $stackPtr The position of the matched function call in the stack.
	 * @param array $data     Optional input for the data replacements.
	 */
	public function throw_prohibited_error( $stackPtr, $data = array() ) {
		$this->phpcsFile->addError(
			'Deregistering core script "%s" is prohibited.',
			$stackPtr,
			'Found',
			$data
		);
	}

	/**
	 * Throw a warning when a variable handle for deregistering a script is detected.
	 *
	 * @param int   $stackPtr The position of the matched function call in the stack.
	 * @param array $data     Optional input for the data replacements.
	 */
	public function throw_variable_handle_warning( $stackPtr, $data = array() ) {
		$this->phpcsFile->addWarning(
			'Deregistering core scripts is prohibited. A variable script handle was found. Inspection of the %s() call needed.',
			$stackPtr,
			'VariableHandleFound',
			$data
		);
	}
}
