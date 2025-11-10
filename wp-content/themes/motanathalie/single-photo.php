<?php get_header(); ?>

<div class="photo-container">
  <?php if (have_posts()) :
    while (have_posts()) : the_post(); ?>

      <div class="photo-detail">

        <!-- =============================== -->
        <!--  Colonne gauche : texte + infos -->
        <!-- =============================== -->
        <div class="photo-infos">

          <!--  Titre principal -->
          <!-- <h1 class="photo-title"><?php the_title(); ?></h1> -->

          <!--  Contenu principal de l’article -->
          <div class="photo-content">
            <?php the_content(); ?>
          </div>

          

<!-- =============================== -->
<!-- 🧩 CHAMPS PERSONNALISÉS + DATE WORDPRESS -->
<!-- =============================== -->
<?php if (function_exists('get_field')) : ?> 
  <!-- Vérifie que le plugin Advanced Custom Fields est bien activé -->
  
<!-- =============================== -->
<!-- 🧩 CHAMPS PERSONNALISÉS + DATE WORDPRESS -->
<!-- =============================== -->
<div class="photo-acf">
            <h1 class="photo-title"><?php the_title(); ?></h1>
  <?php
  //  Champs ACF (si ACF est activé)
  if (function_exists('get_field')) {
    $reference = get_field('reference'); // Référence personnalisée
    $type      = get_field('type');      // Type personnalisé
  } else {
    $reference = ''; 
    $type = '';
  }

  //  Date native WordPress (date de publication du post)
  $annee = get_the_date('Y'); // Récupère uniquement l'année

  //  Référence
  if ($reference) {
    echo '<p><strong>Référence :</strong> ' . esc_html($reference) . '</p>';
  }

  //  Type
  if ($type) {
    echo '<p><strong>Type :</strong> ' . esc_html($type) . '</p>';
  }

  //  Année de publication (WordPress)
  if ($annee) {
    echo '<p><strong>Année :</strong> ' . esc_html($annee) . '</p>';
  }
  ?>



<?php endif; ?>


<!-- =============================== -->
<!-- 🏷️ TAXONOMIES : Catégorie & Format -->
<!-- =============================== -->
<?php
// 🔹 Taxonomie : Catégorie
$categories = get_the_terms(get_the_ID(), 'categorie');
if ($categories && !is_wp_error($categories)) {
  echo '<div class="photo-taxonomies">';
  echo '<h4>Catégories :</h4>';
  echo '<ul class="categories-list">';
  foreach ($categories as $cat) {
    // Affiche le nom de la catégorie sans lien cliquable
    echo '<li>' . esc_html($cat->name) . '</li>';
  }
  echo '</ul></div>';
}

// 🔹 Taxonomie : Format
$formats = get_the_terms(get_the_ID(), 'format');
if ($formats && !is_wp_error($formats)) {
  echo '<div class="photo-taxonomies">';
  echo '<h4>Formats :</h4>';
  echo '<ul class="formats-list">';
  foreach ($formats as $format) {
    // Affiche le nom du format sans lien cliquable
    echo '<li>' . esc_html($format->name) . '</li>';
  }
  echo '</ul></div>';
}
?>

        </div>

        </div>


        <!-- =============================== -->
        <!--  Colonne droite : photo -->
        <!-- =============================== -->
        <div class="photo-image">
          <?php if (has_post_thumbnail()) :
            the_post_thumbnail('large');
          endif; ?>
        </div>
      </div>

      <!-- =================================================== -->
      <!--  Zone "Photos apparentées" (même catégorie/format) -->
      <!-- =================================================== -->
      <section class="related-photos">
        <h2>Photos apparentées</h2>
        <div class="related-photos-list">
          <?php
          // Récupère les termes liés à la photo actuelle
          $cats    = wp_get_post_terms(get_the_ID(), 'categorie', array('fields' => 'ids'));
          $formats = wp_get_post_terms(get_the_ID(), 'format', array('fields' => 'ids'));

          // Construit la requête des photos apparentées
          $tax_queries = array('relation' => 'OR');

          if (!empty($cats)) {
            $tax_queries[] = array(
              'taxonomy' => 'categorie',
              'field'    => 'term_id',
              'terms'    => $cats,
            );
          }

          if (!empty($formats)) {
            $tax_queries[] = array(
              'taxonomy' => 'format',
              'field'    => 'term_id',
              'terms'    => $formats,
            );
          }

          // Requête WP_Query
          $args = array(
            'post_type'      => 'photo',
            'posts_per_page' => 2,
            'post__not_in'   => array(get_the_ID()), // exclut la photo actuelle
            'tax_query'      => $tax_queries,
          );

          $related_query = new WP_Query($args);

          // Affiche les photos apparentées
          if ($related_query->have_posts()) :
            while ($related_query->have_posts()) : $related_query->the_post(); ?>
              <article class="related-photo">
                <a href="<?php the_permalink(); ?>">
                  <?php if (has_post_thumbnail()) :
                    the_post_thumbnail('medium');
                  endif; ?>
                  <h3><?php the_title(); ?></h3>
                </a>
              </article>
            <?php endwhile;
          else :
            echo '<p>Aucune photo apparentée trouvée.</p>';
          endif;

          wp_reset_postdata();
          ?>
        </div>
      </section>

    <?php endwhile;
  else :
    echo '<p>Aucune photo trouvée.</p>';
  endif; ?>
</div>

<?php get_footer(); ?>
