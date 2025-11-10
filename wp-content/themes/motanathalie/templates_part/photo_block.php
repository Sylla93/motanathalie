<article class="single-photo">
  <h1><?php the_title(); ?></h1>
  <?php if ( has_post_thumbnail() ) : ?>
    <div class="photo-thumbnail">
      <?php the_post_thumbnail('large'); ?>
    </div>
  <?php endif; ?>

  <?php
  $image = get_field('nom_du_champ_image');
  if ($image) :
  ?>
    <div class="acf-image">
      <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
    </div>
  <?php endif; ?>

  <!-- autres contenus -->
</article>
