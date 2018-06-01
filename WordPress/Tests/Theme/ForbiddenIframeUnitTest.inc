<?php

echo 'This string should pass even if iframe is present.'; // OK.
echo 'Sometimes iframes are not harmful.'; // OK.
echo '<iframe src="http://example.com" >'; // Error.
printf( '<iframe src="%s" >, 'http://example.com' ); // Error.
?>
<iframe src="http://example.com" > // Error.
Sometime iframe is not harmful. // OK.
Sometimes iframes are not harmful. // OK.
