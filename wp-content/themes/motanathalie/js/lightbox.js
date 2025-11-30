// /js/lightbox.js

document.addEventListener("DOMContentLoaded", function () {

  /* ==========================================================
     RÉFÉRENCES DES ÉLÉMENTS DE LA LIGHTBOX
     ========================================================== */
  const overlay       = document.getElementById("lightbox-overlay");
  const lightboxImg   = document.getElementById("lightbox-img");
  const lightboxTitle = document.getElementById("lightbox-title");
  const lightboxRef   = document.getElementById("lightbox-ref");
  const lightboxCat   = document.getElementById("lightbox-cat");
  const btnClose      = document.querySelector(".lightbox-close");
  const btnNext       = document.querySelector(".lightbox-next");
  const btnPrev       = document.querySelector(".lightbox-prev");

  let currentIndex = 0;


  /* ==========================================================
     IMAGES DYNAMIQUES RECONNUES (AJOUT DE related-photo-hover)
     ========================================================== */
  const getImages = () =>
    Array.from(
      document.querySelectorAll(
        ".photo-thumbnail img, .related-photo img, .related-photo-hover img"
      )
    );


  /* ==========================================================
     OUVERTURE
     ========================================================== */
  function openLightbox(index) {
    const images = getImages();
    const img = images[index];
    if (!img) return;

    lightboxImg.src = img.src;
    lightboxImg.alt = img.alt || "";
    lightboxTitle.textContent = img.alt || "Photo";
    lightboxRef.textContent   = img.dataset.ref || "Référence inconnue";
    lightboxCat.textContent   = img.dataset.categorie || "Catégorie inconnue";

    currentIndex = index;
    overlay.classList.remove("hidden");
  }


  /* ==========================================================
     FERMETURE
     ========================================================== */
  const closeLightbox = () => overlay.classList.add("hidden");


  /* ==========================================================
     NAVIGATION
     ========================================================== */
  function nextImage() {
    const images = getImages();
    currentIndex = (currentIndex + 1) % images.length;
    openLightbox(currentIndex);
  }

  function prevImage() {
    const images = getImages();
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    openLightbox(currentIndex);
  }


  /* ==========================================================
     DÉLÉGATION: CLIC FULLSCREEN
     ========================================================== */
  document.addEventListener("click", function (e) {

    const trigger = e.target.closest(".fullscreen-btn, .icon-top");
    if (!trigger) return;

    e.preventDefault();
    e.stopPropagation();

    /* ----------------------------------------------
       ⚠️  Correction majeure :
       on supporte maintenant also .related-photo-hover
       ---------------------------------------------- */
    let thumb =
      trigger.closest(".photo-thumbnail") ||
      trigger.closest(".related-photo") ||
      trigger.closest(".related-photo-hover");

    if (!thumb) return;

    const img = thumb.querySelector("img");
    if (!img) return;

    const images = getImages();
    const idx = images.indexOf(img);

    if (idx === -1) return;

    openLightbox(idx);
  });


  /* ==========================================================
     BOUTONS
     ========================================================== */
  btnNext?.addEventListener("click", (e) => {
    e.stopPropagation();
    nextImage();
  });

  btnPrev?.addEventListener("click", (e) => {
    e.stopPropagation();
    prevImage();
  });

  btnClose?.addEventListener("click", closeLightbox);


  /* ==========================================================
     FOND (clic)
     ========================================================== */
  overlay.addEventListener("click", (e) => {
    if (e.target === overlay) closeLightbox();
  });


  /* ==========================================================
     CLAVIER
     ========================================================== */
  document.addEventListener("keydown", (e) => {
    if (overlay.classList.contains("hidden")) return;

    if (e.key === "ArrowRight") nextImage();
    if (e.key === "ArrowLeft")  prevImage();
    if (e.key === "Escape")     closeLightbox();
  });

});
