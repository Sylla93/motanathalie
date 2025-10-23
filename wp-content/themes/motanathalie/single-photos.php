<?php get_header(); ?>

<div class="photo-container">
  <?php
  if (have_posts()) :
    while (have_posts()) : the_post(); ?>
      <h1 class="photo-title"><?php the_title(); ?></h1>
      <div class="photo-content">
        <?php the_content(); ?>
        <?php
        if (function_exists('get_field')) {
          $custom_field = get_field('mon_champ_personnalise');
          if ($custom_field) {
            echo '<p>' . esc_html($custom_field) . '</p>';
          }
        }
        ?>
      </div>
      <button class="contact-btn" data-photo-ref="<?php the_ID(); ?>">Contact</button>
    <?php endwhile;
  endif;
  ?>
</div>

<?php get_footer(); ?>
