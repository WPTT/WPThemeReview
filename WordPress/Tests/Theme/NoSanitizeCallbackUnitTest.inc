<?php
/**
* Test file : NoSanitizeCallback Sniff
*/

$wp_customize->add_setting( 'setting_id', array(
	'type' => 'theme_mod', // or 'option'
	'capability' => 'edit_theme_options',
	'theme_supports' => '', // Rarely needed.
	'default' => '',
	'transport' => 'refresh', // or postMessage
	'sanitize_callback' => '',
	'sanitize_js_callback' => '', // Basically to_json.
) );
$customize->add_setting( 'jot_customize_options['.$jot_option['name'].']' , array(
	'default'                => $jot_option['default'],
	'type'                   => $jot_option['setting_type'],
	'capability'             => 'edit_theme_options',
	'theme_supports'         => '',
	'transport'              => $jot_option['transport'],
	//'sanitize_callback'    => $jot_option['sanitize'],
	//'sanitize_js_callback' => '',
));

$custiomize_settings->add_setting( 'setting_id', array(
	'type' => 'theme_mod', // or 'option'
	'capability' => 'edit_theme_options',
	'theme_supports' => '', // Rarely needed.
	'default' => '',
	'transport' => 'refresh', // or postMessage
	'sanitize_callback' => '',
	'sanitize_js_callback' => 'aa', // Basically to_json.
) );
$wp_customize->add_setting( 'jot_customize_options['.$jot_option['name'].']' , array(
	'default'              => $jot_option['default'],
	'type'                 => $jot_option['setting_type'],
	'capability'           => 'edit_theme_options',
	'theme_supports'       => '',
	'transport'            => $jot_option['transport'],
	//'sanitize_callback'  => $jot_option['sanitize'],
	'sanitize_js_callback' => 'bbb',
));
