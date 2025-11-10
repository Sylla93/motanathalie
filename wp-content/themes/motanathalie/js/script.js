jQuery(document).ready(function($) {

  // ================================
  // 🖱️ Fonction : effet hover sur les photos
  // ================================
  function initPhotoHover() {
    $('.photo-item').each(function() {
      const $photo = $(this);
      const $hoverInfo = $photo.find('.photo-hover-info');

      // Supprime les anciens événements pour éviter les doublons
      $photo.off('mouseenter mouseleave');

      // Ajoute l’effet de survol
      $photo.on('mouseenter', function() {
        $hoverInfo.fadeIn(200);
      });
      $photo.on('mouseleave', function() {
        $hoverInfo.fadeOut(200);
      });
    });
  }

  // Appliquer les hover dès le chargement initial
  initPhotoHover();

  // ***************************
  // OUVERTURE ET FERMETURE POPUP
  // ***************************
  const contactLink = document.querySelector('a[href="#contact-modal"]');
  const modal = document.getElementById("contact-modal");
  const closeBtn = modal ? modal.querySelector(".modal-close") : null;

  if (contactLink && modal) {
    contactLink.addEventListener("click", function(e) {
      e.preventDefault();
      modal.classList.add("active");
    });
  }

  if (closeBtn) {
    closeBtn.addEventListener("click", function() {
      modal.classList.remove("active");
    });
  }

  window.addEventListener("click", function(e) {
    if (e.target === modal) {
      modal.classList.remove("active");
    }
  });

  // ====================================
  // 🎛️ FILTRES + BOUTON CHARGER PLUS (AJAX)
  // ====================================
  const $archive = $('#photo-archive');
  const $button = $('#load-more');
  const $cat = $('.categorie');
  const $format = $('.format');
  const $trier = $('.trier');

  if (!$archive.length || !$button.length) return;

  let page = 1;
  let loading = false;
  const PER_PAGE = 8;

  function fetchPhotos(reset = false) {
    if (loading) return;
    loading = true;

    if (reset) {
      page = 1;
      $archive.html('');
    }

    $.ajax({
      url: load_more_params.ajaxurl,
      type: 'POST',
      data: {
        action: 'filter_photos',
        page: page,
        categorie: $cat.val() || '',
        format: $format.val() || '',
        order: $trier.val() || '',
      },
      beforeSend: function() {
        $button.text('Chargement...');
      },
      success: function(response) {
        if (response && $.trim(response).length > 0) {
          if (reset) {
            $archive.html(response);
          } else {
            $archive.append(response);
          }

          // ✅ Applique l’effet hover sur les nouvelles photos
          initPhotoHover();

          $button.text('Charger plus').show();

          const received = $(response).filter('.photo-item').length || $(response).find('.photo-item').length;
          if (received < PER_PAGE) {
            console.log("✅ Fin des résultats, on cache le bouton");
            $button.closest('.button').fadeOut(300, function() {
              $(this).remove();
            });
          }
        } else {
          if (reset) $archive.html('<p>Aucune photo trouvée.</p>');
          console.log("❌ Pas de contenu reçu, on cache le bouton");
          $button.closest('.button').fadeOut(300, function() {
            $(this).remove();
          });
        }
      },
      error: function(xhr, status, error) {
        console.error('❌ Erreur AJAX :', error);
      },
      complete: function() {
        loading = false;
      }
    });
  }

  // ▶️ Clic sur “Charger plus”
  $button.off('click').on('click', function() {
    page++;
    fetchPhotos(false);

    // 🔥 Cache immédiatement le bouton et sa div
    $(this).closest('.button').fadeOut(300, function() {
      $(this).remove();
    });
  });

  // ▶️ Changement des filtres
  $cat.off('change').on('change', function() { fetchPhotos(true); });
  $format.off('change').on('change', function() { fetchPhotos(true); });
  $trier.off('change').on('change', function() { fetchPhotos(true); });

});
