<?php
/* Template Name: Contact page template */

// code goes here

?>
  <div id="pageheader" class="titleclass">
    <div class="container">
      <?php get_template_part('templates/page', 'header'); ?>
    </div><!--container-->
  </div><!--titleclass-->
<?php if ($map == 'yes') { ?>
  <div id="pageheader" class="titleclass">
    <div class="container">
      <div id="map_address">
      </div>
    </div><!--container-->
  </div><!--titleclass-->
<?php } ?>
