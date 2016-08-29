<?php
// all are bad
register_post_type( 'myposttype' );
register_taxonomy( 'mytaxonomy', 'myposttype' );
add_shortcode( 'myshortcode' , 'myshortcode_function' );
register_taxonomy_for_object_type( 'category', 'page' );
flush_rewrite_rules( false );