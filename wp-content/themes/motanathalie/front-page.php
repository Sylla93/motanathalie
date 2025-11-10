<?php get_header(); ?>




 



 

<section class="hero" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/hero.jpg');"> 

  <div class="hero-content"> 

    <h1>PHOTOGRAPHE EVENT</h1> 

  </div> 

</section> 

<!-- ********************************************* -->


  <!-- ********************************************* -->
<!-- ********************************************* -->


<!-- Conteneur pour la galerie
<div id="photos-grid"></div> -->

<!-- Pagination -->
<!-- <button id="load-more" hidden>Charger plus</button> -->





 <div class="choisir">
   <!-- Filtre Catégories  -->
  <div>
  <select id="filter_categorie" class="categorie">
  <option value="">Catégories</option>
  <option value="Réception">Réception</option>
  <option value="Concert">Concert</option>
  <option value="Mariage">Mariage</option>
  <option value="Télévision">Télévision</option>
</select>
  </div>

        <!-- Filtre Formats -->
     <div>
   <select id="filter_format" class="format">
  <option value="">Formats</option>
  <option value="paysage">paysage</option>
  <option value="portrait">portrait</option>
</select>
  </div>

   <!-- Filtre Trier par -->
  <div>
<select id="filter_trier" class="trier">
  <option value="recent">Trier par</option>
  <option value="Argentique">Argentique</option>
  <option value="Numérique">Numérique</option>
</select>
  </div>
</div> 

<section>

  </section>
  <!-- <div class="galerie"></div> -->



<main class="wrap">
  <section class="content-area content-thin">

    <!-- Boucle principale des articles -->
    <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
    
      <?php endwhile; ?>
    <?php else : ?>

    <?php endif; ?>

    <!-- Boucle pour le CPT "Photos" -->
   <?php
//  Récupération des photos (8 maximum)
$photos = new WP_Query(array(
  'post_type'      => 'photo',
  'posts_per_page' => 8, // on limite à 8
  'paged'          => 1  // page initiale = 1
));

if ($photos->have_posts()) :
?>
  <section class="gallery-wrapper">
    <div id="photo-archive" class="photo-archive">
    <?php while ($photos->have_posts()) : $photos->the_post(); ?>
  <article class="photo-item">
   <div class="photo-thumbnail">
 <?php
//  Récupérer la catégorie (taxonomie)
$categories = get_the_terms(get_the_ID(), 'categorie');
$categorie_name = $categories && !is_wp_error($categories) ? esc_attr($categories[0]->name) : '';
?>
<img src="<?php the_post_thumbnail_url('medium'); ?>" 
     alt="<?php the_title_attribute(); ?>" 
     data-ref="<?php the_field('reference'); ?>" 
     data-categorie="<?php echo $categorie_name; ?>">


  <!--  Icône centrale pour ouvrir la lightbox -->
  <button class="fullscreen-btn" aria-label="Afficher la photo">
 <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
    <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
    <circle cx="12" cy="12" r="3"/>
  </svg>  </button>

  <!-- ⛶ Icône optionnelle en haut à droite -->
  <div class="icon-top">
    <i class="fa-solid fa-expand"></i>
  </div>


  <!-- Bloc titre + catégories affichés au hover -->
<div class="photo-hover-info">
  <h3 class="photo-title"><?php the_title(); ?></h3>
  <?php
  $categories = get_the_terms(get_the_ID(), 'categorie');
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
<?php endwhile; ?>


    <!--  Bouton Charger plus -->
    <?php if ($photos->max_num_pages > 1) : ?>
      <div class="button">
        <button id="load-more"
                data-current-page="1"
                data-max-pages="<?php echo $photos->max_num_pages; ?>">
          Charger plus
        </button>
      </div>
    <?php endif; ?>
  </section>
<?php endif; ?>

<?php wp_reset_postdata(); ?>


  </section>
</main>

<?php get_footer(); ?>
