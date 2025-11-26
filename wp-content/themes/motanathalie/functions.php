<?php

/* ==========================================================
   🐞 DEBUG : Liste tous les Custom Post Types chargés
   ========================================================== */
add_action('init', function() {
    $post_types = get_post_types([], 'objects');
    foreach ($post_types as $type => $obj) {
        error_log("CPT détecté : " . $type . " — " . $obj->label);
    }
});


/* ==========================================================
   📌 Enregistrement des menus (header et footer)
   ========================================================== */
function register_my_menus() {
    register_nav_menus(array(
        'header-menu' => __('Header Menu'), // Menu principal
        'footer-menu' => __('Footer Menu')  // Menu du footer
    ));
}
add_action('init', 'register_my_menus');


/* ==========================================================
   🖼️ Activation des images mises en avant
   ========================================================== */
function my_theme_setup() {
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'my_theme_setup');

// Empêche ACF de cacher les custom fields natifs
add_filter('acf/settings/remove_wp_meta_box', '__return_false', 20);


/* ==========================================================
   📷 Custom Post Type : Galerie
   ========================================================== */
function register_cpt_galerie() {
    register_post_type('galerie', [
        'labels' => [
            'name'          => 'Galeries',
            'singular_name' => 'Galerie'
        ],
        'public'      => true,
        'supports'    => ['title', 'thumbnail', 'editor'],
        'menu_icon'   => 'dashicons-format-gallery', // Icône WP Admin
    ]);
}
add_action('init', 'register_cpt_galerie');


/* ==========================================================
   📦 Chargement des scripts & styles du thème
   ========================================================== */
function motanathalie_enqueue_scripts() {

    // jQuery natif de WordPress
    wp_enqueue_script('jquery');

    // Script AJAX principal (chargement dynamique)
    wp_enqueue_script(
        'motanathalie-ajax',
        get_template_directory_uri() . '/js/script.js',
        array('jquery'),
        null,
        true
    );

    // Script du menu burger
    wp_enqueue_script(
        'motanathalie-burger',
        get_template_directory_uri() . '/js/burger.js',
        array(),
        null,
        true
    );

    // Script de la lightbox
    wp_enqueue_script(
        'motanathalie-lightbox',
        get_template_directory_uri() . '/js/lightbox.js',
        array('jquery', 'motanathalie-ajax'),
        null,
        true
    );

    // Style principal du thème
    wp_enqueue_style('motanathalie-style', get_stylesheet_uri());

    // Icônes Font Awesome
    wp_enqueue_style(
        'fontawesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css'
    );

    // Variable AJAX envoyée au JS (obligatoire pour WP AJAX)
    wp_localize_script('motanathalie-ajax', 'load_more_params', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'motanathalie_enqueue_scripts');


/* ==========================================================
   🔄 AJAX : Filtrage / Chargement des photos
   ========================================================== */
add_action('wp_ajax_filter_photos', 'filter_photos');       // Si utilisateur connecté
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos'); // Si utilisateur non connecté

function filter_photos() {

    // Page actuelle (pagination AJAX)
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;

    // Catégorie filtrée (si existe)
    $categorie = sanitize_text_field($_POST['categorie'] ?? '');

    // Requête WP Query
    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'paged'          => $page,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    // Filtrage par taxonomie "categorie"
    if (!empty($categorie)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'categorie',
                'field'    => 'slug',
                'terms'    => $categorie,
            )
        );
    }

    $query = new WP_Query($args);

    // Génération HTML retourné à AJAX
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Génère une photo exactement comme dans front-page.php
            ?>
            <article class="photo-item">

                <div class="photo-thumbnail">

                    <?php
                    // Catégorie principale
                    $categories = get_the_terms(get_the_ID(), 'categorie');
                    $categorie_name = $categories && !is_wp_error($categories)
                        ? esc_attr($categories[0]->name)
                        : '';
                    ?>

                    <!-- Image + données -->
                    <img src="<?php the_post_thumbnail_url('medium'); ?>"
                         alt="<?php the_title_attribute(); ?>"
                         data-ref="<?php the_field('reference'); ?>"
                         data-categorie="<?php echo $categorie_name; ?>">

                    <!-- Bouton oeil -->
                    <a href="<?php the_permalink(); ?>" class="eye-btn" aria-label="Voir les détails de la photo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </a>

                    <!-- Icône fullscreen -->
                    <div class="icon-top">
                        <i class="fa-solid fa-expand"></i>
                    </div>

                    <!-- Hover info -->
                    <div class="photo-hover-info">
                        <h3 class="photo-title"><?php the_title(); ?></h3>

                        <?php
                        // Liste des catégories
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
                    </div>

                </div>

                <!-- Titre sous la photo -->
                <h2 class="photo-title"><?php the_title(); ?></h2>

            </article>
            <?php
        }
    }

    wp_reset_postdata();
    wp_die(); // Fin obligatoire pour WP AJAX
}


/* ==========================================================
   🔧 REST API + Cache (permet React / Gutenberg / JS)
   ========================================================== */
add_action('init', function() {
    global $wp_taxonomies;

    // Expose la taxonomie "categorie" dans l’API REST
    if (isset($wp_taxonomies['categorie'])) {
        $wp_taxonomies['categorie']->show_in_rest = true;
    }

    // Expose la taxonomie "formats"
    if (isset($wp_taxonomies['formats'])) {
        $wp_taxonomies['formats']->show_in_rest = true;
    }

}, 20);

// Quand une photo est modifiée → vide le cache WP Fastest Cache
add_action('save_post_photo', function() {
    if (class_exists('WpFastestCache')) {
        $wpfc = new WpFastestCache();
        $wpfc->deleteCache();
    }
});
