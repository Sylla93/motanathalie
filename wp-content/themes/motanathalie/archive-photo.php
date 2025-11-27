<?php get_header(); ?>

    <!-- ********************************************************************************************************
                                         CONTENU PRINCIPAL : ARCHIVE DES PHOTOS
    ******************************************************************************************************** -->


<main id="site-content">

  <!--  Titre automatique (nom de l’archive CPT) -->
  <h1><?php post_type_archive_title(); ?></h1>


  <!-- ********************************************************************************************************
                                   BLOC DE FILTRES PAR GENRE (TAXONOMIE : genre_photo)
      ******************************************************************************************************** -->


  <?php
  $terms = get_terms([
      'taxonomy'   => 'genre_photo', //  Remplacer par ton slug exact
      'hide_empty' => false,
  ]);

  // Vérifie que des termes existent
  if (!empty($terms) && !is_wp_error($terms)) : ?>
      
      <div class="photo-genres-filter">
          <h3>Genres :</h3>

          <ul class="genres-list">
              <?php foreach ($terms as $term) : ?>
                  <li>
                      <!--  Lien vers l’archive du terme -->
                      <a href="<?php echo esc_url(get_term_link($term)); ?>">
                          <?php echo esc_html($term->name); ?>
                      </a>
                  </li>
              <?php endforeach; ?>
          </ul>
      </div>

  <?php endif; ?>
  <!-- Fin filtres genres -->


<!-- 
  ******************************************************************************************************
       REQUÊTE PRINCIPALE POUR LES PHOTOS
      ****************************************************************************************************** -->


  <?php

  //  Récupération pagination actuelle
  $paged = get_query_var('paged') ? get_query_var('paged') : 1;

  //  Arguments de la requête personnalisée
  $args = array(
      'post_type'      => 'photo',  // CPT
      'posts_per_page' => 8,        // Nombre d’éléments par page
      'paged'          => $paged,   // Support de la pagination
  );

  $query = new WP_Query($args);
  

  // ***************************************************************************************
  //                                 SI des photos sont trouvées
  // ***************************************************************************************
  if ( $query->have_posts() ) : ?>

    <div id="photo-archive" class="photo-archive">

      <?php while ( $query->have_posts() ) : $query->the_post(); ?>


        <!-- ***********************************************************************************************
                                TEMPLATE PART unifié pour les blocs photo
                                (idéal pour DRY : même rendu partout)
            *********************************************************************************************** -->

        <?php get_template_part('template-parts/photo_block'); ?>

<!-- 
        **********************************************************************************************
                               BLOC fallback (si photo_block ne rend rien)
            ********************************************************************************************** -->


        <article class="photo-item">

          <!--  Lien vers la page de la photo -->
          <a href="<?php the_permalink(); ?>">

            <!--  Image mise en avant -->
            <?php
              if ( has_post_thumbnail() ) {
                the_post_thumbnail('medium');
              }
            ?>

            <!--  Titre -->
            <h2><?php the_title(); ?></h2>

          </a>

          <!-- ====================================================
               Affichage des genres liés à cette photo
               (taxonomie : genre_photo)
               ==================================================== -->
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

        </article>

      <?php endwhile; ?>

    </div><!-- /photo-archive -->


    <!-- ************************************************************************************************************
                                              PAGINATION STANDARD WORDPRESS
        ************************************************************************************************************ -->


    <?php
      the_posts_pagination([
          'total' => $query->max_num_pages,
      ]);
    ?>


  <?php else : ?>

      <!--  Aucun résultat -->
      <p>Aucune photo trouvée.</p>

  <?php endif; ?>


     <!-- ********************************************************************************************************
                                      BOUTON "CHARGER PLUS" (pour AJAX)
      ********************************************************************************************************* -->


  <?php if ($query->max_num_pages > 1) : ?>
    <button id="load-more"
            data-current-page="1"
            data-max-pages="<?php echo $query->max_num_pages; ?>">
      Charger plus
    </button>
  <?php endif; ?>


  <!-- Réinitialise la requête globale -->
  <?php wp_reset_postdata(); ?>

</main>

<?php get_footer(); ?>
