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
