<?php
// all are bad
register_post_type( 'myposttype' );
register_taxonomy( 'mytaxonomy', 'myposttype' );
add_shortcode( 'myshortcode' , 'myshortcode_function' );
register_taxonomy_for_object_type( 'category', 'page' );
flush_rewrite_rules( false );
register_block_type( 'my_namespace/my_block', [
    'render_callback' => 'render_callback',
    'attributes'      => [
        'some_string' => [
            'default' => 'default string',
            'type'    => 'string'
        ],
        'some_array'  => [
            'type'  => 'array',
            'items' => [
                'type' => 'string',
            ],
        ]
    ]
] );
unregister_block_type( 'my_namespace/my_block' );
register_block_core_rss();
register_block_core_search();
register_block_core_archives();
register_block_core_calendar();
register_block_core_shortcode();
register_block_core_tag_cloud();
register_block_core_categories();
register_block_core_latest_posts();

xyz_add_shortcode(); // OK.
My_Plugin_Class::add_shortcode(); // OK.
$my_plugin_object->add_shortcode(); // OK.
