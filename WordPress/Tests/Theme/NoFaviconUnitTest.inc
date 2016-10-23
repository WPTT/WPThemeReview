
<html <?php language_attributes(); ?> class="no-js"> // OK.
<meta charset="<?php bloginfo( 'charset' ); ?>"> // OK.
<meta name="viewport" content="width=device-width, initial-scale=1"> // OK.
<link rel="profile" href="http://gmpg.org/xfn/11"> // OK.


<link rel="shortcut icon" href="http://example.com/favicon.ico"> // Error.
<link  rel="icon" href="<?php esc_url( favicon_url( 'link' ) ); ?>"> // Error.
<link rel='apple-touch-icon' href="<?php esc_url( favicon_url( 'link' ) ); ?>"> // Error.
<link href="<?php esc_url( favicon_url( 'link' ) ); ?>" rel="apple-touch-icon-precomposed"> // Error.
<meta name="msapplication-TileImage" href="<?php esc_url( favicon_url( 'link' ) ); ?>"> // Error.

<?php
echo '
<meta name="msapplication-config" content="/my/path/browserconfig.xml" />
<meta name="msapplication-TileImage" content="', esc_url( get_template_directory() . 'images/icons/mstile-144x144.png?v=' . self::VERSION ), '" />
<meta name="msapplication-square70x70logo" content="', esc_url( get_template_directory() . 'images/icons/tiny.png?v=' . self::VERSION ), '" />
<meta name="msapplication-square150x150logo" content="', esc_url( get_template_directory() . 'images/icons/square.png?v=' . self::VERSION ), '" />
<meta name="msapplication-wide310x150logo" content="', esc_url( get_template_directory() . 'images/icons/wide.png?v=' . self::VERSION, __FILE__ ) ), '" />
<meta name="msapplication-square310x310logo" content="', esc_url( get_template_directory() . 'images/icons/large.png?v=' . self::VERSION ), '" />';
