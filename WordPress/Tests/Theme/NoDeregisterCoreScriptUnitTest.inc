<?php

wp_deregister_script( 'jquery' ); // Error.
wp_deregister_script( "jquery" ); // Error.
wp_deregister_script("jQuery"); // Error.
WP_Deregister_Script('jquery'); // Error.

// OK.
My_Class::wp_deregister_scripts( 'jquery' );
$my_object->wp_deregister_scripts( 'jquery' );

class wp_deregister_scripts {
	function some_function( $var = 'jquery' ) {}
}
