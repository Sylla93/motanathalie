<?php get_header(); ?>

<!-- *******************TAXONOMY*************** -->
 <?php get_header(); ?>

<div class="choisir">
  <!-- Filtre Catégories -->
  <div>
    <select class="categorie" id="filter_categorie">
      <option value="">Catégories</option>
      <option value="[translate:Réception]">[translate:Réception]</option>
      <option value="[translate:Concert]">[translate:Concert]</option>
      <option value="[translate:Mariage]">[translate:Mariage]</option>
      <option value="[translate:Télévision]">[translate:Télévision]</option>
    </select>
  </div>

  <!-- Filtre Formats -->
  <div>
    <select class="format" id="filter_format">
      <option value="">Formats</option>
      <option value="[translate:paysage]">[translate:paysage]</option>
      <option value="[translate:portrait]">[translate:portrait]</option>
    </select>
  </div>

  <!-- Filtre Trier par -->
  <div>
    <select class="trier" id="filter_trier">
      <option value="">[translate:Trier par]</option>
      <option value="[translate:Argentique]">[translate:Argentique]</option>
      <option value="[translate:Numérique]">[translate:Numérique]</option>
    </select>
  </div>
</div>


<!-- Ensuite ta boucle WP pour afficher les photos -->



<?php 
$args = array(
    'post_type' => 'photos',  // Remplace par le slug de ton CPT
    'posts_per_page' => 8
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
