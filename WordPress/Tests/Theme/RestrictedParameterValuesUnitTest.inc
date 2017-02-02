<?php
// all bad will give ERROR
get_bloginfo("url");
get_bloginfo( 'wpurl' );
get_bloginfo('stylesheet_directory');
get_bloginfo('template_url');
get_bloginfo('rdf_url');
get_bloginfo('rss_url');
get_bloginfo('atom_url');
get_bloginfo('comments_atom_url');
get_bloginfo('comments_rss2_url');
bloginfo('url');
bloginfo('wpurl');
bloginfo('stylesheet_directory');
bloginfo('template_url');
bloginfo('rdf_url');
bloginfo('rss_url');
bloginfo('atom_url');
bloginfo('comments_atom_url');
bloginfo('comments_rss2_url');
get_option('home');
get_option('site_url');

// Method names within a class should be fine.
Theme_Object::get_bloginfo('stylesheet_directory'); // Ok.
$this->bloginfo('feed_url'); // Ok.
$theme_object->get_option('site_url'); // Ok.
