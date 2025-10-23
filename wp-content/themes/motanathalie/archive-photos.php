<?php get_header(); ?>

<?php 

$args = array(
    'post_type' => 'photos',  // Remplace par le slug de ton CPT
    'posts_per_page' => 8    // Affiche toutes les photos
);

$photos_query = new WP_Query($args);

if ($photos_query->have_posts()) : ?>
  <div class="photos-list">
    <?php while ($photos_query->have_posts()) : $photos_query->the_post(); ?>
      <div class="photo-item">
        <h2><?php the_title(); ?></h2>
        <div class="photo-thumbnail">
          <?php if (has_post_thumbnail()) {
            the_post_thumbnail('medium');
          } ?>
        </div>
        <div class="photo-excerpt">
          <?php the_excerpt(); ?>
        </div>
        <button class="contact-btn" data-photo-ref="<?php the_ID(); ?>">Contact</button>
      </div>
    <?php endwhile; ?>
  </div>
<?php else : ?>
  <p>Aucune photo trouvée.</p>
<?php endif; 

wp_reset_postdata();
?>

<?php get_footer(); ?>