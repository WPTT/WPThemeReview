<?php
// Check for url shorteners used in themes. Examples found in existing theme repository.
$option_descriptions = array(
  $shortname . '_bitly_api_key' => array(
    'title'     => __('Bit.ly API Key', 'my-theme'),
    'desc'      => __('You can get your API Key in your <a href="https://bitly.com/a/account">bit.ly account</a> (you should to log in)', 'my-theme'), // BAD
  ),
);
// http://tinyurl.com/77w9wh // BAD
if (reshape) { // do this only if container has no size http://tinyurl.com/da2oa9 // BAD
$tinyurl = file_get_contents("http://tinyurl.com/api-create.php?url=".$url); // BAD
if ( $sib_account === true ) {
  echo '<br/>';
  echo '<a target="_blank" href="http://bit.ly/sibwp2" class="button" style="margin-top: 8px">' . esc_html__( 'Create SendinBlue Account', 'hestia' ) . '</a>'; // BAD
}
// http://bit.ly/magnific-popup#build=inline+image+ajax+iframe+gallery+retina+imagezoom // BAD
$wp_customize->add_control( 'onepress_newsletter_mailchimp',
  array(
    'label'       => esc_html__( 'MailChimp Action URL', 'onepress' ),
    'section'     => 'onepres_footer_top',
    'description' => __( 'The newsletter form use MailChimp, please follow <a target="_blank" href="http://goo.gl/uRVIst">this guide</a> to know how to get MailChimp Action URL. Example <i>//famethemes.us8.list-manage.com/subscribe/post?u=521c400d049a59a4b9c0550c2&amp;id=83187e0006</i>', 'onepress' ) // BAD
  )
);
/**
 *  Add Date Field to meta box
 *  @author Ohad Raz
 *  @since 1.0
 *  @access public
 *  @param $id string  field id, i.e. the meta key
 *  @param $args mixed|array
 *    'name' => // field name/label string optional
 *    'desc' => // field description, string optional
 *    'std' => // default value, string optional
 *    'validate_func' => // validate function, string optional
 *    'format' => // date format, default yy-mm-dd. Optional. Default "'d MM, yy'"  See more formats here: http://goo.gl/Wcwxn // BAD
 *  @param $repeater bool  is this a field inside a repeatr? true|false(default)
 */

$important_links = array(
  'view-pro'      => array(
    'link' => esc_url( 'https://goo.gl/aJw4YG' ), // BAD
    'text' => esc_html__( 'View Pro', 'miteri' ),
  ),
);

/**
 * IE enqueue HTML5shiv with conditionals
 * @link http://tiny.cc/html5shiv // BAD
 */
function larryslist_enqueue_html5shiv()
