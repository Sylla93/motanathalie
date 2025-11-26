<article class="photo-item">

   <div class="photo-thumbnail">

      <?php
        /* ----------------------------------------------------------
            RÉCUPÉRATION DE LA CATÉGORIE PRINCIPALE
           - On récupère les termes de la taxonomie "categorie"
           - On prend le premier terme (catégorie principale)
           - On sécurise avec un test d’erreur
           ---------------------------------------------------------- */
        $categories = get_the_terms(get_the_ID(), 'categorie');
        $categorie_name = $categories && !is_wp_error($categories)
                          ? esc_attr($categories[0]->name)
                          : '';
      ?>

      <!-- ----------------------------------------------------------
            IMAGE PRINCIPALE DE LA PHOTO
           - Format medium
           - alt = titre de la photo
           - data-* = infos utilisées par la lightbox
           ---------------------------------------------------------- -->
      <img src="<?php the_post_thumbnail_url('medium'); ?>" 
           alt="<?php the_title_attribute(); ?>" 
           data-ref="<?php the_field('reference'); ?>" 
           data-categorie="<?php echo $categorie_name; ?>">

      <!-- ----------------------------------------------------------
            ICÔNE CENTRALE (Lien vers la page single)
           ---------------------------------------------------------- -->
      <a href="<?php the_permalink(); ?>" class="eye-btn" aria-label="Voir les détails de la photo">
          <svg xmlns="http://www.w3.org/2000/svg"
               width="80" height="80"
               fill="none" stroke="white" stroke-width="2"
               viewBox="0 0 24 24">
            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
            <circle cx="12" cy="12" r="3"/>
          </svg>
      </a>

      <!-- ----------------------------------------------------------
           ⛶ ICÔNE HAUT-DROITE (ouvre la lightbox)
           ---------------------------------------------------------- -->
      <div class="icon-top">
        <i class="fa-solid fa-expand"></i>
      </div>

      <!-- ----------------------------------------------------------
            HOVER INFO (Titre + catégories)
           - S'affiche au survol via CSS
           ---------------------------------------------------------- -->
      <div class="photo-hover-info">
        
        <!-- Titre -->
        <h3 class="photo-title"><?php the_title(); ?></h3>

        <?php
          /* ------------------------------------------------------
              LISTE DES CATÉGORIES (lors du hover)
             ------------------------------------------------------ */
          if ($categories && !is_wp_error($categories)) {
            echo '<div class="photo-categories">';

            foreach ($categories as $cat) {
              echo '<a href="' . esc_url(get_term_link($cat)) . '" class="photo-cat">'
                     . esc_html($cat->name) .
                   '</a>';
            }

            echo '</div>';
          }
        ?>

      </div> <!-- /photo-hover-info -->

   </div> <!-- /photo-thumbnail -->


   <!-- ----------------------------------------------------------
         TITRE AFFICHÉ SOUS LA MINIATURE
        ---------------------------------------------------------- -->
   <h2 class="photo-title"><?php the_title(); ?></h2>

</article>
