/* ----- Bad ------- ERROR ---- */
<link href='http://maxcdn.bootstrapcdn.com/bootstrap/file.ext' />
<link href='http://netdna.bootstrapcdn.com/bootstrap/file.ext' />
<link href='http://maxcdn.bootstrapcdn.com/bootswatch/file.ext' />
<link href='http://netdna.bootstrapcdn.com/bootswatch/file.ext' />
<link href='http://maxcdn.bootstrapcdn.com/font-awesome/file.ext' />
<link href='http://netdna.bootstrapcdn.com/font-awesome/file.ext' />
<script src="https://oss.maxcdn.com/libs/html5shiv/file.js"></script>
<script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script src="https://oss.maxcdn.com/libs/html5shiv/html5.js"></script>
<script src="https://code.jquery.com/jquery-whatever/file.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js"></script>

/* ----- Bad ------- WARNING ---- */
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
<link href='http://www.mycdnsite.com/file.css' />

/* ----- Good ------ */
<link rel="profile" href="http://gmpg.org/xfn/11">  <!-- OK -->
<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css' />  <!-- OK - Whitelisted URL -->
/* ----- links in html comments will also be picked up ----- */
<!-- <a ref="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" >Bootstrap</a> --> <!-- Bad -->
<!-- Here comes a link! --><a href="http://cdn.mysite.org">some string</a>  <!-- Bad -->

<?php
// Now lets check inside php
wp_enqueue_style( 'bootstrap', 'http://maxcdn.bootstrapcdn.com/bootstrap/file.ext' );  // Bad
wp_enqueue_style( 'bootstrap', 'http://netdna.bootstrapcdn.com/bootstrap/file.ext' );  // Bad
wp_enqueue_style( 'bootstrap', 'http://maxcdn.bootstrapcdn.com/bootswatch/file.ext' );  // Bad
wp_enqueue_style( 'bootstrap', 'http://netdna.bootstrapcdn.com/bootswatch/file.ext' );  // Bad
wp_enqueue_style( 'bootstrap', 'http://maxcdn.bootstrapcdn.com/font-awesome/file.ext' );  // Bad
wp_enqueue_style( 'bootstrap', 'http://netdna.bootstrapcdn.com/bootswatch/file.ext' );  // Bad
wp_enqueue_script( 'bootstrap', 'https://oss.maxcdn.com/libs/html5shiv/file.js' );  // Bad
wp_enqueue_script( 'bootstrap', 'https://html5shiv.googlecode.com/svn/trunk/html5.js' );  // Bad
wp_enqueue_script( 'bootstrap', 'https://oss.maxcdn.com/libs/html5shiv/html5.js' );  // Bad
wp_enqueue_script( 'bootstrap', 'https://code.jquery.com/jquery-whatever/file.js' );  // Bad
wp_enqueue_script( 'bootstrap', 'https://oss.maxcdn.com/libs/respond.js' );  // Bad

/* ----- links in php comments will not be picked up ----- */
//wp_enqueue_script( 'bootstrap', 'https://oss.maxcdn.com/libs/respond.js' );
//wp_enqueue_style( 'bootstrap', 'http://maxcdn.bootstrapcdn.com/bootstrap/file.ext' );
