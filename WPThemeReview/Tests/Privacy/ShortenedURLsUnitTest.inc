<?php
// Check for url shorteners used in themes. Test largely based on examples found in existing theme repository.
$option_descriptions = array(
  $shortname . '_bitly_api_key' => array(
    'title'     => __('Bit.ly API Key', 'my-theme'), // OK, mentioning the service, not using a shortened URL
    'desc'      => __('You can get your API Key in your <a href="https://bitly.com/a/account">bit.ly account</a> (you should to log in)', 'my-theme'), // OK, mentioning the service, not using a shortened URL.
  ),
);

// http://df.ly/77w9wh // Error.

if (reshape) {} // do this only if container has no size http://tinyurl.com/da2oa9 // Error.

$tinyurl = file_get_contents("http://tinyurl.com/api-create.php?url=".$url); // Error.
echo '<a target="_blank" href="http://bit.ly/sibwp2" class="button" style="margin-top: 8px">' . esc_html__( 'Create SendinBlue Account', 'hestia' ) . '</a>'; // Error.

// http://bit.ly/magnific-popup#build=inline+image+ajax+iframe+gallery+retina+imagezoom // Error.

$wp_customize->add_control( 'onepress_newsletter_mailchimp',
  array(
    'description' => __( 'The newsletter form use MailChimp, please follow <a target="_blank" href="http://polr.me/uRVIst">this guide</a> to know how to get MailChimp Action URL. Example <i>//famethemes.us8.list-manage.com/subscribe/post?u=521c400d049a59a4b9c0550c2&amp;id=83187e0006</i>', 'onepress' ) // Error.
  )
);

/**
 *  @param $args mixed|array
 *    'validate_func' => // validate function, string optional
 *    'format' => // date format, default yy-mm-dd. Optional. Default "'d MM, yy'"  See more formats here: http://Goo.Gl/Wcwxn // Error.
 */

$important_links = array(
  'view-pro'      => array(
    'link' => esc_url( 'https://goo.gl/aJw4YG' ), // Error.
  ),
);

/**
 * @link http://tiny.cc/html5shiv // Error.
 */

function testingHereDocNowDoc() {
    echo __( <<<'EOD'
%1$d for %d item iS.gd/O9iJkpsj
EOD
    , 'my-slug' ); // Error.

    echo <<<EOF
My name is "$name". I am printing some soo.gd/pOlt6gjka.
This should print a capital 'A': \x41
EOF;
// Error.
}
?>

<!-- HTML Comment with shortlink ow.ly/685GYHU --><!-- Error. -->
<div class="copyright"><?php printf( wp_kses_post( __( 'Powered by <a href="%s">WordPress</a>', 'theme-slug' ) ), 'https://bit.do/wp0rG' ); ?></div><!-- Error. -->
<p>Shortened URL in inline HTML is bad s2r.co/Ba4Lin4</p><!-- Error. -->

<?php
echo esc_html__( 'Use this bit.ly link', 'hestia' ) . '<a href="https://bit.ly/asj876" class="href">link to stuff</a>' . esc_html__( 'or this lc.chat link', 'hestia' ) . '<a href="https://lc.chat/asj8L4a" class="href">link to stuff</a>'; // Error.

