jQuery(document).ready(function($) {

  // ================================
  //  Fonction : effet hover sur les photos
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
  const modal = document.getElementById("contact-modal");
  const closeBtn = modal ? modal.querySelector(".modal-close") : null;
  const contactBtns = document.querySelectorAll(".contact-btn");
  const menuContactLink = document.querySelector('a[href="#contact-modal"]:not(.contact-btn)');

  //  Fonction pour ouvrir la modale
  function openModal(reference = "") {
    if (!modal) return;
    modal.classList.add("active");

    // Délai pour laisser CF7 charger le DOM
    setTimeout(() => {
      const refInput = document.getElementById("reference-photo");
      if (refInput) {
        refInput.value = reference || "";
        console.log(" Référence injectée :", reference);
      }
    }, 200);
  }

  //  Boutons "Contact" sous les photos
  contactBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      const reference = btn.getAttribute("data-reference");
      openModal(reference);
    });
  });

  //  Lien "Contact" du menu (ouvre sans référence)
  if (menuContactLink) {
    menuContactLink.addEventListener("click", (e) => {
      e.preventDefault();
      openModal();
    });
  }

  // Fermer la modale
  if (closeBtn) {
    closeBtn.addEventListener("click", () => modal.classList.remove("active"));
  }

  // 🔹 Fermer en cliquant à l’extérieur
  window.addEventListener("click", (e) => {
    if (e.target === modal) modal.classList.remove("active");
  });



const $archive = $('#photo-archive');
const $button = $('#load-more');
const $cat = $('.categorie');
const $format = $('.format');
const $trier = $('.trier');

if (!$archive.length || !$button.length) return;

let page = 1;
let loading = false;

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

                // ➕ Ajouter les nouvelles photos
                if (reset) {
                    $archive.html(response);
                } else {
                    $archive.append(response);
                }

                //  Réinitialise texte du bouton
                $button.text('Charger plus').show();

                //  Replace le bouton en bas de la galerie
                $('.gallery-wrapper').append($('.button'));

                // Réactive hover + lightbox
                if (typeof initPhotoHover === "function") initPhotoHover();
                if (typeof initLightbox === "function") initLightbox();

            } else {
                if (reset) {
                    $archive.html('<p>Aucune photo trouvée.</p>');
                }
                //  MAIS ON NE CACHE PAS LE BOUTON
                $button.text('Charger plus');
            }
        },
        complete: function() {
            loading = false;
        }
    });
}


//  Clic sur “Charger plus”
$button.off('click').on('click', function() {
    page++;
    fetchPhotos(false);
});


  //  Changement des filtres
  $cat.off('change').on('change', function() { fetchPhotos(true); });
  $format.off('change').on('change', function() { fetchPhotos(true); });
  $trier.off('change').on('change', function() { fetchPhotos(true); });



  // ***********************

  const burger = document.getElementById("burger-btn");
const menu = document.querySelector(".header-menu-class");

burger.addEventListener("click", () => {
  burger.classList.toggle("open");
  menu.classList.toggle("active");
});


// **********************************
// **********************************
// **********************************
function getCustomFilterValue(id) {
  const selected = document.querySelector(id + ' .selected');
  return selected ? selected.getAttribute('data-value') : '';
}

document.querySelectorAll('.custom-dropdown').forEach(function(dropdown){
  const selected = dropdown.querySelector('.selected');
  const selectedText = selected.querySelector('.selected-text');
  const options = dropdown.querySelector('.options');

  selected.addEventListener('click', function(e) {
    dropdown.classList.toggle('active');
  });

  options.querySelectorAll('li').forEach(function(option){
    option.addEventListener('click', function(){

      // 🔵 Marquer tous les anciens choix comme "déjà sélectionnés"
      options.querySelectorAll('li').forEach(li => {
        li.classList.remove('selected-option'); 
        if (li !== option && li.hasAttribute('data-value')) {
          li.classList.add('already-selected');
        }
      });

      // 🔴 Ajouter la classe du choix actuel
      option.classList.add('selected-option');
      option.classList.remove('already-selected');

      // Mise à jour du texte visible
      selectedText.textContent = option.textContent;

      // Mise à jour valeur
      selected.setAttribute('data-value', option.getAttribute('data-value'));

      // Fermer dropdown
      dropdown.classList.remove('active');

      // Récupération des filtres
      const categorie = getCustomFilterValue('#categorie-dropdown');
      const format = getCustomFilterValue('#format-dropdown');
      const trier = getCustomFilterValue('#trier-dropdown');

      fetchPhotosAjax(categorie, format, trier);
    });
  });

  document.addEventListener('click', function(e){
    if(!dropdown.contains(e.target)) dropdown.classList.remove('active');
  });
});

// Fonction AJAX adaptée à 3 filtres (jQuery requis)
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

