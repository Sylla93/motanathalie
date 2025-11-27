<?php get_header(); ?>

<div class="photo-container">
  <?php if (have_posts()) :
    while (have_posts()) : the_post(); ?>

      <div class="photo-detail">

        <!-- ******************************************************************************************************** -->
        <!--                                 Colonne gauche : texte + infos -->
        <!-- ******************************************************************************************************** -->


        <div class="photo-infos">

          <!--  Titre principal -->
          <!-- <h1 class="photo-title"><?php the_title(); ?></h1> -->

          <!--  Contenu principal de l’article -->
          <div class="photo-content">
            <?php the_content(); ?>
          </div>

          

<!--  CHAMPS PERSONNALISÉS + DATE WORDPRESS -->

<div class="photo-acf">
  <h1 class="photo-title"><?php the_title(); ?></h1>

  <?php

  // ********************************************************************************************************************
  //                                        Champs personnalisés (ACF)
  // ********************************************************************************************************************


  if (function_exists('get_field')) {
    $reference = get_field('reference'); // Référence personnalisée
    $type      = get_field('type');      // Type personnalisé
  } else {
    $reference = '';
    $type      = '';
  }

  
  // Année (date WP)
  
  $annee = get_the_date('Y');

  
  //  Affichage des infos
  
  if ($reference) {
    echo '<p>Référence : ' . esc_html($reference) . '</p>';
  }

  // --- Catégories ---
  $categories = get_the_terms(get_the_ID(), 'categorie');
  if ($categories && !is_wp_error($categories)) {
    $categories_list = wp_list_pluck($categories, 'name');
    echo '<p>Catégories : ' . esc_html(implode(', ', $categories_list)) . '</p>';
  }

  // --- Formats ---
  $formats = get_the_terms(get_the_ID(), 'format');
  if ($formats && !is_wp_error($formats)) {
    $formats_list = wp_list_pluck($formats, 'name');
    echo '<p>Formats : ' . esc_html(implode(', ', $formats_list)) . '</p>';
  }

  // --- Type ---
  if ($type) {
    echo '<p>Type : ' . esc_html($type) . '</p>';
  }

  // --- Année ---
  if ($annee) {
    echo '<p>Année : ' . esc_html($annee) . '</p>';
  }
  ?>
</div>





        </div>


        <!-- ******************************************************************************************************* -->
        <!--                                         Colonne droite : photo -->
        <!-- ******************************************************************************************************* -->
        <div class="photo-image">
          <?php if (has_post_thumbnail()) :
            the_post_thumbnail('large');
          endif; ?>
        </div>
      </div>


      <!-- **********************CONTACT AVEC REFERENCE PHOTO**************************** -->

      <div class="photo-contact-section">
  <div class="contenubouton">
    <p class="contact-text">Cette photo vous intéresse ?</p>
   <a href="#contact-modal" 
       class="contact-btn" 
       data-reference="<?php the_field('reference'); ?>">
       Contact
    </a>
  </div>
  <div class="photo-contact-right">
  <?php 
    $prev_post = get_previous_post();
    $next_post = get_next_post();

    if ($prev_post || $next_post) :
  ?>
    <div class="photo-navigation">
      <div class="nav-thumbnail">
        <?php if ($next_post) echo get_the_post_thumbnail($next_post->ID, 'thumbnail'); ?>
      </div>

      <div class="arrows">
        <?php if ($prev_post): ?>
          <a href="<?php echo get_permalink($prev_post->ID); ?>" class="nav-arrow prev">&#8592;</a>
        <?php endif; ?>

        <?php if ($next_post): ?>
          <a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-arrow next">&#8594;</a>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>
</div>




</div>



      
                                    <!--  Zone "Photos apparentées" (même catégorie/format) -->
      
      <section class="related-photos">
        <h3>VOUS AIMEREZ AUSSI</h3>
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
