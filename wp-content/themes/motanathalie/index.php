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
            echo $hero_title ? esc_html($hero_title) : get_bloginfo('name');
            ?>
        </h1>
    </div>
</section>

<!-- ********************************************************************************************************
                                FILTRES (Catégorie • Format • Trier)
******************************************************************************************************** -->
<div class="choisir">

    <!-- Filtre Catégories -->
    <div class="custom-dropdown categorie" id="categorie-dropdown">
        <div class="selected">
            <span class="selected-text">Catégories</span>
            <span class="dropdown-arrow catego"></span>
        </div>

        <ul class="options">
            <li data-value="">Catégories</li>

            <?php  
            $terms = get_terms([
                'taxonomy' => 'categorie',
                'hide_empty' => false
            ]);

            if (!empty($terms) && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    echo '<li data-value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</li>';
                }
            }
            ?>
        </ul>
    </div>

    <!-- Filtre Formats -->
    <div class="custom-dropdown format" id="format-dropdown">
        <div class="selected">
            <span class="selected-text">Formats</span>
            <span class="dropdown-arrow forma"></span>
        </div>

        <ul class="options">
            <li data-value="">Formats</li>

            <?php  
            $formats = get_terms([
                'taxonomy' => 'format',
                'hide_empty' => false
            ]);

            if (!empty($formats) && !is_wp_error($formats)) {
                foreach ($formats as $format) {
                    echo '<li data-value="' . esc_attr($format->slug) . '">' . esc_html($format->name) . '</li>';
                }
            }
            ?>
        </ul>
    </div>

    <!-- Filtre Tri -->
    <div class="custom-dropdown trier" id="trier-dropdown">
        <div class="selected">
            <span class="selected-text">Trier par</span>
            <span class="dropdown-arrow tri"></span>
        </div>

        <ul class="options">
            <li data-value="">Trier par</li>
            <li data-value="desc">Plus récentes</li>
            <li data-value="asc">Plus anciennes</li>
        </ul>
    </div>

</div><!-- /choisir -->

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


        <!-- ESPACE POUR GALERIE AJAX -->
        <div id="photo-archive"></div>

        <!-- BOUTON "Charger plus" -->
        <div class="gallery-wrapper">
            <button id="load-more" class="button">Charger plus</button>
        </div>

    </section>

</main>

<?php get_footer(); ?>
