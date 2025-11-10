<?php get_header(); ?>

<main id="site-content">
  <h1><?php post_type_archive_title(); ?></h1>

  <!--  Bloc d’affichage des genres -->
  <?php
  $terms = get_terms([
      'taxonomy' => 'genre_photo', //  remplace par le slug exact de ta taxonomie
      'hide_empty' => false,
  ]);

  if (!empty($terms) && !is_wp_error($terms)) : ?>
      <div class="photo-genres-filter">
          <h3>Genres :</h3>
          <ul class="genres-list">
              <?php foreach ($terms as $term) : ?>
                  <li>
                      <a href="<?php echo esc_url(get_term_link($term)); ?>">
                          <?php echo esc_html($term->name); ?>
                      </a>
                  </li>
              <?php endforeach; ?>
          </ul>
      </div>
  <?php endif; ?>
  <!--  Fin de la liste des genres -->


  <?php
  $paged = get_query_var('paged') ? get_query_var('paged') : 1;
  $args = array(
      'post_type' => 'photo',
      'posts_per_page' => 8,
      'paged' => $paged,
  );
  $query = new WP_Query($args);

  if ( $query->have_posts() ) : ?>
    <div id="photo-archive"  class="photo-archive">
     
    <?php while ( $query->have_posts() ) : $query->the_post(); ?>

              <?php get_template_part('template-parts/photo_block'); ?>



        <article class="photo-item">
          <a href="<?php the_permalink(); ?>">
            <?php
              if ( has_post_thumbnail() ) {
                the_post_thumbnail('medium');
              }
            ?>
            <h2><?php the_title(); ?></h2>
          </a>

               <!--  Affiche les genres associés à chaque photo -->
                  <?php
                  $terms = get_the_terms(get_the_ID(), 'genre_photo');
                  if ($terms && !is_wp_error($terms)) {
                      echo '<ul class="photo-genres">';
                      foreach ($terms as $term) {
                          echo '<li>' . esc_html($term->name) . '</li>';
                      }
                      echo '</ul>';
                  }
                  ?>
                  <!--  Fin des genres -->



        </article>
      <?php endwhile; ?>
    </div>

    <?php
      // Pagination
      the_posts_pagination(array(
          'total' => $query->max_num_pages,
      ));
    ?>

  <?php else : ?>
    <p>Aucune photo trouvée.</p>

    <?php endif; ?>

   <!--  Bouton "Charger plus" en dehors de la boucle -->
   <?php if ($query->max_num_pages > 1) : ?>
  <button id="load-more"
          data-current-page="1"
          data-max-pages="<?php echo $query->max_num_pages; ?>">
    Charger plus
  </button>
<?php endif; ?>

  
  <?php wp_reset_postdata(); ?>
</main>

<?php get_footer(); ?>
