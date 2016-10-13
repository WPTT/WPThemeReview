/* ----- Bad ------- ERROR ---- */
<link rel="shortcut icon" href="http://example.com/favicon.ico">
<link rel="icon" href="<?php esc_url( favicon_url( 'link' ) ); ?>">
<link rel="apple-touch-icon" href="<?php esc_url( favicon_url( 'link' ) ); ?>">
<link rel="apple-touch-icon-precomposed" href="<?php esc_url( favicon_url( 'link' ) ); ?>">
<meta name="msapplication-TileImage" href="<?php esc_url( favicon_url( 'link' ) ); ?>">
