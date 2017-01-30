<?php
/**
* Test file: UseCapabilitiesNotRoles Sniff.
*/

add_dashboard_page( 'page_title' , 'menu_title' , 'super_admin' , 'menu_slug' , 'function'); // ERROR.
add_posts_page( 'page_title' , 'menu_title' , 'administrator' , 'menu_slug' , 'function' ); // ERROR.
add_media_page( 'page_title' , 'menu_title' , 'editor' , 'menu_slug' , 'function' ); // ERROR.
add_pages_page( 'page_title' , 'menu_title' , 'author' , 'menu_slug' , 'function' ); // ERROR.
add_comments_page( 'page_title' , 'menu_title' , 'contributor' , 'menu_slug' , 'function' ); // ERROR.
add_theme_page( 'page_title' , $menu_title , 'subscriber' , 'menu_slug' , 'function' );  // ERROR.
add_plugins_page( 'page_title' , 'menu_title' , 'super_admin' , 'menu_slug' , 'function' );  // ERROR.
add_users_page( 'page_title' , 'menu_title' , 'administrator' , 'menu_slug' , 'function' );  // ERROR.
add_management_page( 'page_title' , 'menu_title' , 'editor' , 'menu_slug' , 'function' );  // ERROR.
add_options_page( 'page_title' , 'menu_title' , 'contributor' , 'menu_slug' , 'function' );  // ERROR.
add_menu_page( $pagetitle , $menu_title , $subscriber , 'handle' , 'function' , 'icon_url' ); // WARNING.

add_plugins_page( 'page_title' , 'menu_title' , $cap , 'menu_slug' , 'function' );  // WARNING.
add_users_page( 'page_title' , 'menu_title' , 'xxx' , 'menu_slug' , 'function' ); // WARNING.
add_management_page( 'page_title' , 'menu_title' , 'xxx' , 'menu_slug' , 'function' ); // WARNING.
add_options_page( $pagetitle , $menu_title , $xxx , 'menu_slug' , 'function' ); // WARNING.
add_menu_page( $pagetitle , 'menu_title' , 'xxx' , 'handle' , 'function' , 'icon_url' ); // WARNING.
add_utility_page(
 'page_title' , 'menu_title' , 'super_admin' , 'menu_slug' , 'function', 'icon_url'  // ERROR.
);
add_submenu_page(
  'parent_slug' ,
  'page_title' ,
  'menu_title' ,
  $varible ,  // WARNING.
  'menu_slug' ,
  'function' );

if ( author_can( $post, $capability ) ) { } // WARNING.
if ( author_can( $post, 'FFFFF' ) ) { }  // WARNING.
if ( current_user_can( 'super_admin' ) ) { } // ERROR.
if ( current_user_can( 'SSSSS' ) ) { } // WARNING.
if( current_user_can_for_blog( '3' , 'EEEEEE' ) ) { }  // WARNING.
if( current_user_can_for_blog( '1' , 'editor' ) ) { }  // ERROR.

if ( author_can( $post, 'read' ) ) { } // OK.
