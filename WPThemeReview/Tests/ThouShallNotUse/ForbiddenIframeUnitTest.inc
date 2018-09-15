<?php

echo 'This string should pass even if iframe is present.'; // OK.

echo '<iframe src="http://example.com" >'; // Error.
printf( "<iframe src=\"%s\" >", 'http://example.com' ); // Error.

// Error.
$template = <<<TEMPLATE
<p>Phasellus a aliquam sapien, sollicitudin feugiat dolor.</p>
<div>%1$s</div>
<iframe srcdoc="%2$s" name="%3$s">Your browser does not support iframes.</iframe>
<p>Cras purus nulla, scelerisque quis leo nec, pulvinar efficitur odio.</p>
TEMPLATE;
?>

<iframe src="http://example.com" > <!-- Error. -->
<IFRAME SRC="http://example.com" > <!-- Error. -->
Sometime iframe is not harmful. <!-- OK. -->

<?php
// Ensure no false positives when there are no attributes.
$accesspress_store_widgets_allowed_tags = '<iframe>';

$_html = strip_tags( $html, '<object><embed><iframe><video>' );
