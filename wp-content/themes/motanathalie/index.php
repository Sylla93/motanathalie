<?php get_header(); ?>

<?php
// Récupération des champs ACF sur la page en cours
$hero_image = get_field('hero_background', get_queried_object_id());
$hero_title = get_field('hero_title', get_queried_object_id());

// Définition de l'image de fond par défaut
if ($hero_image && isset($hero_image['url'])) {
  $hero_url = esc_url($hero_image['url']);
} else {
  $hero_url = get_template_directory_uri() . '/assets/images/default-hero.jpg';
}
?>

<section id="home-hero" style="background-image: url('<?php echo $hero_url; ?>');">
  <div class="home-hero-content">
    <h1>
      <?php 
      if ($hero_title) {
        echo esc_html($hero_title);
      } else {
        bloginfo('name');
      }
      ?>
    </h1>
  </div>
</section>

<!-- ********************************************* -->
 <div class="choisir">
  <!-- Filtre Catégories -->
  <div>
    <select class="categorie">
      <option value="">Catégories</option>
      <option value="">Réception</option>
      <option value="">Concert</option>
      <option value="">Mariage</option>
      <option value="">Télévision</option>
    </select>
  </div>

        <!-- Filtre Formats -->
     <div>
    <select  class="format">
      <option value="">Formats</option>
      <option value="video">paysage</option>
      <option value="article">portrait</option>
    </select>
  </div>

   <!-- Filtre Trier par -->
  <div>
    <select class="trier">
      <option value="recent">Trier par</option>
      <option value="popular">Argentique</option>
      <option value="alpha">Numérique</option>
    </select>
  </div>
      </div>


<main class="wrap">
  <section class="content-area content-thin">

    <!-- Boucle principale des articles -->
    <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
        <article class="article-loop">
          <header>
            <h2>
              <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php the_title(); ?>
              </a>
            </h2>
            Par : <?php the_author(); ?>
          </header>
          <?php the_excerpt(); ?>
        </article>
      <?php endwhile; ?>
    <?php else : ?>

    <?php endif; ?>

    <!-- Boucle pour le CPT "Photos" -->
    <?php
    $photos = new WP_Query(array(
      'post_type'      => 'photo', // slug exact du CPT
      'posts_per_page' => 8,
    ));

    if ($photos->have_posts()) :
      while ($photos->have_posts()) : $photos->the_post(); ?>
        <article class="photo-item">
          <h2><?php the_title(); ?></h2>

          <?php if (has_post_thumbnail()) : ?>
            <div class="photo-thumbnail">
              <?php the_post_thumbnail('medium'); ?>
            </div>
          <?php endif; ?>

          <div><?php the_content(); ?></div>
        </article>
      <?php endwhile;
      wp_reset_postdata();
    else :
      // echo '<p>Aucune photo trouvée.</p>';
    endif;
    ?>

  </section>
</main>

<?php get_footer(); ?>
