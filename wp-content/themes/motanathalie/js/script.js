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
});
