<?php
// ********************************************************************************************************
//                                     RÉCUPÉRATION DES DONNÉES DE L’IMAGE
//                                    - ID de l'image
//                                    - Version medium
//                                    - Version full (utile si besoin pour lightbox)
//                                    - Texte alternatif
//    ********************************************************************************************************

$image_id     = get_post_thumbnail_id();                               // ID de l'image mise en avant
$image_medium = wp_get_attachment_image_src($image_id, 'medium');       // URL + dimensions (format medium)
$image_full   = wp_get_attachment_image_src($image_id, 'full');         // URL + dimensions (format full)
$image_alt    = get_post_meta($image_id, '_wp_attachment_image_alt', true); // Alt de l'image
?>

<?php if ($image_medium) : ?> <!-- Vérifie qu’il existe bien une image -->

  <div class="motanathalie-photo">

    <!-- ***********************************************************************************
          LIEN CLIQUABLE vers la page de la photo
        *********************************************************************************** -->


    <a href="<?php the_permalink(); ?>" class="photo-link">

      <?php

        // ******************************************************************************
        //                              AFFICHAGE DE L'IMAGE
        //                             Utilisation de wp_get_attachment_image() :
        //                             - Permet une gestion propre du srcset
        //                             - Génère automatiquement les attributs size
        //                             - Alt correct : priority = meta alt, fallback = titre
        //    ******************************************************************************


        echo wp_get_attachment_image(
          $image_id,
          'medium',
          false,
          [
            'class' => 'photo-thumb',
            'alt'   => $image_alt ?: get_the_title(), // Si pas d’alt, utilise le titre
          ]
        );
      ?>

      <!-- **********************************************************************************
                                        OVERLAY AU SURVOL
                                       S’affiche uniquement au hover.
                                       Contient :
                                       - une icône œil
                                       - le titre de la photo
          ********************************************************************************** -->


      <div class="photo-hover" aria-hidden="true">

        <!-- Icône “œil” -->
        <svg xmlns="http://www.w3.org/2000/svg"
             class="eye-icon"
             width="80" height="80"
             viewBox="0 0 24 24"
             fill="none"
             stroke="white"
             stroke-width="2">
          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
          <circle cx="12" cy="12" r="3"/>
        </svg>

        <!-- Titre affiché au survol -->
        <p class="photo-hover-title"><?php the_title(); ?></p>
      </div>

    </a>

  </div>

<?php endif; ?>
