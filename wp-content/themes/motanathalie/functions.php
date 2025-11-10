<?php
// ============================
// 🔍 Debug : liste les CPT
// ============================
add_action('init', function() {
    $post_types = get_post_types([], 'objects');
    foreach ($post_types as $type => $obj) {
        error_log("CPT détecté : " . $type . " — " . $obj->label);
    }
});

// ============================
// 🎨 Feuille de style de base
// ============================
function mon_theme_styles() {
    wp_enqueue_style('mon-theme-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'mon_theme_styles');

// ============================
// 📜 Menus
// ============================
function register_my_menus() {
    register_nav_menus(array(
        'header-menu' => __('Header Menu'),
        'footer-menu' => __('Footer Menu')
    ));
}
add_action('init', 'register_my_menus');

// ============================
// 🖼️ Images à la une
// ============================
function my_theme_setup() {
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'my_theme_setup');

add_filter('acf/settings/remove_wp_meta_box', '__return_false', 20);

// ============================
// ⚙️ Custom Post Type : Galerie
// ============================
function register_cpt_galerie() {
    register_post_type('galerie', [
        'labels' => [
            'name' => 'Galeries',
            'singular_name' => 'Galerie'
        ],
        'public' => true,
        'supports' => ['title', 'thumbnail', 'editor'],
        'menu_icon' => 'dashicons-format-gallery',
    ]);
}
add_action('init', 'register_cpt_galerie');

// ============================
// 🔄 Charger les scripts & styles
// ============================
function motanathalie_enqueue_scripts() {
    wp_enqueue_script('jquery');

    // Script AJAX “Charger plus”
    wp_enqueue_script(
        'motanathalie-ajax',
        get_template_directory_uri() . '/js/script.js',
        array('jquery'),
        null,
        true
    );

    // Script Lightbox (doit dépendre de celui du dessus)
    wp_enqueue_script(
        'motanathalie-lightbox',
        get_template_directory_uri() . '/js/lightbox.js',
        array('jquery', 'motanathalie-ajax'),
        null,
        true
    );

    // Feuille de style principale
    wp_enqueue_style('motanathalie-style', get_stylesheet_uri());

    // Font Awesome pour les icônes
    wp_enqueue_style(
        'fontawesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css'
    );

    // Variable AJAX
    wp_localize_script('motanathalie-ajax', 'load_more_params', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'motanathalie_enqueue_scripts');

// ============================
// ⚡ Fonction AJAX “Charger plus” (avec icônes et data pour lightbox)
// ============================
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');

function filter_photos() {
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;

    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'paged'          => $paged,
    );

    // 🔹 Filtre Catégorie
    if (!empty($_POST['categorie'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_POST['categorie']),
        );
    }

    // 🔹 Filtre Format
    if (!empty($_POST['format'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_POST['format']),
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();

            $categories = get_the_terms(get_the_ID(), 'categorie');
            $categorie_name = $categories && !is_wp_error($categories)
                ? esc_attr($categories[0]->name)
                : '';
            ?>

            <article class="photo-item">
                <div class="photo-thumbnail">
                    <img src="<?php the_post_thumbnail_url('medium'); ?>"
                         alt="<?php the_title_attribute(); ?>"
                         data-ref="<?php the_field('reference'); ?>"
                         data-categorie="<?php echo $categorie_name; ?>">

                    <!-- Bouton œil -->
                    <button class="fullscreen-btn" aria-label="Afficher la photo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="none"
                             stroke="white" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>

                    <!-- Icône plein écran -->
                    <div class="icon-top">
                        <i class="fa-solid fa-expand"></i>
                    </div>

                    <!-- Bloc hover -->
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
            </article>

        <?php endwhile;
    endif;

    wp_reset_postdata();
    wp_die();
}

// ============================
// 🔧 REST API + Cache
// ============================
add_action('init', function() {
    global $wp_taxonomies;

    if (isset($wp_taxonomies['categorie'])) {
        $wp_taxonomies['categorie']->show_in_rest = true;
    }
    if (isset($wp_taxonomies['formats'])) {
        $wp_taxonomies['formats']->show_in_rest = true;
    }
}, 20);

add_action('save_post_photo', function() {
    if (class_exists('WpFastestCache')) {
        $wpfc = new WpFastestCache();
        $wpfc->deleteCache();
    }
});
