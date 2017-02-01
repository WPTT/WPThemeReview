<?php
// Now lets check inside php.
wp_enqueue_style( 'bootstrap', 'http://maxcdn.bootstrapcdn.com/bootstrap/file.ext' );  // Bad
wp_enqueue_style( 'bootstrap', 'http://netdna.bootstrapcdn.com/bootstrap/file.ext' );  // Bad
wp_enqueue_style( 'bootstrap', 'http://maxcdn.bootstrapcdn.com/bootswatch/file.ext' );  // Bad
wp_enqueue_style( 'bootstrap', 'http://netdna.bootstrapcdn.com/bootswatch/file.ext' );  // Bad
wp_enqueue_style( 'bootstrap', 'http://maxcdn.bootstrapcdn.com/font-awesome/file.ext' );  // Bad
wp_enqueue_style( 'bootstrap', 'http://netdna.bootstrapcdn.com/bootswatch/file.ext' );  // Bad
wp_enqueue_style( 'bootstrap', 'http://cdnjs.cloudflare.com/file.ext' );  // Bad
wp_enqueue_style( 'bootstrap', 'http://ajax.googleapis.com/file.ext' );  // Bad
wp_enqueue_style( 'bootstrap', 'http://cdn.jsdelivr.net/file.ext' );  // Bad
wp_enqueue_style( 'bootstrap', 'http://use.fontawesome.com/file.ext' );  // Bad
wp_enqueue_style( 'bootstrap', 'http://opensource.keycdn.com/file.ext' );  // Bad
wp_enqueue_script( 'bootstrap', 'https://oss.maxcdn.com/libs/html5shiv/file.js' );  // Bad
wp_enqueue_script( 'bootstrap', 'https://html5shiv.googlecode.com/svn/trunk/html5.js' );  // Bad
wp_enqueue_script( 'bootstrap', 'https://oss.maxcdn.com/libs/html5shiv/html5.js' );  // Bad
wp_enqueue_script( 'bootstrap', 'https://code.jquery.com/jquery-whatever/file.js' );  // Bad
wp_enqueue_script( 'bootstrap', 'https://oss.maxcdn.com/libs/respond.js' );  // Bad
wp_enqueue_script( 'bootstrap', 'http://cdnjs.cloudflare.com/file.ext' );  // Bad
wp_enqueue_script( 'bootstrap', 'http://ajax.googleapis.com/file.ext' );  // Bad
wp_enqueue_script( 'bootstrap', 'http://cdn.jsdelivr.net/file.ext' );  // Bad
wp_enqueue_script( 'bootstrap', 'http://use.fontawesome.com/file.ext' );  // Bad
wp_enqueue_script( 'bootstrap', 'http://opensource.keycdn.com/file.ext' );  // Bad

/* ----- links in php comments will not be picked up ----- */
//wp_enqueue_script( 'bootstrap', 'https://oss.maxcdn.com/libs/respond.js' );
//wp_enqueue_style( 'bootstrap', 'http://maxcdn.bootstrapcdn.com/bootstrap/file.ext' );
