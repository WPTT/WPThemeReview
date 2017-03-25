<?php




add_dashboard_page( 'page_title' , 'menu_title' , 'super_admin' , 'menu_slug' , 'function'); // Error.
add_posts_page( 'page_title' , 'menu_title' , 'administrator' , 'menu_slug' , 'function' ); // Error.
add_media_page( 'page_title' , 'menu_title' , 'editor' , 'menu_slug' , 'function' ); // Error.
add_pages_page( 'page_title' , 'menu_title' , 'author' , 'menu_slug' , 'function' ); // Error.
add_comments_page( 'page_title' , 'menu_title' , 'contributor' , 'menu_slug' , 'function' ); // Error.
add_theme_page( 'page_title' , $menu_title , 'subscriber' , 'menu_slug' , 'function' );  // Error.
add_plugins_page( 'page_title' , 'menu_title' , 'super_admin' , 'menu_slug' , 'function' );  // Error.
add_users_page( 'page_title' , 'menu_title' , 'administrator' , 'menu_slug' , 'function' );  // Error.
add_management_page( 'page_title' , 'menu_title' , 'editor' , 'menu_slug' , 'function' );  // Error.
add_options_page( 'page_title' , 'menu_title' , 'contributor' , 'menu_slug' , 'function' );  // Error.
add_menu_page( $pagetitle , $menu_title , $subscriber , 'handle' , 'function' , 'icon_url' ); // Warning.

add_plugins_page( 'page_title' , 'menu_title' , $cap , 'menu_slug' , 'function' );  // Warning.
add_users_page( 'page_title' , 'menu_title' , 'xxx' , 'menu_slug' , 'function' ); // Warning.
add_management_page( 'page_title' , 'menu_title' , 'xxx' , 'menu_slug' , 'function' ); // Warning.
add_options_page( $pagetitle , $menu_title , $xxx , 'menu_slug' , 'function' ); // Warning.
add_menu_page( $pagetitle , 'menu_title' , 'xxx' , 'handle' , 'function' , 'icon_url' ); // Warning.
add_utility_page(
 'page_title' , 'menu_title' , 'super_admin' , 'menu_slug' , 'function', 'icon_url'  // Error.
);
add_submenu_page(
  'parent_slug' ,
  'page_title' ,
  'menu_title' ,
  $varible ,  // Warning.
  'menu_slug' ,
  'function' );

if ( author_can( $post, $capability ) ) { } // Warning.
if ( author_can( $post, 'FFFFF' ) ) { }  // Warning.
if ( current_user_can( 'super_admin' ) ) { } // Error.
if ( current_user_can( 'SSSSS' ) ) { } // Warning.
if( current_user_can_for_blog( '3' , 'EEEEEE' ) ) { }  // Warning.
if( current_user_can_for_blog( '1' , 'editor' ) ) { }  // Error.

if ( author_can( $post, 'read' ) ) { } // OK.
