<link rel="profile" href="http://gmpg.org/xfn/11">  <!-- OK -->
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">  <!-- OK -->
<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css' />  <!-- OK - Whitelisted URL -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>  <!-- Bad -->
<!-- <a ref="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" >Bootstrap</a> --> <!-- Bad -->
<!-- Here comes a link! --><a href="http://www.mysite.org">some string</a>  <!-- Bad -->

<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'textdomain' ) ); ?>">  <!-- OK: Whitlisted URL -->
<?php  echo 'WordPress'; ?>
</a>
<a href="<?php echo esc_url( __( 'https://example.org/', 'textdomain' ) ); ?>">  <!-- Bad -->
<?php echo 'Example'; ?>
</a>

<?php
/**
 * Theme Name: NoHardCodedUrls
 * Theme URI: https://mysite.org/themes/mytheme/          // OK
 * Author URI: https://mysite.org/                        // OK
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html  // OK
 */

wp_register_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' );  // Bad

$fonts_url = add_query_arg(
    array(
        'family' => urlencode( implode( '|', $fonts ) ),
        'subset' => urlencode( $subsets ),
    ),
    'https://fonts.googleapis.com/css' // OK
);

$foo = "https://mysite.wow.com/"."hello"; // Bad
// Comment test http://youtube.com   //OK
/////// Special comment test //mysite.com ////// //OK
$http_prefix1 = "http://"; // OK
$http_prefix2 = 'https://'; // OK
$http_prefix3 = "//";  // OK
$http_prefix1 = "http:"; // OK
$http_prefix2 = 'https:'; // OK
//hello.org // OK
_e( 'Theme by <a href="//mizmizi.com/">Mizmizi</a> Powered by WordPress', 'textdomain' ); // Bad
