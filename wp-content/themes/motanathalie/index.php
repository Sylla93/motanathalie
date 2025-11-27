<?php get_header(); ?>

<?php

// ***************************************************************************************************************
//                                     HERO AVEC ACF (si utilisé sur une page statique)
// ***************************************************************************************************************

$hero_image = get_field('hero_background', get_queried_object_id());
$hero_title = get_field('hero_title', get_queried_object_id());

// Image par défaut
$hero_url = ($hero_image && isset($hero_image['url']))
    ? esc_url($hero_image['url'])
    : get_template_directory_uri() . '/assets/images/default-hero.jpg';
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


<!-- *************************************************************************************************************
                                         FILTRES (Catégorie • Format • Trier)
    ************************************************************************************************************* -->


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

  <!--  Filtre : Formats -->
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

  <!--  Filtre : Tri -->
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

<!-- *****************************************************************************************************************************
                                                    CONTENU PRINCIPAL
    ***************************************************************************************************************************** -->


<main class="wrap">

    <section class="content-area content-thin">

        <!-- BOUCLE PRINCIPALE (Articles classiques) -->
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                
                <article class="article-loop">

                    <header>
                        <h2>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                        <p>Par : <?php the_author(); ?></p>
                    </header>

                    <?php the_excerpt(); ?>

                </article>

            <?php endwhile; ?>
        <?php endif; ?>


        <!-- BOUCLE CPT "photo" (fallback simple) -->
        <?php
        $photos = new WP_Query([
            'post_type'      => 'photo',
            'posts_per_page' => 8
        ]);

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
        endif;
        ?>

    </section>

</main>

<?php get_footer(); ?>
