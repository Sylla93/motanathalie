<?php get_header(); ?>

<!-- ==========================================================
      SECTION HERO (Image + titre principal)
     ========================================================== -->
<section class="hero" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/hero.jpg');"> 
  <div class="hero-content"> 
    <h1>PHOTOGRAPHE EVENT</h1>
  </div>
</section>


<!-- ==========================================================
      FILTRES (Catégorie • Format • Trier)
     ========================================================== -->
<div class="choisir">

  <!--  Filtre : Catégories -->
  <div class="custom-dropdown categorie" id="categorie-dropdown">
      <div class="selected">
        <span class="selected-text">Catégories</span>
        <span class="dropdown-arrow catego"></span>
      </div>

      <!-- Options de catégories (taxonomie personnalisée) -->
      <ul class="options">
        <li data-value="">Catégories</li>
        <li data-value="Reception">Réception</li>
        <li data-value="Concert">Concert</li>
        <li data-value="Mariage">Mariage</li>
        <li data-value="Television">Télévision</li>
      </ul>
  </div>

  <!-- 🔸 Filtre : Formats -->
  <div class="custom-dropdown format" id="format-dropdown">
    <div class="selected">
      <span class="selected-text">Formats</span>
      <span class="dropdown-arrow forma"></span>
    </div>

    <ul class="options">
      <li data-value="">Formats</li>
      <li data-value="paysage">Paysage</li>
      <li data-value="portrait">Portrait</li>
    </ul>
  </div>

  <!-- 🔸 Filtre : Tri -->
  <div class="custom-dropdown trier" id="trier-dropdown">
    <div class="selected">
      <span class="selected-text">Trier par</span>
      <span class="dropdown-arrow tri"></span>
    </div>

    <ul class="options">
      <li data-value="recent">Trier par</li>
      <li data-value="Argentique">Argentique</li>
      <li data-value="Numérique">Numérique</li>
    </ul>
  </div>

</div> <!-- /choisir -->



<!-- ==========================================================
     🧱 STRUCTURE PRINCIPALE DE LA PAGE
     ========================================================== -->
<main class="wrap">

  <!-- Encapsule la zone de contenu -->
  <section class="content-area content-thin">

    <!-- Boucle WordPress classique (inutile ici mais laissée pour WP) -->
    <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
      <?php endwhile; ?>
    <?php endif; ?>


    <!-- ======================================================
         🖼️ RÉCUPÉRATION DES 8 PREMIÈRES PHOTOS (CPT "photo")
         ====================================================== -->
    <?php
    $photos = new WP_Query([
      'post_type'      => 'photo',      // Custom Post Type
      'posts_per_page' => 8,            // Nombre initial d'images
      'paged'          => 1             // Page 1 pour AJAX
    ]);

    // Si des photos existent, on affiche la galerie
    if ($photos->have_posts()) :
    ?>
      <section class="gallery-wrapper">

        <!-- Conteneur qui sera remplacé par l'AJAX "Charger plus" -->
        <div id="photo-archive" class="photo-archive">


          <!-- 🔁 Boucle sur chaque photo -->
          <?php while ($photos->have_posts()) : $photos->the_post(); ?>

            <article class="photo-item">

              <div class="photo-thumbnail">

                <?php
                /* -------------------------------------------
                   📁 Récupère la première catégorie associée
                   ------------------------------------------- */
                $categories = get_the_terms(get_the_ID(), 'categorie');
                $categorie_name = $categories && !is_wp_error($categories)
                                  ? esc_attr($categories[0]->name)
                                  : '';
                ?>

                <!-- 📸 Image principale -->
                <img src="<?php the_post_thumbnail_url('medium'); ?>" 
                     alt="<?php the_title_attribute(); ?>" 
                     data-ref="<?php the_field('reference'); ?>" 
                     data-categorie="<?php echo $categorie_name; ?>">

                <!-- 👁️ Icône clic → page détail -->
                <a href="<?php the_permalink(); ?>" class="eye-btn">
                  <svg xmlns="http://www.w3.org/2000/svg"
                       width="80" height="80"
                       stroke="white" stroke-width="2">
                    <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
                    <circle cx="12" cy="12" r="3"/>
                  </svg>
                </a>

                <!-- ⛶ Icône fullscreen (lightbox) -->
                <div class="icon-top">
                  <i class="fa-solid fa-expand"></i>
                </div>

                <!-- 🟣 Informations affichées au survol -->
                <div class="photo-hover-info">
                  <h3 class="photo-title"><?php the_title(); ?></h3>

                  <?php
                  // Affichage des catégories
                  if ($categories && !is_wp_error($categories)) {
                      echo '<div class="photo-categories">';
                      foreach ($categories as $cat) {
                          echo '<a href="' . esc_url(get_term_link($cat)) . '" class="photo-cat">'
                              . $cat->name .
                          '</a>';
                      }
                      echo '</div>';
                  }
                  ?>
                </div>

              </div> <!-- /photo-thumbnail -->

              <!-- 🏷️ Titre sous la miniature -->
              <h2 class="photo-title"><?php the_title(); ?></h2>

            </article>

          <?php endwhile; ?>

        </div> <!-- /photo-archive -->


        <!-- ======================================================
             🔘 BOUTON "CHARGER PLUS" (si plusieurs pages)
             ====================================================== -->
        <?php if ($photos->max_num_pages > 1) : ?>
          <div class="button">
            <button id="load-more"
                    data-current-page="1"
                    data-max-pages="<?php echo $photos->max_num_pages; ?>">
              Charger plus
            </button>
          </div>
        <?php endif; ?>

      </section> <!-- /gallery-wrapper -->
    <?php endif; ?>

  </section> <!-- /content-area -->

  <?php wp_reset_postdata(); ?>

</main> <!-- /wrap -->


<?php get_footer(); ?>
