jQuery(document).ready(function($) {
  // Ouverture de la popup et préremplissage
  $('.contact-btn, .btn-contact, .open-contact-modal').on('click', function() {
    var ref = $(this).data('photo-ref') || $(this).data('ref');
    const modal = $('#contactModal, #popup-contact');
    modal.show().css('display', 'flex');
    $('body').css('overflow', 'hidden');

    // Préremplir le champ
    modal.find('input[name="photo_ref"], #ref-photo').val(ref);
  });

  // Fermeture popup au clic sur bouton ou à l'extérieur
  $('#close-popup, .close').on('click', function() {
    $('#contactModal, #popup-contact').hide();
    $('body').css('overflow', '');
  });
  $('#contactModal, #popup-contact').on('click', function(e) {
    if (e.target === this) {
      $(this).hide();
      $('body').css('overflow', '');
    }
  });


  // *******************pagination infini*****************
  
  
      var page = 2; // on commence à la page 2 (1 déjà chargée)
      var loading = false;
  
      $(window).scroll(function(){
          if(loading) return;
  
          if($(window).scrollTop() + $(window).height() >= $(document).height() - 100) { // proche bas page
              loading = true;
              $.ajax({
                  url: ajaxurl, // défini automatiquement par WP si wp_localize_script est utilisé
                  type: 'POST',
                  data: {
                      action: 'load_more_photos',
                      page: page,
                  },
                  success: function(res) {
                      if(res) {
                          $('.photos-list').append(res);
                          page++;
                          loading = false;
                      } else {
                          // Plus de posts à charger
                          loading = true;
                      }
                  }
              });
          }
      });

    //   ****************TAXOMY*****************

  const filterCategorie = document.getElementById('filter_categorie');
  const filterFormat = document.getElementById('filter_format');
  const filterTrier = document.getElementById('filter_trier');

  function fetchPhotos() {
    const categorie = filterCategorie ? filterCategorie.value : '';
    const format = filterFormat ? filterFormat.value : '';
    const trier = filterTrier ? filterTrier.value : '';

    console.log("Filtres sélectionnés :", { categorie, format, trier });

    // Ici, tu feras l'appel Ajax vers WordPress REST API ou admin-ajax.php
    // pour récupérer et afficher les photos filtrées selon ces critères.
  }

  if (filterCategorie) {
    filterCategorie.addEventListener('change', fetchPhotos);
  }
  if (filterFormat) {
    filterFormat.addEventListener('change', fetchPhotos);
  }
  if (filterTrier) {
    filterTrier.addEventListener('change', fetchPhotos);
  }
});




