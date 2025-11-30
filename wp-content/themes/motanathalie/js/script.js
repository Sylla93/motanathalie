jQuery(document).ready(function($) {

  /* ==================================================
        HOVER
  ================================================== */
  function initPhotoHover() {
    $('.photo-item').each(function() {
      const $photo = $(this);
      const $hoverInfo = $photo.find('.photo-hover-info');
      $photo.off('mouseenter mouseleave');
      $photo.on('mouseenter', function() { $hoverInfo.fadeIn(200); });
      $photo.on('mouseleave', function() { $hoverInfo.fadeOut(200); });
    });
  }
  initPhotoHover();



  /* ==================================================
        MODALE CONTACT
  ================================================== */
  const modal = document.getElementById("contact-modal");
  const closeBtn = modal ? modal.querySelector(".modal-close") : null;

  const contactBtns = document.querySelectorAll(".contact-btn");
  const menuContactLink = document.querySelector('a[href="#contact-modal"]:not(.contact-btn)');

  function openModal(reference="") {
    if (!modal) return;
    modal.classList.add("active");
    setTimeout(() => {
      const refInput = document.getElementById("reference-photo");
      if (refInput) refInput.value = reference;
    }, 200);
  }

  contactBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      openModal(btn.getAttribute("data-reference"));
    });
  });

  if (menuContactLink)
    menuContactLink.addEventListener("click", (e)=>{ e.preventDefault(); openModal(); });

  if (closeBtn)
    closeBtn.addEventListener("click", () => modal.classList.remove("active"));

  window.addEventListener("click", (e)=>{
    if (e.target === modal) modal.classList.remove("active");
  });




  /* ==================================================
        🔥 SYSTEME FILTRES + AJAX (VERSION FIX)
  ================================================== */

  function getFilterValues() {
    return {
      categorie: $('#categorie-dropdown .selected').attr('data-value') || '',
      format: $('#format-dropdown .selected').attr('data-value') || '',
      order: $('#trier-dropdown .selected').attr('data-value') || 'desc'
    };
  }

  window.currentPage = 1;

  function fetchPhotosAjax(resetPage = true) {

    const filters = getFilterValues();

    $.ajax({
      url: load_more_params.ajaxurl,
      type: 'POST',
      data: {
        action: 'filter_photos',
        page: resetPage ? 1 : window.currentPage,
        categorie: filters.categorie,
        format: filters.format,
        order: filters.order,
      },
      beforeSend: function() {
        if (resetPage) $('#photo-archive').html('<p>Chargement...</p>');
        $('#load-more').text('Chargement...');
      },
      success: function(response) {

        if (resetPage) {
          $('#photo-archive').html(response);
          window.currentPage = 1;
        } else {
          $('#photo-archive').append(response);
        }

        $('#load-more').text('Charger plus');

        initPhotoHover();
        if (typeof initLightbox === "function") initLightbox();
      }
    });
  }


  /* ============================================
        Load More
  ============================================ */
  $('#load-more').off('click').on('click', function() {
    window.currentPage++;
    fetchPhotosAjax(false);
  });


  /* ============================================
        DROPDOWNS PERSONNALISÉS
  ============================================ */
  document.querySelectorAll('.custom-dropdown').forEach(function(dropdown){

      const selected = dropdown.querySelector('.selected');
      const selectedText = dropdown.querySelector('.selected-text');
      const options = dropdown.querySelector('.options');

      selected.addEventListener('click', function() {
        dropdown.classList.toggle('active');
      });

      options.querySelectorAll('li').forEach(function(option){
        option.addEventListener('click', function(){

          options.querySelectorAll('li').forEach(li => li.classList.remove('selected-option'));
          option.classList.add('selected-option');

          selectedText.textContent = option.textContent;
          selected.setAttribute('data-value', option.getAttribute('data-value'));

          dropdown.classList.remove('active');

          fetchPhotosAjax(true);
        });
      });

      document.addEventListener('click', function(e){
        if(!dropdown.contains(e.target)) dropdown.classList.remove('active');
      });
  });

});
