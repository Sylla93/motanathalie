jQuery(document).ready(function($) {

  /* ******************* EFFET HOVER SUR LES PHOTOS******************* */
  function initPhotoHover() {
    $('.photo-item').each(function() {
      const $photo = $(this);
      const $hoverInfo = $photo.find('.photo-hover-info');

      // Supprime les anciens événements pour éviter les doublons
      $photo.off('mouseenter mouseleave');

      // Ajoute les effets de survol
      $photo.on('mouseenter', function() {
        $hoverInfo.fadeIn(200);
      });
      $photo.on('mouseleave', function() {
        $hoverInfo.fadeOut(200);
      });
    });
  }

  // Activation des effets hover au chargement
  initPhotoHover();



  /*************** MODALE DE CONTACT (ouverture / fermeture)********************* */

  const modal = document.getElementById("contact-modal");
  const closeBtn = modal ? modal.querySelector(".modal-close") : null;

  // Tous les boutons "Contact" sous les photos
  const contactBtns = document.querySelectorAll(".contact-btn");

  // Lien "Contact" dans le menu
  const menuContactLink = document.querySelector('a[href="#contact-modal"]:not(.contact-btn)');

  // Fonction d’ouverture de la modale
  function openModal(reference = "") {
    if (!modal) return;

    modal.classList.add("active");

    // Délai pour laisser Contact Form 7 initialiser
    setTimeout(() => {
      const refInput = document.getElementById("reference-photo");
      if (refInput) {
        refInput.value = reference;
      }
    }, 200);
  }

  // Ouverture via boutons "Contact"
  contactBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      const reference = btn.getAttribute("data-reference");
      openModal(reference);
    });
  });

  // Ouverture via le menu
  if (menuContactLink) {
    menuContactLink.addEventListener("click", (e) => {
      e.preventDefault();
      openModal();
    });
  }

  // Fermeture via la croix
  if (closeBtn) {
    closeBtn.addEventListener("click", () => modal.classList.remove("active"));
  }

  // Fermeture en cliquant à l’extérieur
  window.addEventListener("click", (e) => {
    if (e.target === modal) modal.classList.remove("active");
  });



  /* ****************** AJAX : CHARGEMENT + FILTRES DES PHOTOS********************** */
  const $archive = $('#photo-archive');
  const $button = $('#load-more');
  const $cat = $('.categorie');
  const $format = $('.format');
  const $trier = $('.trier');

  // Si pas d’archive ou pas de bouton → on arrête
  if (!$archive.length || !$button.length) return;

  let page = 1;
  let loading = false;

  // Fonction de récupération AJAX des photos
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

          // Ajout / remplacement des photos
          if (reset) {
            $archive.html(response);
          } else {
            $archive.append(response);
          }

          // Réinitialisation bouton
          $button.text('Charger plus').show();

          // Replace le bouton en bas
          $('.gallery-wrapper').append($('.button'));

          // Réactive hover + lightbox
          if (typeof initPhotoHover === "function") initPhotoHover();
          if (typeof initLightbox === "function") initLightbox();

        } else {

          // Aucun résultat
          if (reset) $archive.html('<p>Aucune photo trouvée.</p>');
          $button.text('Charger plus'); // on ne cache pas le bouton
        }
      },
      complete: function() {
        loading = false;
      }
    });
  }

  // Clic sur “Charger plus”
  $button.off('click').on('click', function() {
    page++;
    fetchPhotos(false);
  });

  // Changement des filtres
  $cat.off('change').on('change', function() { fetchPhotos(true); });
  $format.off('change').on('change', function() { fetchPhotos(true); });
  $trier.off('change').on('change', function() { fetchPhotos(true); });



  /* *********************** DROPDOWN PERSONNALISÉ (3 filtres)*************************** */

  function getCustomFilterValue(id) {
    const selected = document.querySelector(id + ' .selected');
    return selected ? selected.getAttribute('data-value') : '';
  }

  document.querySelectorAll('.custom-dropdown').forEach(function(dropdown){

    const selected = dropdown.querySelector('.selected');
    const selectedText = selected.querySelector('.selected-text');
    const options = dropdown.querySelector('.options');

    // Ouvre/ferme le dropdown
    selected.addEventListener('click', function() {
      dropdown.classList.toggle('active');
    });

    // Sélection d’une option
    options.querySelectorAll('li').forEach(function(option){
      option.addEventListener('click', function(){

        // Nettoyage visuel
        options.querySelectorAll('li').forEach(li => {
          li.classList.remove('selected-option');
          if (li !== option && li.hasAttribute('data-value')) {
            li.classList.add('already-selected');
          }
        });

        // Marque la nouvelle option
        option.classList.add('selected-option');
        option.classList.remove('already-selected');

        // Met à jour le texte affiché
        selectedText.textContent = option.textContent;

        // Met à jour la valeur
        selected.setAttribute('data-value', option.getAttribute('data-value'));

        // Ferme le dropdown
        dropdown.classList.remove('active');

        // Récupère les nouvelles valeurs
        const categorie = getCustomFilterValue('#categorie-dropdown');
        const format = getCustomFilterValue('#format-dropdown');
        const trier = getCustomFilterValue('#trier-dropdown');

        // Envoie AJAX des nouveaux filtres
        fetchPhotosAjax(categorie, format, trier);
      });
    });

    // Fermer en cliquant hors du dropdown
    document.addEventListener('click', function(e){
      if(!dropdown.contains(e.target)) dropdown.classList.remove('active');
    });
  });



  /* ****************AJAX DES 3 FILTRES PERSONNALISÉS***************** */
  function fetchPhotosAjax(categorie, format, trier) {
    $.ajax({
      url: load_more_params.ajaxurl,
      type: 'POST',
      data: {
        action: 'filter_photos',
        page: 1,
        categorie: categorie,
        format: format,
        order: trier,
      },
      beforeSend: function() {
        $('#photo-archive').html('<p>Chargement...</p>');
      },
      success: function(response) {
        $('#photo-archive').html(response);
      }
    });
  }

});
