<?php
/**
 * Unit test for the title tag. 
 * The title tag is not allowed, unless it is used in an svg element.
 */

echo '<title>';
?>
<title>

<svg width="500" height="300" xmlns="http://www.w3.org/2000/svg">
	<g>
		<title>SVG Title Demo example</title>
		<rect x="10" y="10" width="200" height="50" style="fill:none; stroke:blue; stroke-width:1px"/>
	</g>
</svg>
