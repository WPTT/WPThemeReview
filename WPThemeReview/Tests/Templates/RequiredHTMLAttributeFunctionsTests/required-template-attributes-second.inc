<!-- Correct header example. -->
<html <?php language_attributes(); ?>> <!-- OK. -->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>"><!-- OK. -->
<meta name="description" content="something" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" /><!-- OK. -->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>><!-- OK. -->

<!-- Correct header example: multi-line calls and such. -->
<html
  <?php language_attributes(); ?>> <!-- OK. -->
<head>
<meta
  charset="<?php
    bloginfo( 'charset' );
  ?>"><!-- OK. -->
<meta name="description" content="something" />
<meta
  http-equiv="Content-Type"
  content="text/html; charset=<?php bloginfo( 'charset' ); ?>"
/><!-- OK. -->
<?php wp_head(); ?>
</head>
<body


  <?php
    body_class();
  ?>
><!-- OK. -->

<!-- Correct header example: bit convoluted code, but the output would be correct. -->
<html <?= get_language_attributes( 'html' ); ?>><!-- OK. -->
<head>
<meta charset="<?= get_bloginfo( 'charset' ); ?>"><!-- OK. -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body class="<?php echo implode( ' ', apply_filters( 'theme-body-class', get_body_class( 'additional-class' ), $pageID ) ); ?>"><!-- OK. -->

<!-- Incorrect header: missing function calls. -->
<html> <!-- Bad. -->
<head>
<?php wp_head(); ?>
</head>
<body><!-- Bad. -->

<!-- Incorrect header: attributes filled in. -->
<html lang="en-US"> <!-- Bad. -->
<head>
<meta charset="UTF-8"><!-- Bad. -->
<?php wp_head(); ?>
</head>
<body class="home paged"><!-- Bad. -->
