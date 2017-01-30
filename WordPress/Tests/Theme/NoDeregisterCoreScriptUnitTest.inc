<?php

wp_deregister_script( 'jquery' ); // Error.
wp_deregister_script( "jquery" ); // Error.
wp_deregister_script("jquery"); // Error.
WP_Deregister_Script('jquery'); // Error.

// OK.
My_Class::wp_deregister_scripts( 'jquery' );
$my_object->wp_deregister_scripts( 'jquery' );
wp_deregister_script( 'jQuery' ); // Handles are case senitive.

class wp_deregister_scripts {
	function some_function( $var = 'jquery' ) {}
}
