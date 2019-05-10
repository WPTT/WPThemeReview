<?php
get_header();
?>
  <section id="primary" class="content-area tag">
    <main id="main" class="site-main">
      <?php
      while ( have_posts() ) :
        the_post();
        get_template_part( 'template-parts/content', 'tag' );
        if ( comments_open() || get_comments_number() ) {
          comments_template();
        }
      endwhile;
      ?>
    </main>
  </section>
<?php
get_footer();
