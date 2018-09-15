<?php

/*
 * Safeguard against the sniff triggering on anything but the global WP function.
 */
My_Class::wp_deregister_scripts( 'jquery' );
$my_object->wp_deregister_scripts( 'jquery' );

class wp_deregister_scripts {
	function wp_deregister_scripts( $var = 'jquery' ) {}
}

/*
 * Safeguard against mis-identifying the registered script.
 */
wp_deregister_script( 'jQuery' ); // Handles are case senitive.
wp_deregister_script( 'themename-common' );
wp_deregister_script( 'themename-' . 'common' );

/*
 * Warn about variable handle names.
 */
wp_deregister_script( $prefix . '-common' ); // Warning.
wp_deregister_script( $something, 'jquery' ); // Warning for variable. Having the handle as second param will not work anyway, so no error.
wp_deregister_script( self::$script_handle ); // Warning for variable/dynamic param.
wp_deregister_script( parent::SCRIPT_HANDLE ); // Warning for variable/dynamic param.
wp_deregister_script( get_script_handle() ); // Warning for variable/dynamic param.

/*
 * These should be reported.
 */
wp_deregister_script( 'jquery' ); // Error.
wp_deregister_script( 'jquery-' . 'ui-core' ); // Error. Prevent bypassing this check via concatenation.
wp_deregister_script(
	"comment-reply"
); // Error.
wp_deregister_script("common"); // Error.
WP_Deregister_Script('masonry'); // Error.
