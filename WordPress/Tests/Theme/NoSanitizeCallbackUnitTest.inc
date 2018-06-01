<?php
/**
 * Test file : NoSanitizeCallback Sniff
 */

$wp_customize->add_setting( 'setting_id', array(
	'type'                 => 'theme_mod',
	'capability'           => 'edit_theme_options',
	'theme_supports'       => '',
	'default'              => '',
	'transport'            => 'refresh',
	'sanitize_callback'    => '', // Error.
	'sanitize_js_callback' => '', // Error.
) );
$customize->add_setting( 'slug_customize_options[' . $slug_option['name'] . ']', array(
	'default'        => $slug_option['default'],
	'type'           => $slug_option['setting_type'],
	'capability'     => 'edit_theme_options',
	'theme_supports' => '',
	'transport'      => $slug_option['transport'],
	// 'sanitize_callback'    => $slug_option['sanitize'], // Error.
	// 'sanitize_js_callback' => '', // Error.
));
$custiomize_settings->add_setting( 'setting_id', array(
	'type'                 => 'theme_mod',
	'capability'           => 'edit_theme_options',
	'sanitize_callback'    => '', // Error.
	'sanitize_js_callback' => 'absint', // OK.
	'theme_supports'       => '',
	'default'              => '',
	'transport'            => 'refresh',
) );
$wp_customize->add_setting( 'slug_customize_options[' . $slug_option['name'] . ']', array(
	'default'              => $slug_option['default'],
	'type'                 => $slug_option['setting_type'],
	'capability'           => 'edit_theme_options',
	'theme_supports'       => '',
	'transport'            => $slug_option['transport'],
	'sanitize_js_callback' => 'absint',
));
$custiomize_settings->add_setting(
	'setting_id',
	array(
		'capability'           => 'edit_theme_options',
		'sanitize_callback'    => $sanitize_callback, // Ok.
		'sanitize_js_callback' => $sanitize_callback, // OK.
		'transport'            => 'refresh',
	)
);
$args = array(
	'default'           => $default,
	'type'              => $type,
	'capability'        => $capability,
	'transport'         => $transport,
	'sanitize_callback' => $sanitize_callback, // OK.
);
$wp_customize->add_setting(
	new JT_Customize_Setting_Class( $wp_customize, $name, $args )
);

