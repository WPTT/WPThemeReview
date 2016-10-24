<?php
/**
* Test file : NoSanitizeCallback Sniff
*/

$wp_customize->add_setting( 'setting_id', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'theme_supports' => '',
	'default' => '',
	'transport' => 'refresh',
	'sanitize_callback' => '', // Error.
	'sanitize_js_callback' => '', // Error.
) );
$customize->add_setting( 'jot_customize_options['.$jot_option['name'].']' , array(
	'default'                => $jot_option['default'],
	'type'                   => $jot_option['setting_type'],
	'capability'             => 'edit_theme_options',
	'theme_supports'         => '',
	'transport'              => $jot_option['transport'],
	//'sanitize_callback'    => $jot_option['sanitize'], // Error.
	//'sanitize_js_callback' => '', // Error.
));

$custiomize_settings->add_setting( 'setting_id', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'sanitize_callback' => '', // Error.
	'sanitize_js_callback' => 'absint', // OK.
	'theme_supports' => '',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'jot_customize_options['.$jot_option['name'].']' , array(
	'default'              => $jot_option['default'],
	'type'                 => $jot_option['setting_type'],
	'capability'           => 'edit_theme_options',
	'theme_supports'       => '',
	'transport'            => $jot_option['transport'],
	//'sanitize_callback'  => $jot_option['sanitize'],
	'sanitize_js_callback' => 'absint',
));
$custiomize_settings->add_setting(
	'setting_id',
	array(
		'capability' => 'edit_theme_options',
		'sanitize_callback' => $sanitize_callback, // Ok.
		'sanitize_js_callback' => $sanitize_callback, // OK.
		'transport' => 'refresh',
	)
);
$args = array(
	'default'           => $default,
	'type'              => $type,
	'capability'        => $capability,
	'transport'         => $transport,
	'sanitize_callback' => $sanitize_callback,
);
$wp_customize->add_setting(
	new JT_Customize_Setting_Class( $wp_customize, $name, $args )
);