<article class="photo-item">
   <div class="photo-thumbnail">

      <?php
        // Récupérer la catégorie (taxonomie)
        $categories = get_the_terms(get_the_ID(), 'categorie');
        $categorie_name = $categories && !is_wp_error($categories) ? esc_attr($categories[0]->name) : '';
      ?>

      <img src="<?php the_post_thumbnail_url('medium'); ?>" 
           alt="<?php the_title_attribute(); ?>" 
           data-ref="<?php the_field('reference'); ?>" 
           data-categorie="<?php echo $categorie_name; ?>">

      <!-- Icône centrale pour ouvrir la page -->
      <a href="<?php the_permalink(); ?>" class="eye-btn" aria-label="Voir les détails de la photo">
          <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
            <circle cx="12" cy="12" r="3"/>
          </svg>
      </a>

      <!-- Icône optionnelle -->
      <div class="icon-top">
        <i class="fa-solid fa-expand"></i>
      </div>

      <!-- Info au survol -->
      <div class="photo-hover-info">
        <h3 class="photo-title"><?php the_title(); ?></h3>
        <?php
          if ($categories && !is_wp_error($categories)) {
            echo '<div class="photo-categories">';
            foreach ($categories as $cat) {
              echo '<a href="' . esc_url(get_term_link($cat)) . '" class="photo-cat">' . esc_html($cat->name) . '</a>';
            }
            echo '</div>';
          }
        ?>
      </div>

   </div>

   <h2 class="photo-title"><?php the_title(); ?></h2>
</article>
