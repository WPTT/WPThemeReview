<?php
/**
 * Unit test for required functions in HTML tags.
 *
 * This tests language_attributes(), and body_class() requirements.
 */
echo '<html>'; // Bad.
echo '<body>'; // Bad.
?>
<html> <!-- Bad. -->
<html <?php language_attributes(); ?> lang="en-US"> <!-- Bad. -->
<?php
	echo '<html lang="en-US" '; // Bad.
	language_attributes();
	echo '>';
?>
<?php
	echo '<html '; // Ok.
	language_attributes();
	echo '>';
?>
<html <?php language_attributes(); ?> lang="en-US"> <!-- Bad. -->
<?php echo '<body class="body-test" ', body_class(), '>'; // Bad. ?>
<body> <!-- Bad. -->
<?php echo '<body>'; // Bad. ?>
<?php echo '<body class="body-test" ' . body_class() . '>'; // Bad. ?>
<?php echo '<body class="body-test" ', body_class(), '>'; // Bad. ?>
<html <?php language_attributes(); ?>> <!-- Ok. -->
<html <?php language_attributes(); ?> class="html-class"> <!-- Ok. -->
<?php echo '<body id="body-test" ' . body_class() . '>'; // Ok. ?>
<?php echo '<body id="body-test" ', body_class(), '>'; // Ok. ?>
<body <?php body_class(); ?>> <!-- Ok. -->

<?php
// Test common invalid heredoc style.
$html = <<<EOT
<!-- Bad. -->
	<body>
		...
	</body>
EOT;

// Test weird but valid heredoc style.
$html = <<<EOT
<!-- Ok. -->
<body
EOT;
body_class();
$html = <<<EOT
>
		...
EOT;
?>
