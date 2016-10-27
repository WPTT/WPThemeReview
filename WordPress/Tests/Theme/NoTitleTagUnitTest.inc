<?php
/**
 * Unit test for the title tag. 
 * The title tag is not allowed, unless it is used in an svg element.
 */

echo '<title>'; // Bad.
?>
<title> <!-- Bad. -->

<svg width="500" height="300" xmlns="http://www.w3.org/2000/svg">
	<g>
		<title>SVG Title Demo example</title> <!-- Ok. -->
		<rect x="10" y="10" width="200" height="50" style="fill:none; stroke:blue; stroke-width:1px"/>
	</g>
</svg>


Some content before the svg tag <title>my title</title> and some more content <svg width="500" height="300" xmlns="http://www.w3.org/2000/svg"> <!-- Bad. -->
	<g>
		<title>SVG Title Demo example</title> <!-- Ok. -->
		<rect x="10" y="10" width="200" height="50" style="fill:none; stroke:blue; stroke-width:1px"/>
	</g>
</svg> Some content after the svg tag <title>my title</title> and some more content <!-- Bad. -->

<title>my title</title> <svg width="500" height="300" >...</svg> <!-- Bad. -->

<svg width="500" height="300" >...</svg> <title>my title</title> <!-- Bad. -->

<title>my title</title> <svg width="500" height="300" >...</svg> <title>my title</title> <!-- Bad. -->

<?php
echo '
	<title>my title</title>' .  /* Bad. */ . '
	<svg width="500" height="300" >
		...
	</svg> <title>my title</title>'; // Bad.
